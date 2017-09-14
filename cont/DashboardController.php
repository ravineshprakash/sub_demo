<?php
/**
 * Created by PhpStorm.
 * User: Ravi
 * Date: 9/9/2017
 * Time: 12:03 PM
 */

class DashboardController
{
    protected $config;

    public function __construct() {
        $this->config = require __DIR__.'/../config/path.php';
    }

    public function getServerList() {
        $url = $this->config['server_list'];

        require_once __DIR__.'/../model/Curl.php';
        $curl = new Curl();

        return $curl::getContent($url);
    }

    public function getServerData($server) {
        $url = $this->config['server_info'].'/'.$server.'/';

        require_once __DIR__.'/../model/Curl.php';
        $curl = new Curl();

        $return = array();
        $data = $curl::getContent($url);

        if($data['code'] === 0) {
            $chart = array();
            foreach ($data['data'] as $datum) {
                $chart['label'][] = $datum['data_label'];
                $chart['value'][] = $datum['data_value'];
            }

            $return = array(
                'code' => 0,
                'msg'  => 'Success',
                'data' => $chart,
            );
        } else
            $return = $data;

        return $return;
    }
}