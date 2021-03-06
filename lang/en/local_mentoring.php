<?php
    // please note: you will need to increment the version string in version.php before changes to this file will take effect.

    $string['pluginname'] = "Mentoring Plugin";

    $string['system_name'] = "Online Masonic Mentoring System";
    $string['system_abbr'] = "OMMS";

    $string['page_name_index'] = 'Online Masonic Mentoring';
    $string['page_name_search'] = 'Find a Mentor';
    $string['page_name_config'] = 'Manage Categories';
    $string['page_name_apply'] = 'Become a Mentor';
    $string['page_name_profile'] = 'Manage Profile';
    $string['page_name_message'] = 'Send a Message';
    $string['page_name_manage_mentors'] = 'Manage Mentors';
    $string['page_name_view_application'] = $string['page_name_apply'];
    $string['page_name_categories'] = 'Mentoring Categories';
    $string['page_name_resources'] = 'Mentoring Resources';
    $string['page_name_add_mentor'] = 'Add Mentor';
    $string['page_name_help'] = 'Help!';
    $string['page_name_viewlog'] = 'View Message Logs';

    $string['link_container_name'] = 'Online Masonic Mentoring';

    $string['cfg_heading_basic_settings'] = 'Basic Settings';
    $string['cfg_heading_basic_settings_definition'] = '';
    $string['cfg_lbl_application_status'] = 'Mentor Applications Enabled';
    $string['cfg_lbl_application_status_definition'] = 'Enables or Disables the Mentor Application Form.';
    $string['cfg_lbl_enabled'] = 'Mentoring Plugin Status';
    $string['cfg_lbl_enabled_definition'] = 'Enables or Disables the entire Mentoring Plugin. Admins Only will enable the plugin only for
        Mentoring Admins and normal Moodle Admins.';
    $string['cfg_lbl_general_submit'] = 'Submit';
    $string['cfg_lbl_category'] = 'New Category';
    $string['cfg_err_category'] = 'Category is required.';
    $string['cfg_lbl_catdesc'] = 'Description';
    $string['cfg_lbl_categories_submit'] = 'Add';

    $string['apply_lbl_verify_profile'] = 'Please verify the following information from your user profile. It will help potential mentees find and get in touch with you. You can edit it any time on the <a href="' . new moodle_url("/user/editadvanced.php") . '">Profile</a> page.';
    $string['apply_lbl_email'] = 'Email Address';
    $string['apply_lbl_phone'] = 'Preferred Phone Number';
    $string['apply_lbl_city'] = 'City';
    $string['apply_lbl_state'] = 'State';
    $string['apply_lbl_lodge'] = 'Lodge';
    $string['apply_lbl_q1'] = 'Do you have any constraints on your ability to mentor (time or otherwise)? If so, please describe.';  
    $string['apply_lbl_q2'] = 'Please describe any success you\'ve had as a PA Masonic Mentor.';
    $string['apply_lbl_q3'] = 'Please comment on your experience(s) using email, social media (e.g. Facebook), and websites.';
    $string['apply_lbl_q4'] = 'Please list examples of your communication skills.';
    $string['apply_lbl_submit'] = 'Apply';

    $string['profile_lbl_cats'] = 'What is your Masonic expertise?';
    $string['profile_lbl_submit'] = 'Update Profile';

    $string['search_lbl_all'] = 'All';
    $string['search_lbl_any'] = 'Any';
    $string['search_lbl_anyall'] = 'Find mentors who can teach me about <b>any</b> or <b>all</b> of these:';
    $string['search_lbl_cats'] = 'Categories:<br /><a href="' . new moodle_url("/local/mentoring/categories.php") . '">help</a>';
    $string['search_lbl_submit'] = 'Search';

    $string['message_lbl_recipient'] = 'To:';
    $string['message_lbl_sender'] = 'From:';
    $string['message_lbl_subject'] = 'Subject:';
    $string['message_lbl_message'] = 'Your message:';
    $string['message_lbl_submit'] = 'Send';

    $string['add_lbl_choose_member'] = 'Choose Member';
    $string['add_lbl_submit'] = 'Add Mentor';

    $string['form_err_generic_required'] = 'This field is required.';
    $string['form_err_email_invalid'] = 'Email address invalid.';
    $string['form_lbl_all_that_apply'] = 'Please select all that apply.';

    $string['mentoring:admin'] = 'Administer Mentoring System';
    $string['mentoring:manage_mentors'] = 'Manage Mentor Applications';
    $string['mentoring:mentoring_help'] = 'Provide Mentoring Help';
    $string['mentoring:technical_help'] = 'Provide Mentoring Technical Help';
    $string['mentoring:audit_mentors'] = 'Audit Mentors';

    $string['email_from_name'] = 'Online Masonic Mentoring';

    $string['email_application_status_approved'] = 'APPROVED';
    $string['email_application_status_denied'] = 'DENIED';
    $string['email_application_status_unreviewed'] = 'UNREVIEWED';

    $string['email_application_status_subject'] = 'Your Mentoring status has changed!';
    $string['email_application_status_text'] = file_get_contents($CFG->dirroot . '/local/mentoring/lang/en/email_application_status.txt');
    $string['email_application_status_html'] = file_get_contents($CFG->dirroot . '/local/mentoring/lang/en/email_application_status.html');

    $string['email_application_received_user_subject'] = 'Your Mentoring application has been received!';
    $string['email_application_received_user_text'] = file_get_contents($CFG->dirroot . '/local/mentoring/lang/en/email_application_received_user.txt');
    $string['email_application_received_user_html'] = file_get_contents($CFG->dirroot . '/local/mentoring/lang/en/email_application_received_user.html');

    $string['email_application_received_subject'] = 'Mentoring application received';
    $string['email_application_received_text'] = file_get_contents($CFG->dirroot . '/local/mentoring/lang/en/email_application_received_admin.txt');
    $string['email_application_received_html'] = file_get_contents($CFG->dirroot . '/local/mentoring/lang/en/email_application_received_admin.html');

    $string['email_message_help_subject'] = 'Mentoring Help';
    $string['email_message_techsupport_subject'] = 'Mentoring Technical Support';
    $string['email_message_request_subject'] = 'Request for Mentoring';
    $string['email_message_application_subject'] = 'Your Mentoring Application';
    $string['email_message_text'] = file_get_contents($CFG->dirroot . '/local/mentoring/lang/en/email_message.txt');
    $string['email_message_html'] = file_get_contents($CFG->dirroot . '/local/mentoring/lang/en/email_message.html');

    $string['help_lbl_technical'] = 'Technical Support';
    $string['help_lbl_mentoring'] = 'Mentoring Support';
    $string['help_lbl_type'] = 'What kind of support do you need?';
    $string['help_lbl_subject'] = 'Subject';
    $string['help_lbl_message'] = 'Please describe the problem you are experiencing.';
    $string['help_lbl_submit'] = 'Send Message';    
    $string['help_subj_technical'] = 'Technical Support Request from ';
    $string['help_subj_mentoring'] = 'Mentoring Support Request from ';

?>
