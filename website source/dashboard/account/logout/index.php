<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
session_destroy();
echo "<meta http-equiv='Refresh' Content='0; url=../../../login/'>"; 
die();
?>