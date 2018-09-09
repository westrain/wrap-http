<?php

interface IRequest
{
    public function send();
    public function get($url,$params,$header,$headerPrams,$cookie);
    public function post($url,$params,$header,$headerPrams,$cookie);
}