<?php

include '../includes/connection.php';
include '../includes/functions.php';

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// When Discord redirects the user back here, there will be a "code" and "state" parameter in the query string
if(get('code') && strlen(get('code')) == 30) {

  // Exchange the auth code for a token
  $token = apiRequest("https://discord.com/api/oauth2/token", array(
    "grant_type" => "authorization_code",
    'client_id' => $client_id,
    'client_secret' => $client_secret,
    'redirect_uri' => $redirect_uri,
    'code' => get('code')
  ));
  $logout_token = $token->access_token;
  $_SESSION['access_token'] = $token->access_token;
  $_SESSION['refresh_token'] = $token->refresh_token;
					
  $server = $_SESSION['owner'] . '/' . $_SESSION['name'];
  header('Location: ' . $verify_uri . $server);
}

die("invalid request, please retry verification process");

?>