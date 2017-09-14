<?php
/**
 * Created by PhpStorm.
 * User: Ravi
 * Date: 9/9/2017
 * Time: 12:18 PM
 */

require_once __DIR__.'/cont/DashboardController.php';

$method = strtolower(trim($_REQUEST['method']));

if($method === 'server_list') {
    $cont = new DashboardController();
    echo json_encode($cont->getServerList());
}

else if($method === 'server_info') {
    $server = trim($_REQUEST['name']);

    $cont = new DashboardController();
    echo json_encode($cont->getServerData($server));
}

else
    echo json_encode(array(
        'code' => 1,
        'msg'  => 'Please provide method',
        'data' => array(),
    ));

?>