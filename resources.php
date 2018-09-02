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

    $gl_mentor_program = new moodle_url("${pdf_dir}/grand_lodge_mentor_program.pdf");
    $gl_threshold = new moodle_url("${pdf_dir}/on_the_threshold.pdf");

    $pdf_icon = new moodle_url("/local/mentoring/images/pdf_32x32.png");
    $li_style = "background: url('$pdf_icon') no-repeat 0 0; line-height: 32px; padding-left: 38px;";

    echo $OUTPUT->header();
?>
<i>Here, you can find useful resources for Mentors and Mentees.</i>
<h5>Guidelines for Mentoring</h5>
<ul style="font-weight: bold; list-style-type: none;">
    <li style="<?=$li_style?>"><a href="<?=$qualifications?>">Mentor Qualifications</a></li>
    <li style="<?=$li_style?>"><a href="<?=$qualities_mentor?>">Qualities of a Successful Mentor</a></li>
    <li style="<?=$li_style?>"><a href="<?=$qualities_mentee?>">Qualities of a Successful Mentee</a></li>
    <li style="<?=$li_style?>"><a href="<?=$email?>">Email Guidelines</a></li>
</ul>
<h5>PA Grand Lodge Resources</h5>
<ul style="font-weight: bold; list-style-type: none;">
    <li style="<?=$li_style?>"><a href="<?=$gl_mentor_program?>">Grand Lodge Mentor Program Handbook</a></li>
    <li style="<?=$li_style?>"><a href="<?=$gl_threshold?>">On the Threshold</a></li>
</ul>
<h5>Degree Lessons</h5>
<ul style="font-weight: bold; list-style-type: none;">
    <li style="<?=$li_style?>"><a href="<?=$ea_lesson?>">Entered Apprentice</a></li>
    <li style="<?=$li_style?>"><a href="<?=$fc_lesson?>">Fellowcraft</a></li>
    <li style="<?=$li_style?>"><a href="<?=$mm_lesson?>">Master Mason</a></li>
</ul>
<?php
    echo $OUTPUT->footer();
?>
