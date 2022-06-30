<?php

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

include '../includes/connection.php';
include '../includes/functions.php';

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$uri = trim($_SERVER['REQUEST_URI'], '/');
$pieces = explode('/', $uri);
$owner = urldecode(sanitize($pieces[1]));
$server = urldecode(sanitize($pieces[2]));

if (is_null($owner) || is_null($server)) {
	die("Invalid link. Link should look like https://restorecord.com/verify/{owner}/{server}");
}

premium_check($owner);

$result = mysqli_query($link, "SELECT * FROM `servers` WHERE `owner` = '$owner' AND `name` = '$server'");

if (mysqli_num_rows($result) === 0) {
	$server = "Not Available";
	$serverpic = "https://i.imgur.com/7kiO9No.png";
	$status = "noserver"; // server not found
} else {
	$status = NULL;
	while ($row = mysqli_fetch_array($result)) {
		$guildid = $row['guildid'];
		$roleid = $row['roleid'];
		$serverpic = $row['pic'];

		$redirecturl = $row['redirecturl'];
		$webhook = $row['webhook'];
		$vpncheck = $row['vpncheck'];
		$banned = $row['banned'];
	}

	if (!is_null($banned)) {
		$_SESSION['access_token'] = NULL;
		$status = "banned";
	} else {
		$_SESSION['server'] = $guildid;
		$_SESSION['owner'] = $owner;
		$_SESSION['name'] = $server;
	}
}

if (session('access_token')) {

	$user_check = mysqli_query($link, "SELECT * FROM `users` WHERE `username` = '$owner'");
	$role = mysqli_fetch_array($user_check)["role"];

	$result = mysqli_query($link, "SELECT * FROM `members` WHERE `server` = '$guildid'");
	if (mysqli_num_rows($result) > 25 && $role == "free") {
		$status = "needpremium";
	} else {

		$user = apiRequest("https://discord.com/api/users/@me");

		// echo var_dump($user);

		$headers = array(
			'Content-Type: application/json',
			'Authorization: Bot ' . $BotToken
		);
		$data = array(
			"access_token" => session('access_token')
		);
		$data_string = json_encode($data);

		$result = mysqli_query($link, "SELECT * FROM `blacklist` WHERE (`user` = '" . $user->id . "' OR `ip` = '" . $_SERVER['HTTP_CF_CONNECTING_IP'] . "') AND `server` = '$guildid'");
		if (mysqli_num_rows($result) > 0) {
			$status = "blacklisted";
		} else {

			$ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
			if ($vpncheck) {
				$url = "https://proxycheck.io/v2/{$ip}?key=proxyCheckKeyHere?vpn=1";
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$result = curl_exec($ch);
				curl_close($ch);
				$json = json_decode($result);
				if ($json->$ip->proxy == "yes") {
					$status = "vpndetect";
					if (!is_null($webhook)) {
						/*
							WEBHOOK START
						*/

						$timestamp = date("c", strtotime("now"));

						$json_data = json_encode([

							// Embeds Array
							"embeds" => [
								[
									// Embed Title
									"title" => "Failed VPN Check",
									// Embed Type
									"type" => "rich",
									// Timestamp of embed must be formatted as ISO8601
									"timestamp" => $timestamp,
									// Embed left border color in HEX
									"color" => hexdec("ff0000"),
									// Footer
									// "footer" => [
									// 
									// "text" => $name
									// 
									// ],

									// Additional Fields array
									"fields" => [["name" => ":bust_in_silhouette: User:", "value" => "```" . $user->id . "```", "inline" => true], ["name" => ":earth_americas: Client IP:", "value" => "```" . $_SERVER["HTTP_CF_CONNECTING_IP"] . "```", "inline" => true]]

								]

							]

						], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

						$ch = curl_init($webhook);

						curl_setopt($ch, CURLOPT_HTTPHEADER, array(
							'Content-type: application/json'
						));

						curl_setopt($ch, CURLOPT_POST, 1);
						curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
						curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
						curl_setopt($ch, CURLOPT_HEADER, 0);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_exec($ch);
						curl_close($ch);
						/*
							WEBHOOK END
						*/
					}
				}
			}

			if ($status !== "vpndetect") {
				$_SESSION['userid'] = $user->id;

				$url = "https://discord.com/api/guilds/{$guildid}/members/" . $user->id;
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$result = curl_exec($ch);
				// $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				curl_close($ch);

				// echo var_dump($result);
				// echo 'HTTP code: ' . $httpcode;

				$url = "https://discord.com/api/guilds/{$guildid}/members/" . $user->id . "/roles/{$roleid}";
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$result = curl_exec($ch);
				// $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

				curl_close($ch);

				// echo var_dump($result);
				// echo 'HTTP code: ' . $httpcode;

				// mysqli_query($link, "INSERT INTO `members` (`userid`, `access_token`, `refresh_token`, `server`) VALUES ('" . $user->id . "', '" . $_SESSION['access_token'] . "', '" . $_SESSION['refresh_token'] . "', '$guildid') ON DUPLICATE KEY UPDATE `access_token` = '" . $_SESSION['access_token'] . "', `refresh_token` = '" . $_SESSION['refresh_token'] . "'");
				mysqli_query($link, "REPLACE INTO `members` (`userid`, `access_token`, `refresh_token`, `server`,`ip`) VALUES ('" . $user->id . "', '" . $_SESSION['access_token'] . "', '" . $_SESSION['refresh_token'] . "', '$guildid', '$ip')");
				$_SESSION['access_token'] = NULL;
				$_SESSION['refresh_token'] = NULL;

				if (!is_null($webhook)) {
					/*
						WEBHOOK START
					*/

					$timestamp = date("c", strtotime("now"));

					$json_data = json_encode([

						// Embeds Array
						"embeds" => [
							[
								// Embed Title
								"title" => "Successfully Verified",
								// Embed Type
								"type" => "rich",
								// Timestamp of embed must be formatted as ISO8601
								"timestamp" => $timestamp,
								// Embed left border color in HEX
								"color" => hexdec("52ef52"),
								// Footer
								// "footer" => [
								// 
								// "text" => $name
								// 
								// ],

								// Additional Fields array
								"fields" => [["name" => ":bust_in_silhouette: User:", "value" => "```" . $user->id . "```", "inline" => true], ["name" => ":earth_americas: Client IP:", "value" => "```" . $_SERVER["HTTP_CF_CONNECTING_IP"] . "```", "inline" => true]]

							]

						]

					], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

					$ch = curl_init($webhook);

					curl_setopt($ch, CURLOPT_HTTPHEADER, array(
						'Content-type: application/json'
					));

					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
					curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
					curl_setopt($ch, CURLOPT_HEADER, 0);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_exec($ch);
					curl_close($ch);
					/*
						WEBHOOK END
					*/
				}

				$status = "added"; // successfully verified user
			}
		}
	}
}

if (isset($_POST['optout'])) {
	if (session('userid')) {
		mysqli_query($link, "DELETE FROM `members` WHERE `userid` = '" . session('userid') . "' AND `server`  = '$guildid'");
		if (mysqli_affected_rows($link) != 0) {
			$headers = array(
				'Content-Type: application/json',
				'Authorization: Bot ' . $BotToken
			);

			$url = "https://discord.com/api/guilds/{$guildid}/members/" . session('userid') . "/roles/{$roleid}";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
			// curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			echo $result;

			$status = "optedout";
			if (!is_null($webhook)) {
				/*
					WEBHOOK START
				*/

				$timestamp = date("c", strtotime("now"));

				$json_data = json_encode([

					// Embeds Array
					"embeds" => [
						[
							// Embed Title
							"title" => "User Opted Out",
							// Embed Type
							"type" => "rich",
							// Timestamp of embed must be formatted as ISO8601
							"timestamp" => $timestamp,
							// Embed left border color in HEX
							"color" => hexdec("ff0000"),
							// Footer
							// "footer" => [
							// 
							// "text" => $name
							// 
							// ],

							// Additional Fields array
							"fields" => [["name" => ":bust_in_silhouette: User:", "value" => "```" . session('userid') . "```", "inline" => true], ["name" => ":earth_americas: Client IP:", "value" => "```" . $_SERVER["HTTP_CF_CONNECTING_IP"] . "```", "inline" => true]]

						]

					]

				], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

				$ch = curl_init($webhook);

				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Content-type: application/json'
				));

				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_exec($ch);
				curl_close($ch);
				/*
					WEBHOOK END
				*/
			}
		} else {
			$status = "neveroptedin";
		}
	} else {
		$status = "notauthed";
	}
}

?>
<!DOCTYPE html>
<html>

<head>
	<title>Verify in <?php echo $server; ?></title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<link rel="icon" type="image/png" sizes="16x16" href="https://i.imgur.com/w65Dpnw.png">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link id="mystylesheet" rel="stylesheet" type="text/css" href="../style.css">

	<meta name="og:image" content="<?php echo $serverpic; ?>">
	<meta name="description" content="Verify in <?php echo $server; ?> so you're added back to server if it gets raided or deleted.">

</head>

<body>

	<div id="box">
		<?php switch ($status) {
			case 'added':
		?>
				<div class="alert alert-success">
					<strong>Success!</strong> Successfully verified.
				</div>
				<?php
				if (!is_null($redirecturl)) {
					echo "<meta http-equiv='Refresh' Content='3;url={$redirecturl}'>";
				}
				break;
			case 'optedout':
				?>
				<div class="alert alert-success">
					<strong>Success!</strong> Successfully opted out from this server.
				</div>
			<?php
				break;
			case 'noserver':
			?>
				<div class="alert alert-danger">
					<strong>Oh snap!</strong> No server found.
				</div>
			<?php
				break;
			case 'blacklisted':
			?>
				<div class="alert alert-danger">
					<strong>Oh snap!</strong> This user is blacklisted.
				</div>
			<?php
				break;
			case 'banned':
			?>
				<div class="alert alert-danger">
					<strong>Oh snap!</strong> This server has been banned for: <?php echo sanitize($banned); ?>
				</div>
			<?php
				break;
			case 'vpndetect':
			?>
				<div class="alert alert-danger">
					<strong>Oh snap!</strong> Server owner has disabled VPN access, try again without VPN.
				</div>
			<?php
				break;
			case 'needpremium':
			?>
				<div class="alert alert-danger">
					<strong>Oh snap!</strong> Server owner needs to purchase premium, he has reached 25 member limit for free users. Please tell him, thank you.
				</div>
			<?php
				break;
			case 'notauthed':
			?>
				<div class="alert alert-danger">
					<strong>Oh snap!</strong> You need to login with discord first.
				</div>
			<?php
				break;
			case 'neveroptedin':
			?>
				<div class="alert alert-danger">
					<strong>Oh snap!</strong> You were never opted-in.
				</div>
		<?php
				break;
			default:
				break;
		}
		?>
		<img id="server_pic" src="<?php echo $serverpic; ?>">
		<h2><?php echo $server; ?></h2>
		<p>Click login with Discord to be joined to server if it is ever raided or deleted. Click opt out to stop getting joined to server.</p>
		<hr>
		<form method="post">
			<a class="btn btn-light" href="https://discord.com/api/oauth2/authorize?client_id=791106018175614988&redirect_uri=https%3A%2F%2Frestorecord.com%2Fauth%2F&response_type=code&scope=identify+guilds.join">Login With Discord</a>
			<button name="optout" class="btn btn-danger">Opt Out</button>
		</form>
	</div>
</body>

</html>