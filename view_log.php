<?php
    require_once('../../config.php');
    require_once($CFG->dirroot . '/user/profile/lib.php');

    require_login(null, true, null);
    $PAGE->set_context(context_system::instance());
 
    $PAGE->set_url('/local/mentoring/view_log.php');
    $PAGE->set_title(get_string('page_name_viewlog', 'local_mentoring'));
    $PAGE->set_heading(get_string('page_name_viewlog', 'local_mentoring'));
    $PAGE->set_pagelayout('standard');

    $jquery_url = new moodle_url("/local/mentoring/js/jquery-3.3.1.min.js");
    $moment_url = new moodle_url("/local/mentoring/js/moment.min.js");
    $detail_url = new moodle_url("/local/mentoring/actions/get_detailed_log.php");

    global $DB;

    $traffic = $DB->get_recordset_sql("SELECT   u1.id as u1_id, u1.firstname as u1_firstname, u1.lastname as u1_lastname,
                                                u2.id as u2_id, u2.firstname as u2_firstname, u2.lastname as u2_lastname,
                                                min(m.timeread) as min_timeread, min(m.timecreated) as min_timecreated,
                                                max(m.timeread) as max_timeread, max(m.timecreated) as max_timecreated,
                                                count(*) as full_count
                                        FROM (
                                            SELECT  LEAST(mr.useridfrom, mr.useridto) as userid1, 
                                                    GREATEST(mr.useridfrom, mr.useridto) as userid2,
                                                    timeread, timecreated
                                            FROM {message_read} mr
                                            WHERE mr.subject = 'Request for Mentoring'
                                            UNION
                                            SELECT  LEAST(mu.useridfrom, mu.useridto) as userid1, 
                                                    GREATEST(mu.useridfrom, mu.useridto) as userid2,
                                                    NULL as timeread, timecreated
                                            FROM {message} mu
                                            WHERE mu.subject = 'Request for Mentoring'
                                        ) m JOIN {user} u1 ON m.userid1 = u1.id JOIN {user} u2 ON m.userid2 = u2.id
                                        GROUP BY userid1, userid2
                                        ORDER BY max_timecreated DESC");

    $message_table = new html_table();
    $message_table->head = array("", "Conversation between", "Began", "Last Activity", "Messages");
    $message_expander = "<a id=\"expander-%ID1%-%ID2%\" class=\"expander\">&#9658;</a>";

    foreach ($traffic as $m) {
        $this_expander = str_replace("%ID1%", $m->u1_id, $message_expander);
        $this_expander = str_replace("%ID2%", $m->u2_id, $this_expander);
        $message_table->data[] = array($this_expander, $m->u1_firstname . " " . $m->u1_lastname . " and " . $m->u2_firstname . " " . $m->u2_lastname,
                                        date("n M Y", $m->min_timecreated), date("n M Y", $m->max_timecreated), $m->full_count);
    }
    $traffic->close();

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
            toggle_detail(ids[1], ids[2], this);
        });
    });

    function toggle_detail(id1, id2, control) {
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
                    "id1": id1,
                    "id2": id2
                },
                dataType: "json",
                type: "GET",
                success: function(data) {
                    jQuery(control).html("&#9660;");

                    content = "<table style=\"width: 100%;\">";
                    content += "<tr><th>Sender</th><th>Recipient</th><th>Sent</th><th>Read</th></tr>";
                    jQuery.each(data, function() {
                        var sent = moment(this.timecreated*1000);
                        var sent_str = sent.format("YYYY-MM-DD HH:mm:ss");
                        // var sent_str = sent.getFullYear() + "-" + sent.getMonth() + "-" + sent.getDate() + " " + sent.getHours() + ":" + sent.getMinutes();
                        var read = this.timeread !== null ? "&#10004;" : "&#10008;";

                        content += "<tr>";
                        content += "<td>" + this.u1_firstname + " " + this.u1_lastname + "</td><td>" + this.u2_firstname + " " + this.u2_lastname + "</td>";
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
