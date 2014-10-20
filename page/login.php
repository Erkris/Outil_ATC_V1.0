<!-- NavBar: Veuillez vous connecter -->

<?php
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_SESSION['pwd']) && !empty($_SESSION['pwd'])) {
	if($_SESSION['user'] == $userTheso && $_SESSION['pwd'] == $pwdTheso) {
		header("location: index.php?page=search");
	}
}

$mess = "";

if (isset($_POST['user']) && isset($_POST['pwd'])){
	$user = htmlentities($_POST['user']);
	$pwd = htmlentities($_POST['pwd']);
	if ($user == $userTheso && $pwd == $pwdTheso){
	    $_SESSION['user'] = $user;
	    $_SESSION['pwd'] = $pwd;

	    header('location: index.php?page=search');
	} else { 
		$mess = "Erreur de Login ou de mot de passe";
	}
} else {
	$mess = "Veuillez vous connecter";
}
?>

<div class="content container-fluid">
	<div class="alert alert-info">
		<?php echo "$mess"; ?>
	</div>
</div>