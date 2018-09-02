<?php
    require_once("../../config.php");
    require_once($CFG->dirroot . "/user/profile/lib.php");
    require_once('forms/search_form.php');

    require_login(null, true, null);
    $PAGE->set_context(context_system::instance());
 
    $PAGE->set_url('/local/mentoring/search.php');
    $PAGE->set_title(get_string('page_name_search', 'local_mentoring'));
    $PAGE->set_heading(get_string('page_name_search', 'local_mentoring'));
    $PAGE->set_pagelayout('standard');

    global $DB, $OUTPUT;

    echo $OUTPUT->header();

    $mform = new search_form();
    $cat_pattern = "/^search-cat-\d+$/";
    $message_url = new moodle_url('/local/mentoring/message.php?type=m&backto=/local/mentoring/search.php');
?>
<h3>What are you looking for?</h3>
<div class="searchform-container">
    <?=$mform->display()?>
</div>
<?php
    if ($fromform = $mform->get_data()) {
        $keys = array_keys(get_object_vars($fromform));
        $cat_keys = preg_grep($cat_pattern, $keys);

        $selected_cats = array();
        $mentors = array();

        foreach ($cat_keys as $cat_key) {
            $selected_cats[] = str_replace("search-cat-", "", $cat_key);
        }

        if (count($selected_cats) != 0) {
            $mentor_query = "SELECT ma.user_id, u.firstname, u.lastname, u.email, u.city, u.picture,
                    GROUP_CONCAT(mc.category_name ORDER BY mc.category_name) AS category_list
                FROM {mentor_application} ma JOIN {user} u ON ma.user_id = u.id
                    JOIN {category_user_map} cu ON u.id = cu.user_id
                    JOIN {mentoring_category} mc ON cu.category_id = mc.id
                WHERE ma.approved = 1 AND ma.user_id IN (
                    SELECT user_id
                    FROM {category_user_map}
                    WHERE category_id IN (" . substr(str_repeat("?, ", count($selected_cats)), 0, -2) . ")";

            // This limits the query to only those users who match on ALL of the selected options.
            if ($fromform->anyall == 1) {
                $mentor_query .= " GROUP BY user_id HAVING COUNT(DISTINCT category_id) = " . count($selected_cats);
            }

            $mentor_query .= ")
                GROUP BY ma.id, u.firstname, u.lastname, u.email
                ORDER BY u.lastname, u.firstname";

            $mentors = $DB->get_records_sql($mentor_query, $selected_cats);

        }
?>
<h3>Matches</h3>
<?php if (count($mentors) == 0): ?>
    <div class="mentor-display-none">No matches found. Try modifying your search.</div>
<?php else: ?>
    <?php foreach ($mentors as $mentor):
        $mentor_user = get_complete_user_data('id', $mentor->user_id);
        $mentor_loc = construct_user_location($mentor_user);
        $mentor_link = new moodle_url("/user/profile.php?id=" . $mentor->user_id);
    ?>
    <div class="mentor-display">
        <div class="mentor-display-image">
            <?=$OUTPUT->user_picture($mentor_user, array('size'=>70))?>
        </div>
        <div class="mentor-display-profile">
            <span class="mentor-display-name"><a href="<?=$mentor_link?>"><?=$mentor->firstname?> <?=$mentor->lastname?></a></span>
            <?php if ($mentor_loc != ""): ?><span class="mentor-display-city mentor-display-gray">&nbsp;&bull;&nbsp;<?=$mentor_loc?></span><?php endif; ?>
            <div class="mentor-display-inset"><span class="mentor-display-gray" style="font-style: italic;">Mentors:</span> <?=str_replace(",", ", ", $mentor->category_list)?></div>
            <div class="mentor-display-inset"><a href="<?=$message_url . "&to=" . $mentor->user_id?>">Message this Mentor</a></div>
        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>
<?php        
    }
    echo $OUTPUT->footer();
?>
