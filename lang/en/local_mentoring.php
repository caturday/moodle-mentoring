<?php
    $string['pluginname'] = "Mentoring Plugin";

    $string['system_name'] = "Online Masonic Mentoring System";
    $string['system_abbr'] = "OMMS";

    $string['page_name_index'] = 'Masonic Mentoring';
    $string['page_name_search'] = 'Find a Mentor';
    $string['page_name_config'] = 'Manage Categories';
    $string['page_name_apply'] = 'Become a Mentor';
    $string['page_name_manage_mentors'] = 'Manage Mentors';
    $string['page_name_view_application'] = $string['page_name_apply'];
    $string['page_name_categories'] = 'Mentoring Categories';
    $string['page_name_resources'] = 'Mentoring Resources';

    $string['link_container_name'] = 'Masonic Mentoring';

    $string['cfg_lbl_application_status'] = 'Mentor Applications Enabled';
    $string['cfg_lbl_general_submit'] = 'Submit';
    $string['cfg_lbl_category'] = 'New Category';
    $string['cfg_err_category'] = 'Category is required.';
    $string['cfg_lbl_catdesc'] = 'Description';
    $string['cfg_lbl_categories_submit'] = 'Add';

    $string['apply_lbl_q1'] = 'Do you have any constraints on your ability to mentor (time or otherwise)? If so, please describe.';  
    $string['apply_lbl_q2'] = 'Please describe any success you\'ve had as a PA Masonic Mentor.';
    $string['apply_lbl_q3'] = 'Please comment on your experience(s) using email, social media (e.g. Facebook), and websites.';
    $string['apply_lbl_q4'] = 'Please list examples of your communication skills.';
    $string['apply_lbl_q5'] = 'What is your Masonic expertise?';
    $string['apply_lbl_submit'] = 'Apply';

    $string['search_lbl_all'] = 'All';
    $string['search_lbl_any'] = 'Any';
    $string['search_lbl_anyall'] = 'Find mentors who can teach me about <b>any</b> or <b>all</b> of these:';
    $string['search_lbl_cats'] = 'Categories:';
    $string['search_lbl_submit'] = 'Search';

    $string['form_err_generic_required'] = 'This field is required.';
    $string['form_lbl_all_that_apply'] = 'Please select all that apply.';

    $string['mentoring:admin'] = 'Administer Mentoring System';
    $string['mentoring:manage_mentors'] = 'Manage Mentor Applications';

    $string['email_mentoring_admin'] = 'zack.panitzke@symmetricity.net';
    $string['email_from_name'] = 'Online Masonic Mentoring';

    $string['email_application_status_approved'] = 'APPROVED';
    $string['email_application_status_denied'] = 'DENIED';
    $string['email_application_status_unreviewed'] = 'UNREVIEWED';

    $string['email_application_status_subject'] = 'Your Mentoring status has changed!';
    $string['email_application_status_text'] = 'Hello!

Your mentoring status in the Online Masonic Mentoring System has changed.

Your new status is: %STATUS%.

If you believe this is in error, please contact us at ' . $string['email_mentoring_admin'] . '.

Thank you for your interest in mentoring your Masonic brethren!';

    $string['email_application_received_user_subject'] = 'Your Mentoring application has been received!';
    $string['email_application_received_user_text'] = 'Hello!

Your mentoring application has been received. Thank you for your interest in mentoring your Masonic brethren!

Once your application is reviewed, you will receive another email. If you have not received an email within the next week, please contact us at ' . $string['email_mentoring_admin'] . '.

Thanks again!';

    $string['email_application_received_subject'] = 'Mentoring application received';
    $string['email_application_received_text'] = 'Hello!

A new mentoring application has been received. Please review it at your earliest convenience. You can access it here:' . 
new moodle_url('/local/mentoring/manage_mentors.php');
?>
