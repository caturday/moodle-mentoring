<?php
    require_once('../../config.php');
 
    require_login(null, true, null);
    $PAGE->set_context(context_system::instance());
    
    $PAGE->set_url('/local/mentoring/view_application.php');
    $PAGE->set_title(get_string('page_name_view_application', 'local_mentoring'));
    $PAGE->set_heading(get_string('page_name_view_application', 'local_mentoring'));
    $PAGE->set_pagelayout('standard');

    $app_id = required_param('appid', PARAM_INT);

    global $DB, $USER;

    echo $OUTPUT->header();

    $appsql = 'SELECT ma.id, u.firstname, u.lastname, u.email, ma.submission_date, ma.approved, u.id as user_id
        FROM {mentor_application} ma JOIN {user} u ON ma.user_id = u.id
        WHERE ma.id = ?';
    $thisapp = $DB->get_record_sql($appsql, array($app_id));

    if (!$thisapp) {
        redirect(new moodle_url('/local/mentoring/manage_mentors.php', null));
        exit();
    }

    $app_user = get_complete_user_data('id', $thisapp->user_id);

    $qsql = 'SELECT question_number, question_response
        FROM {mentor_application_items}
        WHERE application_id = ?';
    $questions = $DB->get_records_sql($qsql, array($app_id));

    $question_hash = array();
    foreach ($questions as $question) {
        $question_hash[$question->question_number] = $question->question_response;
    }

    $selectedcatsql = 'SELECT category_name
        FROM {category_user_map} AS map JOIN {mentoring_category} AS cat ON map.category_id = cat.id
        WHERE user_id = ? AND is_mentor = 1';
    $selectedcats = $DB->get_records_sql($selectedcatsql, array($thisapp->user_id));

    $contact_url = new moodle_url('/local/mentoring/message.php?type=a&to=' . $thisapp->user_id . '&backto=/local/mentoring/manage_mentors.php');
    $approve_link = "<a href=\"" . new moodle_url("/local/mentoring/actions/change_mentor_approval.php") . "?appid=" . $thisapp->id;
    $approval_display = '';

    if ($thisapp->approved == 0) {
        $approval_display = "<b>Pending</b>: ${approve_link}&status=1\">approve</a> | ${approve_link}&status=-1\">deny</a>";
    } else if ($thisapp->approved == 1) {
        $approval_display = "<b>Approved</b>: ${approve_link}&status=0\">unapprove</a>";
    } else if ($thisapp->approved == -1) {
        $approval_display = "<b>Denied</b>";
    }

    $return_link = new moodle_url("/local/mentoring/manage_mentors.php");
?>
<a href="<?=$return_link?>">&larr; return to list</a>
<h3>Application for <?=$thisapp->firstname?> <?=$thisapp->lastname?></h3>
<div class="application-display">
    <div class="mentor-display">
        <div class="mentor-display-image">
            <?=$OUTPUT->user_picture($app_user, array('size'=>70))?>
        </div>
        <p style="font-style: italic; display: inline-block; margin-left: 1em; margin-bottom: 0;">
            <a href="mailto:<?=$app_user->email?>"><?=$app_user->email?></a> |
            <?php if ($app_user->phone1 !== ''): ?><?=$app_user->phone1?> |<?php endif; ?>
            <?php if ($app_user->phone2 !== ''): ?><?=$app_user->phone2?> |<?php endif; ?>
            <?=construct_user_location($app_user)?>
            <br />PA Grand Lodge ID #<?=$app_user->idnumber?>
            <br /><?php if ($app_user->institution !== ''): ?><?=$app_user->institution?><?php endif; ?>
        </p>
    </div>
    <p><i>Applied on <?=date('j F Y', $thisapp->submission_date)?></i></p>
    <p>Status is <?=$approval_display?> | <a href="<?=$contact_url?>">message user</a></p>
    <?php for($i = 1; $i < 5; $i++): ?>
    <div class="application-question">
        <?=get_string('apply_lbl_q' . $i, 'local_mentoring')?>
    </div>
    <div class="application-answer">
        <?=$question_hash[$i]?>
    </div>
    <?php endfor; ?>
    <div class="application-question">
        Selected categories:
    </div>
    <div class="application-answer">
        <?php foreach($selectedcats as $category): ?>
            <?=$category->category_name?><br />
        <?php endforeach; ?>
    </div>
</div>
<?php
    echo $OUTPUT->footer();
?>
