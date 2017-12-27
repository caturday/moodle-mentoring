<?php

    if ($hassiteconfig) {
        $settings = new admin_settingpage('local_mentoring', 'Mentoring Configuration');
        $ADMIN->add('localplugins', $settings);

        $settings->add(new admin_setting_heading('local_mentoring/basic_settings',
            get_string('cfg_heading_basic_settings', 'local_mentoring'),
            get_string('cfg_heading_basic_settings_definition', 'local_mentoring')
        ));

        $settings->add(new admin_setting_configselect('local_mentoring/enabled', 
            get_string('cfg_lbl_enabled', 'local_mentoring'),
            get_string('cfg_lbl_enabled_definition', 'local_mentoring'),
            'Enabled', array('enabled' => 'Enabled', 'admins' => 'Admins Only', 'disabled' => 'Disabled')
        ));

        $settings->add(new admin_setting_configcheckbox('local_mentoring/application_status', 
            get_string('cfg_lbl_application_status', 'local_mentoring'),
            get_string('cfg_lbl_application_status_definition', 'local_mentoring'),
            false, true, false
        ));
    }

?>
