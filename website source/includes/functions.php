<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function sanitize($input)
{
	if(empty($input) & !is_numeric($input))
	{
		return NULL;
	}
	
    global $link; // needed to refrence active MySQL connection
    return mysqli_real_escape_string($link, strip_tags(trim($input))); // return string with quotes escaped to prevent SQL injection, script tags stripped to prevent XSS attach, and trimmed to remove whitespace
}

function heador()
{
    global $link; // needed to refrence active MySQL connection
    global $role; // needed to refrence role
		?>
        <form class="text-left" method="POST">
		<p class="mb-4">Name:
			<br><?php echo $_SESSION['server_to_manage']; ?><br />
			<div class="mb-4">Verify Link:
                <br><a href="<?php echo "https://". ($_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME']) . "/verify/" . $_SESSION['username'] . "/" . $_SESSION['server_to_manage']; ?>" style="color:#00FFFF;" target="verifylink"><?php echo "https://". ($_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME']) . "/verify/" . $_SESSION['username'] . "/" . $_SESSION['server_to_manage']; ?></a><br />
			</div><a style="color:#4e73df;cursor: pointer;" id="mylink">Change</a>
			<button style="border: none;padding:0;background:0;color:#FF0000;padding-left:5px;" name="deleteserver" onclick="return confirm('Are you sure you want to delete server and all associated members?')">Delete</button>
		</p>
		</form>
		<?php
        if (isset($_POST['deleteserver']))
        {

            $server = sanitize($_SESSION['server_to_manage']);
            $serverid = $_SESSION['serverid'];

			mysqli_query($link, "DELETE FROM `members` WHERE `server` = '$serverid'") or die(mysqli_error($link)); // delete members
            mysqli_query($link, "DELETE FROM `servers` WHERE `name` = '$server' AND `owner` = '" . $_SESSION['username'] . "'") or die(mysqli_error($link)); // delete server

            if (mysqli_affected_rows($link) != 0)
            {
                $_SESSION['server_to_manage'] = NULL;
                $_SESSION['serverid'] = NULL;
                success("Successfully deleted Server!");
                echo "<meta http-equiv='Refresh' Content='2;'>";
            }
            else
            {
                error("Server Deletion Failed!");
                echo "<meta http-equiv='Refresh' Content='2;'>";
            }
        }

        if (isset($_POST['renameserver']))
        {
            $name = sanitize($_POST['name']);

            $result = mysqli_query($link, "SELECT * FROM `servers` WHERE `owner` = '" . $_SESSION['username'] . "' AND `name` = '$name'");
            $num = mysqli_num_rows($result);
            if ($num > 0)
            {
                error("You already have a server with this name!");
                echo "<meta http-equiv='Refresh' Content='2;'>";
                return;
            }
			
			$server = sanitize($_SESSION['server_to_manage']);

            mysqli_query($link, "UPDATE `servers` SET `name` = '$name' WHERE `name` = '$server' AND `owner` = '$server'");

            $_SESSION['server_to_manage'] = $name;

            if (mysqli_affected_rows($link) != 0)
            {
                success("Successfully Renamed Server!");
                echo "<meta http-equiv='Refresh' Content='2;'>";
            }
            else
            {
                error("Server Rename Failed!");
                echo "<meta http-equiv='Refresh' Content='2;'>";
            }
        }
		
		if (isset($_POST['appname']))
        {
            $appname = sanitize($_POST['appname']);
            $result = mysqli_query($link, "SELECT * FROM servers WHERE name='$appname' AND owner='" . $_SESSION['username'] . "'");
            if (mysqli_num_rows($result) > 0)
            {
                mysqli_close($link);
                error("You already own server with this name!");
                echo "<meta http-equiv='Refresh' Content='2;'>";
                return;
            }

            $owner = $_SESSION['username'];

            if ($role == "free")
            {
                $result = mysqli_query($link, "SELECT * FROM servers WHERE owner='$owner'");

                if (mysqli_num_rows($result) > 0)
                {
                    mysqli_close($link);
                    error("Free plan only supports one server!");
                    echo "<meta http-equiv='Refresh' Content='2;'>";

                    return;
                }

            }
			
			if(strlen($appname) > 20)
			{		
				mysqli_close($link);
                error("Character limit for server name is 20 characters, please try again with shorter name.");
                echo "<meta http-equiv='Refresh' Content='2;'>";
                return;
			}
			
            $result = mysqli_query($link, "INSERT INTO `servers`(`owner`, `name`) VALUES ('$owner','$appname')");
            if (mysqli_affected_rows($link) != 0)
            {
                $_SESSION['server_to_manage'] = $appname;
                $_SESSION['serverid'] = NULL;
                success("Successfully Created Server!");
                echo "<meta http-equiv='Refresh' Content='2;'>";
            }
            else
            {
                error("Failed to create application!");
            }
        }

}

function sidebar($admin)
{
	?>
	<li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i> <span class="hide-menu">Server</span></li>
	<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="../../server/settings/" aria-expanded="false"><i data-feather="settings"></i><span class="hide-menu">Settings</span></a></li> 
	<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="../../server/members/" aria-expanded="false"><i data-feather="users"></i><span class="hide-menu">Members</span></a></li>
	<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="../../server/blacklist/" aria-expanded="false"><i data-feather="user-x"></i><span class="hide-menu">Blacklist</span></a></li>
	<li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i> <span class="hide-menu">Account</span></li>
	<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="../../account/settings/" aria-expanded="false"><i data-feather="settings"></i><span class="hide-menu">Settings</span></a></li>
	<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="../../account/upgrade/" aria-expanded="false"><i data-feather="activity"></i><span class="hide-menu">Upgrade</span></a></li>
	<?php
	if($admin)
	{
	?>
	<li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i> <span class="hide-menu">Admin</span></li>
	<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="../admin/" aria-expanded="false"><i data-feather="move"></i><span class="hide-menu">Panel</span></a></li>
	<?php
	}
}

function error($msg)
{
    echo '<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css"><script type=\'text/javascript\'>
                
                            const notyf = new Notyf();
                            notyf
                              .error({
                                message: \'' . addslashes($msg) . '\',
                                duration: 3500,
                                dismissible: true
                              });               
                
                </script>';
}

function success($msg)
{
    echo '<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css"><script type=\'text/javascript\'>
                
                            const notyf = new Notyf();
                            notyf
                              .success({
                                message: \'' . addslashes($msg) . '\',
                                duration: 3500,
                                dismissible: true
                              });               
                
                </script>';
}

function premium_check($username)
{
	global $link; // needed to refrence active MySQL connection
	$result = mysqli_query($link, "SELECT * FROM `users` WHERE `username` = '$username' AND `role` = 'premium'");
	if(mysqli_num_rows($result) === 1)
	{
		$expiry = mysqli_fetch_array($result)["expiry"];
		if($expiry < time())
		{
			mysqli_query($link, "UPDATE `users` SET `role` = 'free' WHERE `username` = '$username'");
		}
	}
}

function apiRequest($url, $post = FALSE, $headers=array()) {
  
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

  $response = curl_exec($ch);


  if($post)
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

  $headers[] = 'Accept: application/json';

  if(session('access_token'))
    $headers[] = 'Authorization: Bearer ' . session('access_token'); 

  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  $response = curl_exec($ch);
  return json_decode($response);
}

function wh_log($webhook_url, $msg, $un)
{
    if (empty($webhook_url))
    {
        return;
    }

    $timestamp = date("c", strtotime("now"));

    $json_data = json_encode([
    // Message
    "content" => $msg,

    // Username
    "username" => "$un",

    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    $ch = curl_init($webhook_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-type: application/json'
    ));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    curl_exec($ch);
    curl_close($ch);
}

function get($key, $default=NULL) {
  return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
}

function session($key, $default=NULL) {
  return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
}

?>