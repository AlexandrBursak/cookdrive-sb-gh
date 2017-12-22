<?php


$content = file_get_contents("php://input");
$config = require(__DIR__ . '/../config/skype.php');

if($content) {
	$IN = json_decode($content, true);
	
	if($IN['type'] == "message") {
		$params=array
			(
			'client_id' => $config['app_id'],
			'client_secret' => $config['app_secret'],         
			'grant_type'=>'client_credentials',                   
			'scope'=>'https://api.botframework.com/.default'
			);
		$result=file_get_contents($config['authUri'], false, stream_context_create(array('http' => array
			(
			'method' => 'POST',
			'header' => 'Content-type: application/x-www-form-urlencoded',
			'content' => http_build_query($params)
			))));

		$token = json_decode($result, TRUE);
		
		$url = $config['baseUri'].'conversations/'.$IN['conversation']['id'].'/activities';
		
		if($IN['text'] == '!getid') {
			$IN['text'] = $IN['conversation']['id'];
		} else $IN['text'] = 'Для того, щоб отримувати сповіщення від скайп бота введіть команду !getid та збережіть id в профілі SoftBistroFood';
		
		$data_string = json_encode($IN);

		$ch = curl_init();                 
		curl_setopt($ch, CURLOPT_URL, $url);   
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);                                                                                                                    
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                       
		curl_setopt($ch, CURLOPT_POST, 1);                                                                        

		$headers = array();
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Authorization: Bearer '.$token['access_token'];
		$headers[] = 'Content-Length: ' . strlen($data_string);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}

		curl_close ($ch);
	}
	
}
?>

