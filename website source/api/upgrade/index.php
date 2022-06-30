<?php
include '../../includes/connection.php';

$payload = file_get_contents('php://input');

$secret = $ShoppySecret; // replace with your webhook secret
$header_signature = $_SERVER["HTTP_X_SHOPPY_SIGNATURE"]; // get our signature header

$signature = hash_hmac('sha512', $payload, $secret);

if (hash_equals($signature, $header_signature)) {

$json = json_decode($payload);
// in terms of looking at shoppy API, $json = $payload
if ($json->event === 'order:paid') {
	$data = $json->data;
	$order = $data->order;
	// $product = $order->product;
	
	$product = $json->data->order->product;
	$un = $json->data->order->custom_fields[0]->value;
	
	switch($product->title)
	{	
		case "RestoreCord Premium":
			$expires = time() + 31556926;
			mysqli_query($link, "UPDATE `users` SET `role` = 'premium',`expiry` = '$expires' WHERE `username` = '$un'");
			die("upgraded to premium");
		default:
			die("invalid product");	
	}
}
else
{
	die("didn't pay");
}

}

die("You shouldn't be here");

?>