<?php
    require_once('../../../config.php');

    require_login(null, true, null);
    $PAGE->set_context(context_system::instance());

    $id = required_param('id', PARAM_INT);

    global $DB;

    $messages = $DB->get_recordset_sql("SELECT    m.timecreated, u.firstname, u.lastname, mua.action
                                          FROM    mdl_messages m JOIN
                                                  mdl_message_conversations mc ON m.conversationid = mc.id JOIN
                                                  mdl_user u ON m.useridfrom = u.id LEFT JOIN
                                                  mdl_message_user_actions mua ON m.id = mua.messageid
                                         WHERE    mc.type = 1 and m.customdata = '\"mentoringrequest\"'
                                                  AND m.conversationid = ?
                                        ORDER BY  m.timecreated DESC", array($id));

    $output = "[";
    foreach ($messages as $m) {
        if ($output !== "[") { $output .= ","; }
        $output .= json_encode($m);
    }
    $output .= "]";

    echo $output;
?>
