<?php
    $capabilities = array(
        'local/mentoring:admin' => array(
            'riskbitmask'   => RISK_CONFIG,
            'captype'       => 'write',
            'contextlevel'  => CONTEXT_SYSTEM,
            'archetypes'    => array(
                'manager'   => CAP_ALLOW
            )
        ),
        'local/mentoring:manage_mentors' => array(
            'riskbitmask'   => RISK_CONFIG,
            'captype'       => 'write',
            'contextlevel'  => CONTEXT_SYSTEM,
            'archetypes'    => array(
                'manager'   => CAP_ALLOW
            )
        ),
        'local/mentoring:mentoring_help' => array(
            'riskbitmask'   => RISK_CONFIG,
            'captype'       => 'write',
            'contextlevel'  => CONTEXT_SYSTEM,
            'archetypes'    => array(
                'manager'   => CAP_ALLOW
            )
        ),
        'local/mentoring:technical_help' => array(
            'riskbitmask'   => RISK_CONFIG,
            'captype'       => 'write',
            'contextlevel'  => CONTEXT_SYSTEM,
            'archetypes'    => array(
                'manager'   => CAP_ALLOW
            )
        )
    );
?>
