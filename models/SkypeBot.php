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

use Yii;

class SkypeBot 
{
	
	private $skype_id = null;
	private $client_id;
	private $client_secret;
	private $token = null;
	private $authUri;
	private $baseUri;
	
	public function init()
	{
		$config = require(__DIR__ . '/../config/skype.php');
		$this->client_id = $config['app_id'];
		$this->client_secret = $config['app_secret'];
		$this->authUri = $config['authUri'];
		$this->baseUri = $config['baseUri'];
	}
	
	public function getToken()
	{	
		$params=array(
			'client_id' => $this->client_id, 
			'client_secret' => $this->client_secret,          
			'grant_type' => 'client_credentials',                    
			'scope' => 'https://api.botframework.com/.default');
			
		$result=file_get_contents($this->authUri, false, stream_context_create(array('http' => array(
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
		$this->skype_id = Profile::find()->select('skype_id')->where(['user_id' => Yii::$app->user->id])->asArray()->one();
		return $this->skype_id;
	}
	
	public function sendOrder($order) 
	{
		$sum = 0;
		$message = 'Заказ успешно оформлен!\n\nВаш заказ:\n\n';
						
		foreach($order as $key => $dish)
		{
			$message .= $dish['product_name'].' | ';
			$message .= $dish['quantity'].'шт. | ';
			$message .= $dish['sum'].'грн.\n\n';
			$sum += $dish['sum'];
		}
		$message .= '\n\nВсего: '.$sum.'грн.';
		$this->send($message);
	}
	
	public function send($message)
	{
		$this->auth();
		$url = $this->baseUri.'conversations/'.$this->skype_id['skype_id'].'/activities';
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