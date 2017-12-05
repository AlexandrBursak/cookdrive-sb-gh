<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 17.01.17
 * Time: 17:17
 */

namespace app\models;

use app\models\Order;
use yii\httpclient\Client;

class SkypeBot 
{
	
	public function send($route, $data)
	{
		$client = new Client();
		$response = $client->createRequest()
			->setMethod('post')
			->setUrl('https://foodbistro.azurewebsites.net/api/'.$route)
			->setData($data)
			->send();
	}
	
	public function sendMessageToAdmin($message) 
	{
		$data = ['message' => $message];
		SkypeBot::send('messageToAdmin', $data);
	}
	
	public function createOrderCards($data)
	{
		SkypeBot::send('messageWithCards', ['cards' => json_encode($data)]);
	}
	
}