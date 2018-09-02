<?php
    require_once(dirname(__FILE__) . '/../../config.php');
    require_once($CFG->dirroot . '/user/selector/lib.php');
    require_once(dirname(__FILE__) . '/forms/state_dropdown.php');

    function local_mentoring_extend_navigation($context) {
        global $CFG, $PAGE, $USER, $DB;

        $plugin_status = get_config('local_mentoring', 'enabled');
        if ($plugin_status == 'disabled') { return; }
        if ($plugin_status == 'admins' && !has_capability('local/mentoring:admin', context_system::instance())) { return; }

        $mentoringroot = $PAGE->navigation->add(get_string('page_name_index', 'local_mentoring'), new moodle_url('/local/mentoring/'), 
            navigation_node::TYPE_CONTAINER);
        $mentoringroot->add(get_string('page_name_search', 'local_mentoring'), new moodle_url('/local/mentoring/search.php')); 

        $mentoringroot->add(get_string('page_name_resources', 'local_mentoring'), new moodle_url('/local/mentoring/resources.php'));

        if (is_user_a_mentor()) {
            $mentoringroot->add(get_string('page_name_profile', 'local_mentoring'), new moodle_url('/local/mentoring/profile.php'));
        } else if (get_config('local_mentoring', 'application_status') == 1) {
            $mentoringroot->add(get_string('page_name_apply', 'local_mentoring'), new moodle_url('/local/mentoring/apply.php')); 
        }

        $mentoringroot->add(get_string('page_name_help', 'local_mentoring'), new moodle_url('/local/mentoring/help.php'));

        // Only let users with the appropriate capability see this settings item.
        if (!has_capability('local/mentoring:admin', context_system::instance()) &&
                !has_capability('local/mentoring:manage_mentors', context_system::instance())) {
            return;
        }

        $manageroot = $mentoringroot->add('Management', null, navigation_node::TYPE_CONTAINER);

        if (has_capability('local/mentoring:admin', context_system::instance())) {
            $manageroot->add(get_string('page_name_config', 'local_mentoring'), new moodle_url('/local/mentoring/configure.php'));
        }

        if (has_capability('local/mentoring:manage_mentors', context_system::instance())) {
            $manageroot->add(get_string('page_name_manage_mentors', 'local_mentoring'), new moodle_url('/local/mentoring/manage_mentors.php'));
            $manageroot->add(get_string('page_name_add_mentor', 'local_mentoring'), new moodle_url('/local/mentoring/add_mentor.php'));
            $manageroot->add(get_string('page_name_viewlog', 'local_mentoring'), new moodle_url('/local/mentoring/view_log.php'));
        }
    }

    function is_user_a_mentor() {
        global $DB, $USER;
        $mentor = $DB->get_record_sql('SELECT ma.approved FROM {mentor_application} ma WHERE ma.user_id = ' . $USER->id);

        return (isset($mentor->approved) && $mentor->approved == 1);
    }

    function add_contact_info_elements_to_form($mform) {
        $mform->addElement('html', '<div class="section-text">' . get_string('apply_lbl_verify_profile', 'local_mentoring') . "</div>");

        $mform->addElement('text', 'email', get_string('apply_lbl_email', 'local_mentoring'));
        $mform->setType('email', PARAM_TEXT);
        $mform->addRule('email', get_string('form_err_generic_required', 'local_mentoring'), 'required');
        $mform->addRule('email', get_string('form_err_email_invalid', 'local_mentoring'), 'email');

        $mform->addElement('text', 'phone', get_string('apply_lbl_phone', 'local_mentoring'));
        $mform->setType('phone', PARAM_TEXT);
        $mform->addRule('phone', get_string('form_err_generic_required', 'local_mentoring'), 'required');

        $mform->addElement('text', 'city', get_string('apply_lbl_city', 'local_mentoring'));
        $mform->setType('city', PARAM_TEXT);
        $mform->addRule('city', get_string('form_err_generic_required', 'local_mentoring'), 'required');

        $mform->addElement('select', 'state', get_string('apply_lbl_state', 'local_mentoring'), get_state_array());
        $mform->setType('state', PARAM_TEXT);
        $mform->addRule('state', get_string('form_err_generic_required', 'local_mentoring'), 'required');

        $mform->addElement('text', 'lodge', get_string('apply_lbl_lodge', 'local_mentoring'));
        $mform->setType('lodge', PARAM_TEXT);
        $mform->addRule('lodge', get_string('form_err_generic_required', 'local_mentoring'), 'required');
    }

    function add_profile_elements_to_form($mform) {
        global $DB;

        $cats = $DB->get_records('mentoring_category', null, 'category_name, category_desc');

        $introText = get_string('profile_lbl_cats', 'local_mentoring') .
            "<br /><span style=\"font-weight: normal; font-style: italic;\">" . get_string('form_lbl_all_that_apply', 'local_mentoring') . "</span>";
        $mform->addElement('static', 'category_question_text', $introText);

        foreach ($cats as $cat) {
            $label = "<b>" . $cat->category_name . "</b><div style=\"padding-left: 40px; font-style: italic;\">" . $cat->category_desc . "</div>";
            $mform->addElement('checkbox', 'q5-' . $cat->id, '', $label);
        }
    }

    function construct_user_location($user) {
        $loc = $user->city != "" ? $user->city : "";
        $loc = $user->profile['State'] != "" ?
            ($loc != "" ? $loc . ", " . $user->profile['State'] : $user->profile['State']) : $loc;

        return $loc;
    }

    function array_zip_merge(array $a, array $b) {
        $return = array();

        $count_a = count($a);
        $count_b = count($b);

        // Zip arrays
        for ($i = 0; $i < $count_a; $i++) {
            $return = array_merge_recursive($return, array_slice($a, $i, 1, true));
            $return = array_merge_recursive($return, array_slice($b, $i, 1, true));
        }

        $difference = $count_b - $count_a;
        if ($difference > 0) {
            // There are more items to add on end so pop them at the end
            $return = array_merge_recursive($return,
            array_slice($b, $count_a, $difference, true));
        }
        else if ($difference < 0) {
            $return = array_merge_recursive($return,
            array_slice($a, $count_b, $difference, true));
        }

        return $return;
    }

    class non_mentor_user_selector extends user_selector_base {
        public function __construct($name) {
            global $CFG;
            $options['file'] = 'local/mentoring/lib.php';
            $options['multiselect'] = false;
            parent::__construct($name, $options);
        }

        public function find_users($search) {
            global $DB;

            list($wherecondition, $params) = $this->search_sql($search, 'u');
            $sql = 'SELECT ' . $this->required_fields_sql('u') . ' ' . 
                    'FROM {user} u LEFT JOIN {mentor_application} ma ON u.id = ma.user_id ' .
                    'WHERE ma.id IS NULL AND ' . $wherecondition;
            $users = $DB->get_recordset_sql($sql, $params);
            $groupedusers = array();
            foreach ($users as $user) {
                $optgroup = 'Non-mentors';
                $groupedusers[$optgroup][] = $user;
            }
            return $groupedusers;
        }
    }
?>
