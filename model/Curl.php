<?php
/**
 * Created by PhpStorm.
 * User: Ravi
 * Date: 9/9/2017
 * Time: 12:00 PM
 */


class Curl
{
    public static function getContent($url, $parameters=[], $post=true) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        if($post){
            curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($parameters));
            curl_setopt($ch,CURLOPT_POST, true);
        }

        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if($httpcode>=200 && $httpcode<300)
            $return = array(
                'code' => 0,
                'msg'  => 'Success',
                'data' => json_decode($data, true),
            );
        else
            $return = array(
                'code' => 1,
                'msg'  => $error,
                'data' => $data,
            );

        return $return;
    }
}