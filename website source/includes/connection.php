<?php

error_reporting(0);

$link = mysqli_connect("localhost", "databaseUsernameHere", "databasePasswordHere", "databaseNameHere");

if ($link === false) {
    die("Error with db...");
}

// Discord Bot
$client_id = "DiscordBotClientID";
$client_secret = "DiscordBotClientSecret";
$BotToken = "DiscordBotToken";

$redirect_uri = "https://restorecord.com/auth/"; // AUTH
$verify_uri = "https://restorecord.com/verify/";
$ShoppySecret = ""; // replace with your webhook secret
$shoppyApiKey = "";

// Webhooks
$AdminLogs = "";
$Logs = "";

?>