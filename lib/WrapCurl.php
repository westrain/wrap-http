<?php

trait WrapCurl
{
    public function get($url, $params,$header,$cookie)
    {
        return $this->send($url,$params,'get',$header,$cookie);
    }

    public function post($url, $params,$header,$cookie)
    {
        return $this->send($url,$params,'post',$header,$cookie);
    }

    private function send($url,$data,$method, $header = [], $setCookie = null){

        $ch = curl_init();
        if($method == 'get') {
            if(!empty($data)){
                $query = http_build_query($data);
                $url = "$url?$query";
            }
        }
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HEADER,$header);
        if($method == 'post'){
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        }
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.75 Safari/535.7');
        curl_setopt ($ch, CURLOPT_COOKIEFILE, "cookie");
        curl_setopt ($ch, CURLOPT_COOKIEJAR, "cookie");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec ($ch);
        curl_close ($ch);

        return $server_output;
    }
}
