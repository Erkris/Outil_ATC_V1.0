<?php
$debut = microtime(true); 

ob_start();

session_start();

@require_once('config/config.php');

@include('include/top.php');

$page = (!empty($_GET['page'])) ? htmlentities($_GET['page']) : 'login';
$page = ($page=='index') ? 'login' : $page;
if(preg_match('`\.`', $page)){$page = 'erreur';}

if(is_file('./page/'.$page.'.php'))  @include('./page/'.$page.'.php');
else{@include("page/error.php");}

@include('include/bottom.php');

ob_end_flush();
?>