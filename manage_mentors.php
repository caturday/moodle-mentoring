<?php
    require_once('../../config.php');
    require_once("$CFG->libdir/tablelib.php");
 
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
    $columns = array('lastname', 'submission_date', 'status', 'actions');

    $table = new flexible_table('Mentors');
    $table->define_baseurl(new moodle_url("/local/mentoring/manage_mentors.php"));
    $table->define_headers(array('Mentor', 'Application Submitted', 'Review Status', 'Actions'));
    $table->define_columns($columns);
    $table->sortable(true, 'submission_date', SORT_DESC);
    $table->no_sorting('status');
    $table->no_sorting('actions');
    $table->setup();

    $approve_url = new moodle_url("/local/mentoring/actions/change_mentor_approval.php");
    $view_url = new moodle_url("/local/mentoring/view_application.php");

    $order_clause = "";
    if ($order_by = $table->get_sql_sort()) {
        $order_clause = " ORDER BY ${order_by}";
    }

    $mentors = $DB->get_records_sql('SELECT ma.id, u.firstname, u.lastname, u.email, ma.submission_date, ma.approved, u.id as user_id
        FROM {mentor_application} ma JOIN {user} u ON ma.user_id = u.id' . $order_clause);

    foreach ($mentors as $mentor) {
        $this_approve_url_base = "<a href=\"${approve_url}?appid=" . $mentor->id;
        $this_view_url = "<a href=\"" . $view_url . "?appid=" . $mentor->id . "\">view</a>";

        $mentor_user = get_complete_user_data('id', $mentor->user_id);

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

        $name_field = $mentor->lastname . ", " . $mentor->firstname . "<br />" . 
            "<span style=\"padding-left: 10px; font-style: italic;\">" . $mentor_user->institution . "</span>";

        $table->add_data(array($name_field, date('j F Y', $mentor->submission_date), $approval_display, $action_list));
    }


    $table->finish_html();

    echo $OUTPUT->footer();
?>
