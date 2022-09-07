<?php

function loadApi($params) {
	$ch = curl_init();

	$options = array(
		CURLOPT_URL => 'https://parkfor.com.br/contas/includes/api.php',
		CURLOPT_POST => true,
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_POSTFIELDS => $params
	);

	curl_setopt_array($ch, $options);

	$result = curl_exec($ch);
	
	curl_close($ch);
	
	return json_decode($result);
}
?>