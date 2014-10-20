<?php

define('DB_SERVER', 'un.vifi.info');
define('DB_USER', 'thesorimed');
define('DB_PASSWORD', 'THESORIMED');
define('DB_NAME', 'theso_prod');

try {
    $bdd = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
    exit;
}

$userTheso = "giesips";
$pwdTheso = "thesorimed";