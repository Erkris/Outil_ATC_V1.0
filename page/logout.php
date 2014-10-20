<?php
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_SESSION['pwd']) && !empty($_SESSION['pwd'])) {
	session_destroy();
	header("location: index.php?page=login");
}