<?php

trait WrapCurl
{
    public function get($url, $params,$header,$headerParams,$cookie)
    {
        return $this->cSend($url,$params,'get',$header,$headerParams,$cookie);
    }

    public function post($url, $params,$header,$headerParams,$cookie)
    {
        return $this->cSend($url,$params,'post',$header,$headerParams,$cookie);
    }

    private function cSend($url,$data,$method, $header = false,$headerPrams = [],$setCookie = null){
        $ch = curl_init();

        if($method == 'get') {
            if(!empty($data)){
                $query = http_build_query($data);
                $url = "$url?$query";
            }
        }

        //mLog("curl","$method: url - $url ". json_encode($data));

        //Log::info("$method: url - $url ". json_encode($data));

        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HEADER,$header);
        //curl_setopt($ch, CURLOPT_HTTPHEADER,$headerPrams);

        if($method == 'post'){
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS,
                http_build_query($data));
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

       /* preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $server_output, $matches);
        $cookies = array();
        foreach($matches[1] as $item) {
            parse_str($item, $cookie);
            $cookies = array_merge($cookies, $cookie);
        }*/
        //dump($cookies);
        //echo $server_output;
        curl_close ($ch);

        $output['cookie'] = null;
        $output['result'] = $server_output;

        return $output;
    }
}
