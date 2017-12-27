<?php
    require_once("../../config.php");
    require_once($CFG->dirroot . "/user/profile/lib.php");


    require_login(null, true, null);
    $PAGE->set_context(context_system::instance());
 
    $PAGE->set_url('/local/mentoring/resources.php');
    $PAGE->set_title(get_string('page_name_resources', 'local_mentoring'));
    $PAGE->set_heading(get_string('page_name_resources', 'local_mentoring'));
    $PAGE->set_pagelayout('standard');

    global $DB;

    $pdf_dir = "/local/mentoring/pdf";

    $qualifications = new moodle_url("${pdf_dir}/mentor_qualifications.pdf");
    $qualities_mentee = new moodle_url("${pdf_dir}/qualities_mentee.pdf");
    $qualities_mentor = new moodle_url("${pdf_dir}/qualities_mentor.pdf");
    $email = new moodle_url("${pdf_dir}/email_guidelines_for_mentoring.pdf");

    $ea_lesson = new moodle_url("${pdf_dir}/EA_Mason_Lesson.pdf");
    $fc_lesson = new moodle_url("${pdf_dir}/FC_Mason_Lesson.pdf");
    $mm_lesson = new moodle_url("${pdf_dir}/MM_Mason_Lesson.pdf");

    echo $OUTPUT->header();
?>
<i>Here, you can find useful resources for Mentors and Mentees.</i>
<h5>Guidelines for Mentoring</h5>
<ul>
    <li><a href="<?=$qualifications?>">Mentor Qualifications</a></li>
    <li><a href="<?=$qualities_mentor?>">Qualities of a Successful Mentor</a></li>
    <li><a href="<?=$qualities_mentee?>">Qualities of a Successful Mentee</a></li>
    <li><a href="<?=$email?>">Email Guidelines</a></li>
</ul>
<h5>Degree Lessons</h5>
<ul>
    <li><a href="<?=$ea_lesson?>">Entered Apprentice</a></li>
    <li><a href="<?=$fc_lesson?>">Fellowcraft</a></li>
    <li><a href="<?=$mm_lesson?>">Master Mason</a></li>
</ul>
<?php
    echo $OUTPUT->footer();
?>
