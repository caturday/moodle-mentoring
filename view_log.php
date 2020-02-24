<?php
    require_once('../../config.php');
    require_once($CFG->dirroot . '/user/profile/lib.php');

    require_login(null, true, null);
    $PAGE->set_context(context_system::instance());
 
    $PAGE->set_url('/local/mentoring/view_log.php');
    $PAGE->set_title(get_string('page_name_viewlog', 'local_mentoring'));
    $PAGE->set_heading(get_string('page_name_viewlog', 'local_mentoring'));
    $PAGE->set_pagelayout('standard');

    $jquery_url = new moodle_url("/local/mentoring/js/jquery-3.4.1.min.js");
    $moment_url = new moodle_url("/local/mentoring/js/moment.min.js");
    $detail_url = new moodle_url("/local/mentoring/actions/get_detailed_log.php");

    global $DB;

    $traffic = $DB->get_recordset_sql("SELECT     mc.id, mc.timecreated, max(m.timecreated) as last_updated, mcm.userid, count(m.id) full_count, u.firstname, u.lastname, u.email
                                         FROM     (
                                                      SELECT DISTINCT m.conversationid
                                                      FROM {messages} m
                                                      WHERE m.subject = \"Request for Mentoring\"
                                                  ) m2 JOIN
                                                  {message_conversations} mc ON m2.conversationid = mc.id JOIN
                                                  {message_conversation_members} mcm ON mc.id = mcm.conversationid JOIN
                                                  {messages} m ON mc.id = m.conversationid JOIN
                                                  {user} u ON mcm.userid = u.id
                                        WHERE     mc.type = 1
                                        GROUP BY  mc.id, mc.timecreated, mc.timemodified, mcm.userid;");

    $message_table = new html_table();
    $message_table->head = array("", "Conversation between", "Began", "Last Activity", "Messages");
    $message_expander = "<a id=\"expander-%ID%\" class=\"expander\">&#9658;</a>";

    $conversations = array();

    foreach ($traffic as $m) {
        if (array_key_exists($m->id, $conversations)) {
            $conversations[$m->id] += [
                "u2_id"         => $m->userid,
                "u2_firstname"  => $m->firstname,
                "u2_lastname"   => $m->lastname,
                "u2_email"      => $m->email
            ];
        } else {
            $conversations[$m->id] = [
                "cid"           => $m->id,
                "created"       => $m->timecreated,
                "updated"       => $m->last_updated,
                "u1_id"         => $m->userid,
                "u1_firstname"  => $m->firstname,
                "u1_lastname"   => $m->lastname,
                "u1_email"      => $m->email,
                "full_count"    => $m->full_count
            ];
        }
    }
    $traffic->close();

    foreach ($conversations as $c) {
        $this_expander = str_replace("%ID%", $c["cid"], $message_expander);
        $u1 = "<a href=\"mailto:" . $c["u1_email"] . "\">" . $c["u1_firstname"] . " " . $c["u1_lastname"] . "</a>";
        $u2 = "<a href=\"mailto:" . $c["u2_email"] . "\">" . $c["u2_firstname"] . " " . $c["u2_lastname"] . "</a>";
        $message_table->data[] = array($this_expander, $u1 . " and " . $u2,
                                        date("n M Y", $c["created"]), date("n M Y", $c["updated"]), $c["full_count"]);
    }


?>
<?=$OUTPUT->header()?>
<style>
    .expander:hover {
        text-decoration: none;
        cursor: pointer;
    }
</style>
<script type="text/javascript" src="<?=$jquery_url?>"></script>
<script type="text/javascript" src="<?=$moment_url?>"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery(".expander").click(function() {
            var ids = this.id.split("-");
            toggle_detail(ids[1], this);
        });
    });

    function toggle_detail(id, control) {
        var parent_row = jQuery(control).parent().parent();
        var child_row = parent_row.next(".expanded");

        if (child_row.length) {
            if (child_row.is(":visible")) {
                jQuery(control).html("&#9658;");
                child_row.hide();
            }
            else {
                jQuery(control).html("&#9660;");
                child_row.show();
            }
        }
        else {
            jQuery.ajax({
                url: "<?=$detail_url?>",
                data: {
                    "id": id,
                },
                dataType: "json",
                type: "GET",
                success: function(data) {
                    jQuery(control).html("&#9660;");

                    content = "<table style=\"width: 100%;\">";
                    content += "<tr><th>Sender</th><th>Sent</th><th>Read</th></tr>";
                    jQuery.each(data, function() {
                        var sent = moment(this.timecreated*1000);
                        var sent_str = sent.format("YYYY-MM-DD HH:mm:ss");
                        var read = this.timeread !== null ? "&#10004;" : "&#10008;";

                        content += "<tr>";
                        content += "<td>" + this.firstname + " " + this.lastname + "</td>";
                        content += "<td>" + sent_str + "</td><td style=\"font-size: 2em;\">" + read + "</td>";
                        content += "</tr>";
                    });
                    content += "</table>";

                    parent_row.after("<tr class=\"expanded\"><td></td><td colspan=\"4\">" + content + "</td></tr>");
                }
            });
        }
    }
</script>
<h2>Exchanged Messages</h2>
<?=html_writer::table($message_table)?>
<?php
    echo $OUTPUT->footer();
?>
