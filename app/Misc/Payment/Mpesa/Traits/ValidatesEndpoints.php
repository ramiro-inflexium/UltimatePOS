<?php


namespace App\Misc\Payment\Mpesa\Traits;


trait ValidatesEndpoints
{
    protected $default_endpoints = [];
    protected $endpoint = null;

    /**
     * @param string $env
     * @throws \ErrorException
    */

    public function validateEndpoints(string $env){
        if (!$this->endpoint){
            if (!in_array($env)){
                throw new \ErrorException('End point missing');
            }
            $this->endpoint = $this->default_endpoints[$env];
        }
    }
}