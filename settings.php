<?php

    if ($hassiteconfig) {
        $settings = new admin_settingpage('local_mentoring', 'Mentoring Configuration');
        $ADMIN->add('localplugins', $settings);

        $settings->add(new admin_setting_configcheckbox(
            'local_mentoring/application_status', get_string('cfg_lbl_application_status', 'local_mentoring'),
            'Enables or disables mentoring applications.', false, PARAM_BOOL
        ));
    }

?>
