<?php
    require_once('../../../config.php');

    require_login(null, true, null);
    $PAGE->set_context(context_system::instance());

    $id1 = required_param('id1', PARAM_INT);
    $id2 = required_param('id2', PARAM_INT);

    global $DB;

    $messages = $DB->get_recordset_sql("SELECT u1.id as u1_id, u1.firstname as u1_firstname, u1.lastname as u1_lastname,
                                             u2.id as u2_id, u2.firstname as u2_firstname, u2.lastname as u2_lastname,
                                             m.timeread, m.timecreated
                                      FROM (
                                          SELECT useridfrom, useridto, timeread, timecreated, subject
                                          FROM {message_read} mr
                                          UNION
                                          SELECT useridfrom, useridto, NULL as timeread, timecreated, subject
                                          FROM {message} mu
                                      ) m JOIN {user} u1 ON m.useridfrom = u1.id JOIN {user} u2 ON m.useridto = u2.id
                                      WHERE ((useridfrom = ? AND useridto = ?) OR (useridfrom = ? AND useridto = ?))
                                          AND m.subject = 'Request for Mentoring'
                                      ORDER BY m.timecreated DESC",
                                      array($id1, $id2, $id2, $id1));

    $output = "[";
    foreach ($messages as $m) {
        if ($output !== "[") { $output .= ","; }
        $output .= json_encode($m);
    }
    $output .= "]";

    echo $output;
?>
