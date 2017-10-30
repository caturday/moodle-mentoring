<?php

    function local_mentoring_extend_navigation($context) {
        global $CFG, $PAGE;
        $mentoringroot = $PAGE->navigation->add(get_string('page_name_index', 'local_mentoring'), new moodle_url('/local/mentoring/'), 
            navigation_node::TYPE_CONTAINER);
        $mentoringroot->add(get_string('page_name_search', 'local_mentoring'), new moodle_url('/local/mentoring/search.php')); 

        #error_log(get_config('local_mentoring', 'application_status'));
        #error_log(var_dump(get_config('local_mentoring')));

        if (get_config('local_mentoring', 'application_status') == 1) {
            $mentoringroot->add(get_string('page_name_apply', 'local_mentoring'), new moodle_url('/local/mentoring/apply.php')); 
        }
        $mentoringroot->add(get_string('page_name_resources', 'local_mentoring'), new moodle_url('/local/mentoring/resources.php'));


        // Only let users with the appropriate capability see this settings item.
        if (has_capability('local/mentoring:admin', context_system::instance())) {
            $mentoringroot->add(get_string('page_name_config', 'local_mentoring'), new moodle_url('/local/mentoring/configure.php'));
        }

        if (has_capability('local/mentoring:manage_mentors', context_system::instance())) {
            $mentoringroot->add(get_string('page_name_manage_mentors', 'local_mentoring'), new moodle_url('/local/mentoring/manage_mentors.php'));
        }
    }

?>
