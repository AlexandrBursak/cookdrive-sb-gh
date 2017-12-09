<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 17.01.17
 * Time: 17:17
 */

namespace app\models;

use app\models\Order;
use app\models\Profile;

class SkypeBot 
{
	
	private $skype_id = null;
	private $client_id = '<APP_ID>';
	private $client_secret = '<APP_SECRET>';
	private $token = null;
	
	public function getToken()
	{
		$url='https://login.microsoftonline.com/botframework.com/oauth2/v2.0/token';
		
		$params=array(
			'client_id' => $this->client_id, 
			'client_secret' => $this->client_secret,          
			'grant_type' => 'client_credentials',                    
			'scope' => 'https://api.botframework.com/.default');
			
		$result=file_get_contents($url, false, stream_context_create(array('http' => array(
			'method' => 'POST',
			'header' => 'Content-type: application/x-www-form-urlencoded',
			'content' => http_build_query($params)))));

		$token = json_decode($result, TRUE);
		
		return $token['access_token'];
	}
	
	public function auth() 
	{
		$this->token = $this->getToken();
		$this->skype_id = $this->getSkypeId();
	}
	
	public function getSkypeId() 
	{
		//$this->skype_id = Profile::getSkypeId();

		return '29%3A1G4aGMUwgfji1N6UfCahar98IOuvvDp-Q-doHYHrNaZk';
	}
	
	public function send($message)
	{
		$this->auth();
		$url = 'https://smba.trafficmanager.net/apis/v3/conversations/'.$this->skype_id.'/activities';
		$data_string = '
		{
		  "type": "message",
		  "text": "'.$message.'",
		}
		';

		$ch = curl_init();                 
		curl_setopt($ch, CURLOPT_URL, $url);   
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);                                                                                                                    
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                       
		curl_setopt($ch, CURLOPT_POST, 1);                                                                        

		$headers = array();
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Authorization: Bearer '.$this->token;
		$headers[] = 'Content-Length: ' . strlen($data_string);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}

		curl_close ($ch);
	}
	
}