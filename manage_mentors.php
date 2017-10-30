<?php
    require_once('../moodle/config.php');
 
    require_login(null, true, null);
    $PAGE->set_context(context_system::instance());
    
    $PAGE->set_url('/local/mentoring/manage_mentors.php');
    $PAGE->set_title(get_string('page_name_manage_mentors', 'local_mentoring'));
    $PAGE->set_heading(get_string('page_name_manage_mentors', 'local_mentoring'));
    $PAGE->set_pagelayout('standard');

    global $DB;

    echo $OUTPUT->header();
?>
<h2>Mentors</h2>
<?php
    $mentors = $DB->get_records_sql('SELECT ma.id, u.firstname, u.lastname, u.email, ma.submission_date, ma.approved
        FROM {mentor_application} ma JOIN {user} u ON ma.user_id = u.id');
    $table = new html_table();
    $table->head = array('Mentor', 'Application Submitted', 'Review Status', 'Actions');
    $table->data = array();

    $approve_url = new moodle_url("/local/mentoring/actions/change_mentor_approval.php");
    $view_url = new moodle_url("/local/mentoring/view_mentor_application.php");

    foreach ($mentors as $mentor) {
        $this_approve_url_base = "<a href=\"${approve_url}?appid=" . $mentor->id;
        $this_view_url = "<a href=\"" . $view_url . "?appid=" . $mentor->id . "\">view</a>";

        $action_list = '';
        $approval_display = '';

        if ($mentor->approved == 0) {
            $action_list = "${this_approve_url_base}&status=1\">approve</a> | ${this_approve_url_base}&status=-1\">deny</a>";
            $approval_display = "Pending - ${this_view_url}";
        } else if ($mentor->approved == 1) {
            $action_list = "${this_approve_url_base}&status=0\">unapprove</a>";
            $approval_display = "Approved - ${this_view_url}";
        } else if ($mentor->approved == -1) {
            $approval_display = "Denied - ${this_view_url}";
        }

        array_push($table->data, array($mentor->lastname . ", " . $mentor->firstname, date('j F Y', $mentor->submission_date), $approval_display, $action_list));
    }

    echo html_writer::table($table);

    echo $OUTPUT->footer();
?>
