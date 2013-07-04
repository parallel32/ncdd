<?php
namespace Saw\Component\Connect;

abstract class Connect {
	
	public $app;
	public $oauth;
	public $accessToken;

	public function __construct(\Silex\Application $app){
		$this->app  = $app;
	}
	
	abstract public function requestToken();
	
	abstract function accessToken($access_token);
	
	abstract function validate();

	abstract function getUser($access_token);
	
	abstract function getUserResponse($response);
	
	abstract function grape($message, $link, $picture, $optional=array());
	
	/*
	public function post($request);
		
	public function postRequest($request);
	
	public function postResponse($response);
	//*/
	
	
}