<?php

abstract class Http implements IRequest
{
    use WrapCurl;

    private $url = '';
    protected $uri = '';
    public $return_url = '';
    public $callback_url = '';
    private $method = 'POST';
    public $view;
    protected $params = [];
    private $token;
    private $response;
    private $cookie = '';
    private $header = [];

    abstract public function create($token = '');

    public function params($data,$with = true){
        if(!empty($data) && $with){
            $this->params = array_merge($this->params,$data);
        }else if(!empty($data)){
            $this->params = $data;
        }else{
            $this->params = null;
        }
        return $this;
    }

    public function cookie($cookie){
        $this->cookie = $cookie;
        return $this;
    }

    public function header($header){
        $this->header = $header;
        return $this;
    }

    public function uri($uri = ''){
        if($uri){
          $this->uri = $uri;
          return $this;
        }
        return $this->uri;
    }

    public function url($url = ''){
        if($url){
          $this->url = $url;
          return $this;
        }
        return $this->url;
    }

    public function method($method){
        $this->method = $method;
        return $this;
    }

    public function fastRequest($uri){
        $this->uri($uri);
        $this->send();
        return $this->response(false);
    }

    public function send(){

        try{
            $method = strtolower($this->method);

            $this->response = $this->$method(
                $this->url.$this->uri,
                $this->params,
                $this->header,
                $this->cookie
            );
        }catch (\Exception $ex){}

        return $this;
    }

    public function decode($json){
        $json = json_decode($json,true);
        return $json;
    }

    public function response($dump = true,$decode = true){
        if($dump){
            echo '<pre>';
            print_r($this->decode($this->response));
            echo '</pre>';
        }
        if($decode) return $this->decode($this->response);
        return $this->response;
    }
}
