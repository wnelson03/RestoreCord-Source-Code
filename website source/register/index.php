<?php
include '../includes/connection.php';
include '../includes/functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_SESSION['username']))
{
    header("Location: ../dashboard/server/settings/");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>RestoreCord - Register</title>
	
	<link rel="icon" type="image/png" sizes="300x250" href="https://i.imgur.com/Nfy4OoG.png">
	<meta name="theme-color" content="#52ef52"/>
	<meta name="description" content="Backup Discord members and add them to new server in the event of a server raid or deletion."/>
	<meta name="og:image" content="https://i.imgur.com/zhLwuR4.png"/>
	
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.keyauth.uk/auth/css/util.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.keyauth.uk/auth/css/main.css">
	<script src="https://www.google.com/recaptcha/api.js?render=6LczE5wcAAAAAHXJy3TX_KzaK45ZvegzqcAeoJ-i"></script>
    <script>
        grecaptcha.ready(function () {
            grecaptcha.execute('6LczE5wcAAAAAHXJy3TX_KzaK45ZvegzqcAeoJ-i', { action: 'contact' }).then(function (token) {
                var recaptchaResponse = document.getElementById('recaptchaResponse');
                recaptchaResponse.value = token;
            });
        });
    </script>
</head>
<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-t-50 p-b-90">
				<form class="login100-form validate-form flex-sb flex-w" method="post">
					<span class="login100-form-title p-b-51">
						Register
					</span>

					
					<div class="wrap-input100 validate-input m-b-16">
						<input class="input100" type="text" name="username" placeholder="Username" minlength="2" required>
						<span class="focus-input100"></span>
					</div>
					
					<div class="wrap-input100 validate-input m-b-16">
						<input class="input100" type="email" name="email" placeholder="Email" required>
						<span class="focus-input100"></span>
					</div>
					
					
					<div class="wrap-input100 validate-input m-b-16">
						<input class="input100" type="password" name="password" minlength="5" placeholder="Password" required>
						<span class="focus-input100"></span>
					</div>
					
					<input type="hidden" name="recaptcha_response" id="recaptchaResponse">
					
					<div class="flex-sb-m w-full p-t-3 p-b-24">

						<div>
							<a href="../login/" class="txt1">
								Already Registered?
							</a>
						</div>
					</div>
					
					<h>All registered users are bound by the <a href="../terms" class="txt1" target="_blank">Terms of Service and Privacy Policy</a></h>

					<div class="container-login100-form-btn m-t-17">
						<button name="register" class="login100-form-btn">
							Register
						</button>
					</div>

				</form>
			</div>
		</div>
	</div>
	
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

  <?php
if (isset($_POST['register']))
{
    $recaptcha_response = sanitize($_POST['recaptcha_response']);
    $recaptcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=captchaSecretHere&response=' . $recaptcha_response);
    $recaptcha = json_decode($recaptcha);

    // Take action based on the score returned:
    if ($recaptcha->score < 0.5)
    {
        error("Human Check Failed!");
        return;
    }

    $username = sanitize($_POST['username']);
	
	if (strpos($username, '#') !== false) {
		error("You cannot have a hashtag in your username, it will mess up your verification link.");
        return;
	}

    $password = sanitize($_POST['password']);

    $email = sanitize($_POST['email']);

    $result = mysqli_query($link, "SELECT * FROM `users` WHERE `username` = '$username'") or die(mysqli_error($link));

    if (mysqli_num_rows($result) == 1)
    {
        error("Username already taken!");
        return;
    }

    $email_check = mysqli_query($link, "SELECT * FROM `users` WHERE `email` = '$email'") or die(mysqli_error($link));
    $do_email_check = mysqli_num_rows($email_check);
    // $row = mysqli_fetch_array($email_check);
    if ($do_email_check > 0)
    {
        error('Email already used by username: ' . mysqli_fetch_array($email_check) ['username'] . '');
        return;
    }
    $pass_encrypted = password_hash($password, PASSWORD_BCRYPT);

	$paidusers = array("archiehazle69@gmail.com", "megaclart@gmail.com", "noh4ndo@gmail.com", "eliassolomonides0@gmail.com", "lunalotus303@gmail.com", "bloodofsniper9@gmail.com", "visual2353525235@gmail.com", "antim8sam@gmail.com", "x3hy161@gmail.com", "caztokarczyk2008@gmail.com", "prinz20005@gmail.com", "leoamplayen@gmail.com", "laskfoul@gmail.com", "atomicss@protonmail.com", "dateigreen2@gmail.com", "kaciyoung421@gmail.com", "nclan227@gmail.com", "henriksday@gmail.com", "ob3yxnuke@gmail.com", "kenealex09@gmail.com", "welpnate@gmail.com", "ehapostal04@gmail.com", "kevinlu135@gmail.com", "yang91660@gmail.com", "airportpickuplondo@gmail.com", "laraang12345@gmail.com", "tkfq242@gmail.com", "danmobile038@gmail.com", "sintiaqueiroz427@gmail.com", "maxi2000minecraft@gmail.com", "stephensimban989@yahoo.com", "tommii.j1996@gmail.com", "snipcola@gmail.com", "gersonr1538@gmail.com", "vitus@skjoldjensen.dk", "anthonydanielt07@gmail.com", "0515151@dadeschools.net", "jennygwyther@gmail.com", "seppesels20@gmail.com", "frrberbgrbgrbg@gmail.com", "brysoneschbach07@gmail.com", "holte1740@gmail.com", "breixopd14@gmail.com", "98494977az@gmail.com", "xjimmymemecord@gmail.com", "nullydiscord@gmail.com", "lionelgamer@gmx.de", "braydenapps@icloud.com", "stevierrodriguez@gmail.com", "jacbenimble2@gmail.com", "universehvh@gmail.com", "jadawi.013@gmail.com", "xakexdk@gmail.com", "qwdqwdqwe@a.com", "giorgi.pailodze@yahoo.com", "artixdiscord2@gmail.com", "haynesjordan470@gmail.com", "damian.tna.cruz@gmail.com", "aryanjha635@gmail.com", "rodrigomacias2087@gmail.com", "zaidanisagamer@gmail.com", "79zl3n12sifr@maskme.us", "maciachristopher24@gmail.com", "killowattcheats@gmail.com", "yournan@gmail.com", "sllimekez@gmail.com", "isaacriehm1@gmail.com", "andrej5154@seznam.cz", "evanhennesey@gmail.com", "diamodman1955@gmail.com", "epicgamersonly123@gmail.com", "colton.hieu.meador@gmail.com", "cartiieer3@gmail.com", "jadenrender939@protonmail.com", "glockritter@gmail.com", "milanimkohl@gmail.com", "tobio3690@gmail.com", "uselessemail158@gmail.com", "b4uarmy@protonmail.com", "lolmanlolman555@gmail.com", "jespers457@gmail.com", "premium11romeo@gmail.com", "Tristanisabruh@gmail.com", "ganeshbrandon500@gmail.com", "hi@exec.gq", "activelag2017@gmail.com", "l0w4nyu@gmail.com", "realitynova282@gmail.com", "jynxzy9062@gmail.com", "fizzypsn11@gmail.com", "pandherfateh@gmail.com", "eruchavez0.3@gmail.com", "fahadsheikhx@gmail.com", "ncucchiara26@gmail.com", "jerorcaden@gmail.com", "urosjeremic321@gmail.com", "terelle993@gmail.com", "tommymorton34@outlook.com", "kuahy5969@gmail.com", "minerdallasgaming@gmail.com", "xbruno.martins@live.com", "elie.salhany@outlook.com", "hneesunchee@gmail.com", "Kudosore@gmail.com", "syzm3kflis@gmail.com", "UberPabloTV@gmail.com", "soulgamingyt1@gmail.com", "brysxnardon@gmail.com", "cyberlobbycodwar@gmail.com", "vixrust@gmail.com", "chelsea.rvx@gmail.com", "animeisadev@gmail.com", "gamerzpartner@gmail.com", "arty@creativeproxies.com", "tartarsauce41@gmail.com", "jimmydelazerna321@gmail.com", "reeceraweu@gmail.com", "earlystefke@gmail.com", "abanoubgiris@gmail.com", "mono2lith@gmail.com", "sidiousalliance@gmail.com", "Kushy5969@gmail.com", "obetzonplug@gmail.com", "makingufree@outlook.com", "mirya6987@gmail.com", "anlistofikrian@gmail.com", "Scottywhitey@yahoo.com", "anthonyrphipps@gmail.com", "charleshartman06@gmail.com", "Averyg710@gmail.com", "billie@bloh.sh", "caturner69@gmail.com", "tvchannelpromo@gmail.com", "Habosrie@gmail.com", "othm1009@gmail.com", "tristangrsge@gmail.com", "b3tagaming692@gmail.com", "karma42018@gmail.com", "wlsnsrvcs@gmail.com", "TheWhiteHatCheater@gmail.com", "ace@aceservices.shop", "uk.wso2006@gmail.com", "mightyatshop@gmail.com", "zaidocr@gmail.com", "onebreadhax@gmail.com", "hassanlemars@gmail.com", "nitrosnekrosigetis@gmail.com", "acerat105@gmail.com", "potegarcia05@gmail.com", "aaronaj222@live.com", "jareddicus@icloud.com", "kaceip@gmail.com", "mattdaignault14@gmail.com", "tom.j.shillito@gmail.com", "rabbadi3939@gmail.com", "pkmodz.com@gmail.com", "eliassolomonides0@gmail.com", "scatterhvh@gmail.com", "gamingwithgabe2002@gmail.com", "jordanberiana63@gmail.com", "ramenV7@outlook.com", "spencerfarrell32@gmail.com", "senpaitrey@gmail.com", "viniciuslimajoinville@gmail.com", "banno_greg@yahoo.com", "LucidDreamAlt01@protonmail.com", "newfortemail@gmail.com", "napsterboost@gmail.com", "noahhand@mail.com", "flickmor@protonmail.com", "balint.andrei2019@gmail.com", "maffank92@gmail.com", "Chrisw33560@gmail.com", "PrelacyJ@outlook.com", "zootedmods@gmail.com", "Siccopaypal1@gmail.com", "Anth161616@hotmail.co.uk", "dmitry.mynett@gmail.com", "coranmitchell2021@gmail.com", "ayden241@hotmail.com", "guzguzjesse@gmail.com", "gomcakesservices@gmail.com", "arabitsherr@gmail.com", "rivaldivision123@gmail.com", "psychil@krimnizo.com", "samgefx@gmail.com");
	if(in_array($email, $paidusers))
	{
		$time = time() + 31556926;
		mysqli_query($link, "INSERT INTO `users` (`username`, `email`, `password`, `role`,`expiry`) VALUES ('$username', '$email', '$pass_encrypted', 'premium', '$time')") or die(mysqli_error($link));
	}
	else
	{
		mysqli_query($link, "INSERT INTO `users` (`username`, `email`, `password`) VALUES ('$username', '$email', '$pass_encrypted')") or die(mysqli_error($link));
	}
	
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
    $_SESSION['role'] = 'tester';
    $_SESSION['img'] = 'https://i.imgur.com/w65Dpnw.png	';
    mysqli_close($link);
    
	header("location: ../dashboard/server/settings/");
}

?> 
</body>
</html>