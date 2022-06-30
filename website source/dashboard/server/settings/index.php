<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../../../includes/connection.php';
include '../../../includes/functions.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../../../login/");
    exit();
}

$username = $_SESSION['username'];

premium_check($username);

($result = mysqli_query($link, "SELECT * FROM `users` WHERE `username` = '$username'")) or die(mysqli_error($link));
$row = mysqli_fetch_array($result);

$banned = $row['banned'];
if (!is_null($banned)) {
    echo "<meta http-equiv='Refresh' Content='0; url=../../../login/'>";
    session_destroy();
    exit();
}

$role = $row['role'];
$_SESSION['role'] = $role;

$darkmode = $row['darkmode'];
$isadmin = $row['admin'];

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RestoreCord - Settings</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="300x250" href="https://i.imgur.com/Nfy4OoG.png">
    <script src="https://cdn.keyauth.uk/dashboard/assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Custom CSS -->
    <link href="https://cdn.keyauth.uk/dashboard/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="https://cdn.keyauth.uk/dashboard/assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <link href="https://cdn.keyauth.uk/dashboard/assets/extra-libs/c3/c3.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="https://cdn.keyauth.uk/dashboard/dist/css/style.min.css" rel="stylesheet">

    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <script src="https://cdn.keyauth.uk/dashboard/unixtolocal.js"></script>


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <?php

    if (!isset($_SESSION['server_to_manage'])) // no app selected yet

    {

        $result = mysqli_query($link, "SELECT * FROM `servers` WHERE `owner` = '$username'"); // select all apps where owner is current user
        if (mysqli_num_rows($result) > 0) // if the user already owns an app, proceed to change app or load only app

        {

            if (mysqli_num_rows($result) == 1) // if the user only owns one app, load that app (they can still change app after it's loaded)

            {
                $row = mysqli_fetch_array($result);
                $_SESSION['server_to_manage'] = $row["name"];
                $_SESSION['serverid'] = $row["guildid"];
    ?>
                <script type='text/javascript'>
                    $(document).ready(function() {
                        $("#content").fadeIn(1900);
                        $("#sticky-footer bg-white").fadeIn(1900);
                    });
                </script>
            <?php
            } else
            // otherwise if the user has more than one app, choose which app to load

            {
            ?>
                <script type='text/javascript'>
                    $(document).ready(function() {
                        $("#changeapp").fadeIn(1900);
                    });
                </script>
            <?php
            }
        } else
        // if user doesnt have any apps created, take them to the screen to create an app

        {
            ?>
            <script type='text/javascript'>
                $(document).ready(function() {
                    $("#createapp").fadeIn(1900);
                });
            </script>
        <?php
        }
    } else
    // app already selected, load page like normal
    {
        ?>
        <script type='text/javascript'>
            $(document).ready(function() {
                $("#content").fadeIn(1900);
                $("#sticky-footer bg-white").fadeIn(1900);
            });
        </script>
    <?php
    }
    ?>
</head>

<body data-theme="<?php echo (($darkmode ? 1 : 0) ? 'light' : 'dark'); ?>">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin1" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin1">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin5">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand">
                        <!-- Logo icon -->
                        <b class="logo-icon">
                            <img src="https://i.imgur.com/Nfy4OoG.png" width="48px" height="48px" class="mr-2 hidden md:inline pointer-events-none noselect">
                        </b>
                    </a>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin1">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav">
                        <!-- ============================================================== -->
                        <!-- create new -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="../../../discord/" target="discord"> <i class="mdi mdi-discord font-24"></i>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="../../../telegram/" target="telegram"> <i class="mdi mdi-telegram font-24"></i>
                            </a>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="https://i.imgur.com/w65Dpnw.png" alt="user" class="rounded-circle" width="31"></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                <span class="with-arrow"><span class="bg-primary"></span></span>
                                <div class="d-flex no-block align-items-center p-15 bg-primary text-white mb-2">
                                    <div class=""><img src="https://i.imgur.com/w65Dpnw.png" alt="user" class="img-circle" width="60"></div>
                                    <div class="ml-2">
                                        <h4 class="mb-0"><?php echo $_SESSION['username']; ?></h4>
                                        <p class=" mb-0"><?php echo $_SESSION['email']; ?></p>
                                    </div>
                                </div>
                                <a class="dropdown-item" href="../../account/settings/"><i class="ti-settings mr-1 ml-1"></i> Account Settings</a>
                                <a class="dropdown-item" href="../../account/logout/"><i class="fa fa-power-off mr-1 ml-1"></i> Logout</a>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin5">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <?php sidebar($isadmin); ?>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-5 align-self-center">
                        <h4 class="page-title">Settings</h4>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->

            <div class="main-panel" id="createapp" style="padding-left:30px;display:none;">
                <!-- Page Heading -->
                <br>
                <h1 class="h3 mb-2 text-gray-800">Create A Server</h1>
                <br>
                <br>
                <form method="POST" action="">
                    <input type="text" id="appname" name="appname" class="form-control" placeholder="Server Name..."></input>
                    <br>
                    <br>
                    <button type="submit" name="ccreateapp" class="btn btn-primary" style="color:white;">Submit</button>
                </form>
            </div>


            <div class="main-panel" id="changeapp" style="padding-left:30px;display:none;">
                <!-- Page Heading -->
                <br>
                <h1 class="h3 mb-2 text-gray-800">Choose A Server</h1>
                <br>
                <br>
                <form class="text-left" method="POST" action="">
                    <select class="form-control" name="taskOption">
                        <?php
                        $result = mysqli_query($link, "SELECT * FROM `servers` WHERE `owner` = '$username'");

                        $rows = array();
                        while ($r = mysqli_fetch_assoc($result)) {
                            $rows[] = $r;
                        }

                        foreach ($rows as $row) {

                            $appname = $row['name'];
                        ?>
                            <option><?php echo $appname; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <br>
                    <br>
                    <button type="submit" name="change" class="btn btn-primary" style="color:white;">Submit</button><a style="padding-left:5px;color:#4e73df;" id="createe">Create Server</a>
                </form>
                <script type="text/javascript">
                    var myLink = document.getElementById('createe');

                    myLink.onclick = function() {


                        $(document).ready(function() {
                            $("#changeapp").fadeOut(100);
                            $("#createapp").fadeIn(1900);
                        });

                    }
                </script>
                <?php
                if (isset($_POST['change'])) {
                    $selectOption = sanitize($_POST['taskOption']);
                    ($result = mysqli_query($link, "SELECT * FROM `servers` WHERE `name` = '$selectOption' AND `owner` = '$username'")) or die(mysqli_error($link));
                    if (mysqli_num_rows($result) === 0) {
                        mysqli_close($link);
                        error("You don\'t own server!");
                        echo "<meta http-equiv='Refresh' Content='2'>";
                        return;
                    }
                    $row = mysqli_fetch_array($result);
                    $banned = $row["banned"];
                    if (!is_null($banned)) {
                        error("This server has been banned for: " . sanitize($banned));
                        echo "<meta http-equiv='Refresh' Content='2;'>";
                        return;
                    }

                    $_SESSION['server_to_manage'] = $selectOption;
                    $_SESSION['serverid'] = $row["guildid"];

                    success("You have changed Server!");
                    echo "<meta http-equiv='Refresh' Content='2;'>";
                }
                ?>
            </div>

            <!-- ============================================================== -->
            <div class="container-fluid" id="content" style="display:none;">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- File export -->
                <div class="row">
                    <div class="col-12">
                        <?php heador($role, $link); ?>
                        <br>
                        <a href="JavaScript:newPopup('https://discord.com/oauth2/authorize?client_id=791106018175614988&permissions=268435457&scope=applications.commands%20bot');" class="btn btn-info"> <i class="fab fa-discord"></i> Add Bot</a>
                        <br><br>

                        <script type="text/javascript">
                            var myLink = document.getElementById('mylink');

                            myLink.onclick = function() {


                                $(document).ready(function() {
                                    $("#content").fadeOut(100);
                                    $("#changeapp").fadeIn(1900);
                                });

                            }
                        </script>
                        <?php
                        if ($_SESSION['server_to_manage']) {
                            $servname = sanitize($_SESSION['server_to_manage']);
                            ($result = mysqli_query($link, "SELECT * FROM `servers` WHERE `name` = '$servname' AND `owner` = '$username'")) or die(mysqli_error($link));
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_array($result)) {
                                    $serv = $row['guildid'];
                                    $rol = $row['roleid'];
                                    $ico = $row['pic'];
                                    $redirect = $row['redirecturl'];
                                    $vpncheck = $row['vpncheck'];
                                    $wh = $row['webhook'];
                                }
                            }
                        }

                        ?>

                        <div class="card">
                            <div class="card-body">
                                <form class="form" method="post">
                                    <div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Server ID</label>
                                        <div class="col-10">
                                            <input class="form-control" maxlength="18" name="serv" type="number" value="<?php echo $serv; ?>" placeholder="Guild/Server ID" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Role ID</label>
                                        <div class="col-10">
                                            <input class="form-control" maxlength="18" name="rol" value="<?php echo $rol; ?>" type="number" placeholder="Role of verified role" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Icon</label>
                                        <div class="col-10">
                                            <input class="form-control" name="ico" value="<?php echo $ico; ?>" type="text" placeholder="URL to image for icon">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Redirect Link</label>
                                        <div class="col-10">
                                            <input class="form-control" name="redirect" value="<?php echo $redirect; ?>" type="url" placeholder="Link to redirect to after your members verify">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Webhook Link</label>
                                        <div class="col-10">
                                            <?php
                                            if ($role != "premium") {
                                            ?>
                                                <input class="form-control" placeholder="Premium only feature" disabled>
                                                <input type="hidden" name="wh">
                                            <?php
                                            } else {
                                            ?>
                                                <input class="form-control" name="wh" value="<?php echo $wh; ?>" type="url" placeholder="Discord webhook link for verification logs">
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">VPN Check</label>
                                        <div class="col-10">
                                            <?php
                                            if ($role != "premium") {
                                            ?>
                                                <input class="form-control" placeholder="Premium only feature" disabled>
                                                <input type="hidden" value="0" name="vpncheck">
                                            <?php
                                            } else {
                                            ?>
                                                <select name="vpncheck" class="form-control">
                                                    <option value="1" <?= $vpncheck == 1 ? ' selected="selected"' : ''; ?>>true</option>
                                                    <option value="0" <?= $vpncheck == 0 ? ' selected="selected"' : ''; ?>>false</option>
                                                </select>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <button name="updatesettings" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Show / hide columns dynamically -->

                <!-- Column rendering -->

                <!-- Row grouping -->

                <!-- Multiple table control element -->

                <!-- DOM / jQuery events -->

                <!-- Complex headers with column visibility -->

                <!-- language file -->

                <!-- Setting defaults -->

                <!-- Footer callback -->

                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                Copyright &copy; <script>
                    document.write(new Date().getFullYear())
                </script> RestoreCord
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <?php

    if (isset($_POST['updatesettings'])) {

        $guildid = sanitize($_POST['serv']);
        $servname = sanitize($_SESSION['server_to_manage']);

        // this is for checking if server banned for fake nitro scams/selling members/etc. No reason you would need it, so I commented it out.
        // $result = mysqli_query($link, "SELECT * FROM `banned` WHERE `server` = '$guildid'");
        // if(mysqli_num_rows($result) > 0)
        // {
        // 	error("That Server ID is banned!");
        // 	echo "<meta http-equiv='Refresh' Content='2;'>";
        // 	return;
        // }

        $roleid = sanitize($_POST['rol']);
        $serverico = sanitize($_POST['ico']);

        $redirect = sanitize($_POST['redirect']);
        $wh = sanitize($_POST['wh']);
        $vpncheck = sanitize($_POST['vpncheck']);

        $result = mysqli_query($link, "SELECT * FROM `servers` WHERE `guildid` = '$guildid' AND `name` != '$servname'"); // select all apps where owner is current user
        if (mysqli_num_rows($result) > 0) // if the user already owns an app, proceed to change app or load only app
        {
            error("Another Server Already Has This Server ID!");
            echo "<meta http-equiv='Refresh' Content='2;'>";
            return;
        }

        mysqli_query($link, "UPDATE `servers` SET `guildid` = '$guildid', `roleid` = '$roleid',`pic` = '$serverico',`redirecturl` = NULLIF('$redirect', ''),`webhook` = NULLIF('$wh', ''),`vpncheck` = NULLIF('$vpncheck', '0') WHERE `name` = '$servname' AND `owner` = '" . $_SESSION['username'] . "'");
        mysqli_query($link, "UPDATE `members` SET `server` = '$guildid' WHERE `server` = '" . $_SESSION['serverid'] . "'");
        mysqli_query($link, "UPDATE `blacklist` SET `server` = '$guildid' WHERE `server` = '" . $_SESSION['serverid'] . "'");

        $_SESSION['serverid'] = $guildid;

        // webhook start
        $timestamp = date("c", strtotime("now"));

        $json_data = json_encode([
            // Message
            "content" => "" . $_SESSION['username'] . " has changed Server ID to `{$guildid}`",

            // Username
            "username" => "RestoreCord Logs",

        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $ch = curl_init("discordWebhookHere");
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

        success("Updated Settings!");

        echo "<meta http-equiv='Refresh' Content='2;'>";
    }
    ?>

    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->

    <!-- Bootstrap tether Core JavaScript -->
    <script src="https://cdn.keyauth.uk/dashboard/assets/libs/popper-js/dist/umd/popper.min.js"></script>
    <script src="https://cdn.keyauth.uk/dashboard/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <script src="https://cdn.keyauth.uk/dashboard/dist/js/app.min.js"></script>
    <script src="https://cdn.keyauth.uk/dashboard/dist/js/app.init.dark.js"></script>
    <script src="https://cdn.keyauth.uk/dashboard/dist/js/app-style-switcher.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="https://cdn.keyauth.uk/dashboard/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="https://cdn.keyauth.uk/dashboard/assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="https://cdn.keyauth.uk/dashboard/dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="https://cdn.keyauth.uk/dashboard/dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="https://cdn.keyauth.uk/dashboard/dist/js/feather.min.js"></script>
    <script src="https://cdn.keyauth.uk/dashboard/dist/js/custom.min.js"></script>
    <!--This page JavaScript -->
    <!--chartis chart-->
    <script src="https://cdn.keyauth.uk/dashboard/assets/libs/chartist/dist/chartist.min.js"></script>
    <script src="https://cdn.keyauth.uk/dashboard/assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <!--c3 charts -->
    <script src="https://cdn.keyauth.uk/dashboard/assets/extra-libs/c3/d3.min.js"></script>
    <script src="https://cdn.keyauth.uk/dashboard/assets/extra-libs/c3/c3.min.js"></script>
    <!--chartjs -->
    <script src="https://cdn.keyauth.uk/dashboard/assets/libs/chart-js/dist/chart.min.js"></script>
    <script src="https://cdn.keyauth.uk/dashboard/dist/js/pages/dashboards/dashboard1.js"></script>
    <script src="https://cdn.keyauth.uk/dashboard/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>

    <script src="https://cdn.keyauth.uk/dashboard/dist/js/pages/datatable/datatable-advanced.init.js"></script>

    <script type="text/javascript">
        // Popup window code
        function newPopup(url) {
            popupWindow = window.open(
                url, 'popUpWindow', 'menubar=no,width=500,height=777,location=no,resizable=no,scrollbars=yes,status=no')
        }
    </script>
</body>

</html>
