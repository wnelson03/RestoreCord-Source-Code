<?php
include '../includes/connection.php';
include '../includes/functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['username']))
{
    header("Location: ../dashboard/server/settings/");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>RestoreCord - Login</title>
	
	<link rel="icon" type="image/png" sizes="300x250" href="https://i.imgur.com/Nfy4OoG.png">
	<meta name="theme-color" content="#52ef52"/>
	<meta name="description" content="Backup Discord members and add them to new server in the event of a server raid or deletion."/>
	<meta name="og:image" content="https://i.imgur.com/zhLwuR4.png"/>
  
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.keyauth.uk/auth/css/util.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.keyauth.uk/auth/css/main.css">
</head>
<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-t-50 p-b-90">
				<form class="login100-form validate-form flex-sb flex-w" method="post">
					<span class="login100-form-title p-b-51">
						Login
					</span>

					
					<div class="wrap-input100 validate-input m-b-16">
						<input class="input100" type="text" name="username" placeholder="Username" required>
						<span class="focus-input100"></span>
					</div>
					
					
					<div class="wrap-input100 validate-input m-b-16">
						<input class="input100" type="password" name="password" placeholder="Password" required>
						<span class="focus-input100"></span>
					</div>

                    <div class="wrap-input100 validate-input m-b-16">
						<input class="input100" name="twofactor" placeholder="Two Factor Code (if applicable)">
						<span class="focus-input100"></span>
					</div>
					
					<input type="hidden" name="recaptcha_response" id="recaptchaResponse">
					
					<div class="flex-sb-m w-full p-t-3 p-b-24">
						<div>
							<a href="../register/" class="txt1">
								Register
							</a>
						</div>

						<div>
							<a href="../forgot/" class="txt1">
								Forgot?
							</a>
						</div>
					</div>

					<div class="container-login100-form-btn m-t-17">
						<button name="login" class="login100-form-btn">
							Login
						</button>
					</div>

				</form>
			</div>
		</div>
	</div>
	
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <?php
if (isset($_POST['login']))
{
    $username = sanitize($_POST['username']);
    $password = sanitize($_POST['password']);

    ($result = mysqli_query($link, "SELECT * FROM `users` WHERE `username` = '$username'")) or die(mysqli_error($link));

    if (mysqli_num_rows($result) == 0)
    {
        error("Account doesn\'t exist!");
        return;
    }
    while ($row = mysqli_fetch_array($result))
    {
        $pass = $row['password'];
        $email = $row['email'];
        $role = $row['role'];
        $banned = $row['banned'];

        $twofactor_optional = $row['twofactor'];
        $google_Code = $row['googleAuthCode'];
    }

    if (!is_null($banned))
    {
        error("Banned: Reason: " . sanitize($banned));
        return;
    }

    if (!password_verify($password, $pass))
    {
        error("Password is invalid!");
        return;
    }

    if ($twofactor_optional)
    {
        $twofactor = sanitize($_POST['twofactor']);
        if (empty($twofactor))
        {
            error("Two factor field needed for this acccount!");
            return;
        }

        require_once '../auth/GoogleAuthenticator.php';
        $gauth = new GoogleAuthenticator();
        $checkResult = $gauth->verifyCode($google_Code, $twofactor, 2);

        if (!$checkResult)
        {
            error("2FA code Invalid!");
            return;
        }
    }
	
	// webhook start
	$timestamp = date("c", strtotime("now"));
	
	$json_data = json_encode([
	// Message
	"content" => "{$username} has logged in with ip `" . $_SERVER['HTTP_CF_CONNECTING_IP'] . "`",
	
	// Username
	"username" => "RestoreCord Logs",
	
	], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
	
	$ch = curl_init($Logs);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-type: application/json'
	));
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	
	curl_exec($ch);
	curl_close($ch);
	// webhook end

    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
    $_SESSION['role'] = $role;

    header("location: ../dashboard/server/settings/");
}
?>
</body>
</html>