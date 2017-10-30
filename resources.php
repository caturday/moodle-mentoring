<?php
    require_once('../moodle/user/profile/lib.php');
    require_once('../moodle/config.php');

    require_login(null, true, null);
    $PAGE->set_context(context_system::instance());
 
    $PAGE->set_url('/local/mentoring/resources.php');
    $PAGE->set_title(get_string('page_name_resources', 'local_mentoring'));
    $PAGE->set_heading(get_string('page_name_resources', 'local_mentoring'));
    $PAGE->set_pagelayout('standard');

    global $DB;

    $qualifications = new moodle_url("/local/mentoring/pdf/mentor_qualifications.pdf");
    $qualities_mentee = new moodle_url("/local/mentoring/pdf/qualities_mentee.pdf");
    $qualities_mentor = new moodle_url("/local/mentoring/pdf/qualities_mentor.pdf");
    $email = new moodle_url("/local/mentoring/pdf/email_guidelines_for_mentoring.pdf");

    echo $OUTPUT->header();
?>
<h4>Here, you can find useful resources for Mentors and Mentees.</h4>
<ul>
    <li><a href="<?=$qualifications?>">Mentor Qualifications</a></li>
    <li><a href="<?=$qualities_mentor?>">Qualities of a Successful Mentor</a></li>
    <li><a href="<?=$qualities_mentee?>">Qualities of a Successful Mentee</a></li>
    <li><a href="<?=$email?>">Email Guidelines</a></li>
</ul>
<?php
    echo $OUTPUT->footer();
?>
