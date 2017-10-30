<?php
    require_once('../moodle/user/profile/lib.php');
    require_once('../moodle/config.php');

    require_login(null, true, null);
    $PAGE->set_context(context_system::instance());
 
    $PAGE->set_url('/local/mentoring/index.php');
    $PAGE->set_title(get_string('page_name_index', 'local_mentoring'));
    $PAGE->set_heading(get_string('page_name_index', 'local_mentoring'));
    $PAGE->set_pagelayout('standard');

    global $DB;

    echo $OUTPUT->header();

    $apply_link = new moodle_url("/local/mentoring/apply.php");
    $category_link = new moodle_url("/local/mentoring/categories.php");
    $find_link = new moodle_url("/local/mentoring/search.php");
    $resources_link = new moodle_url("/local/mentoring/resources.php");
?>
<h3>Welcome to the Online Masonic Mentoring System!</h3>
<p>The primary purpose of the Online Masonic Mentoring System is to facilitate Masonic
education. As the saying goes, you get out of Freemasonry what you put into it. You will find
that mentoring activities are well worth the time and effort.</p>
<p>This system is a resource for Pennsylvania Masons. The purpose is to supplement but NOT replace individual Lodge
mentoring programs. The design is a simple one: Brothers may choose to become a mentor for a variety of Masonic
categories. Those categories are listed and defined <a href="<?=$category_link?>">here</a>.</p>
<h4>Becoming a Mentor</h4>
<p>To become a mentor, click <a href="<?=$apply_link?>">Become a Mentor</a> in the Navigation menu. Your information
will be collected and you will be contacted once your application is reviewed.</p>
<p>Being a mentor is a commitment to another Brother. We've developed resources to guide
you through the process of becoming a good mentor for your brethren. You can find them by clicking 
<a href="<?=$resources_link?>">Resources</a> in the Navigation menu.</p>
<h4>Finding a Mentor</h4>
<p>If you are a Brother seeking a mentor, click <a href="<?=$find_link?>">Find a Mentor</a>
in the Navigation menu. You can then search for mentors based on the categories defined above.
If you find a matching mentor, you'll see the mentor's contact information. 
<p>You can find additional mentee resources by clicking <a href="<?=$resources_link?>">Resources</a>
in the Navigation menu.</p>
<?php
    echo $OUTPUT->footer();
?>
