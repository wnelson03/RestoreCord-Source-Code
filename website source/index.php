<?php
include 'includes/connection.php';

$result = mysqli_query($link, "SELECT max(id) FROM servers");
$row = mysqli_fetch_array($result);


$servers = number_format($row[0]);

$result = mysqli_query($link, "SELECT max(id) FROM users");
$row = mysqli_fetch_array($result);

$users = number_format($row[0]);

$result = mysqli_query($link, "SELECT max(id) FROM members");
$row = mysqli_fetch_array($result);

$members = number_format($row[0]);

mysqli_close($link);
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" sizes="300x250" href="https://i.imgur.com/Nfy4OoG.png">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@900&display=swap" rel="stylesheet">
  <title>RestoreCord</title>
  <meta name="theme-color" content="#52ef52" />
  <meta name="description" content="Backup Discord members and add them to new server in the event of a server raid or deletion." />
  <meta name="og:image" content="https://i.imgur.com/zhLwuR4.png" />

  <link rel="stylesheet" href="styles/theTrendingStyle.css">
  <link rel="stylesheet" href="styles/index.css">
  <link rel="stylesheet" href="styles/css/all.css" />
</head>

<body class="bg-shinyGray overflow-x-hidden">
  <nav id="navigationBar" class="flex flex-row items-center justify-between p-6 bg-sweetBlack">
    <div class="left flex flex-row items-center ml-10 md:ml-20 text-white">
      <img src="https://i.imgur.com/Nfy4OoG.png" width="48px" height="48px" class="mr-2 hidden md:inline pointer-events-none noselect" />
      <a href="https://www.youtube.com/watch?v=tCCP2oUxxEY" target="_blank" class="mx-4 text-xl hover:text-blurple hidden md:inline">Tutorial</a>
      <a href="https://docs.restorecord.com" target="_blank" class="mx-4 text-xl hover:text-blurple hidden md:inline">Documentation</a>
      <a href="https://discord.com/invite/s6gk5Y5fTC" target="_blank" class="mx-4 text-xl hover:text-blurple hidden md:inline">Support Server</a>
      <a href="./terms" target="_blank" class="mx-4 text-xl hover:text-blurple hidden md:inline">Terms of Service & Privacy</a>
    </div>
    <div class="right mr-10 md:mr-20">
      <a href="./login/" class="px-8 py-3 whitespace-no-wrap bg-blurple text-white rounded-lg text-xl font-semibold hover:bg-beautyPurple">Login</a>
    </div>
  </nav>


  <div id="container" class="flex flex-col items-center justify-center">
    <div class="flex flex-col items-center justify-center pt-40 text-center">
      <span class="text-2xl md:text-5xl font-semibold text-white"> Backup Discord Server Members</span>
      <span class="text-gray-400 text-lg md:text-xl max-w-xl font-light">Add your server members to new server or back to the existing one in the event of a server raid or deletion.</span>
      <div class="flex flex-col md:flex-row mt-8">
        <a href="https://discord.com/api/oauth2/authorize?client_id=791106018175614988&permissions=268435457&scope=applications.commands%20bot" target="_blank" class="text-2xl hvr-grow bg-blurple p-4 md:px-8 mx-4 my-4 rounded-lg">Add to Discord</e>
          <a href="https://discord.com/invite/s6gk5Y5fTC" target="_blank" class="text-2xl hvr-grow text-white bg-sweetBlack p-4 md:px-8 mx-4 my-4 rounded-lg border-blurple border-2">Join the Support Server</a>
      </div>
    </div>
    </head>

    <body>
      <pre>





 <div id="container" class="flex flex-col items-center justify-center">
    <div class="flex flex-col items-center justify-center pt-40 text-center">
      <span class="text-2xl md:text-5xl font-semibold text-white"></span>
		      <div class="flex flex-col md:flex-row mt-8">
        <p class="text-2xl hvr-grow bg-blurple p-4 md:px-8 mx-4 my-4 rounded-lg"><?php echo $servers; ?> Servers</p>
        <p class="text-2xl hvr-grow bg-blurple p-4 md:px-8 mx-4 my-4 rounded-lg"><?php echo $users; ?> Users</p>
		<p class="text-2xl hvr-grow bg-blurple p-4 md:px-8 mx-4 my-4 rounded-lg"><?php echo $members; ?> Members</p>
      </div>
		   </head>
		<body>
     <pre>






    <div class="flex flex-row items-center justify-center mb-10">
      <span class="text-lg text-gray-400 font-semibold">Copyright &copy; <script>document.write(new Date().getFullYear())</script> RestoreCord</span>
    </div>
  </div>
</body>
</html>