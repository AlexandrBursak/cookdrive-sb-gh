<?

$content = file_get_contents("php://input");

if($content) {
	$IN = json_decode($content, true);

	$url='https://login.microsoftonline.com/botframework.com/oauth2/v2.0/token';
	$params=array
		(
		'client_id' => '<APP_ID>',
		'client_secret' => '<APP_SECRET>',         
		'grant_type'=>'client_credentials',                   
		'scope'=>'https://api.botframework.com/.default'
		);
	$result=file_get_contents($url, false, stream_context_create(array('http' => array
		(
		'method' => 'POST',
		'header' => 'Content-type: application/x-www-form-urlencoded',
		'content' => http_build_query($params)
		))));

	$token = json_decode($result, TRUE);

	$url = 'https://smba.trafficmanager.net/apis/v3/conversations/'.$IN['conversation']['id'].'/activities';
	$data_string = '
	{
	  "type": "message",
	  "from": {
		"id": "'.$IN['recipient']['id'].'",
		"name": "Echo Bot"
	  },
	  "conversation": {
		"id": "'.$IN['conversation']['id'].'"
	  },
	  "recipient": {
		"id": "'.$IN['conversation']['id'].'",
		"name": "User Name"
	  },
	  "text": "Test Answer",
	  "replyToId": "'.$IN['from']['id'].'"
	}
	';

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
?>

