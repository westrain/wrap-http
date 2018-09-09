<?php

interface IRequest
{
    public function send();
    public function get($url,$params,$header,$cookie);
    public function post($url,$params,$header,$cookie);
}