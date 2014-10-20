<!DOCTYPE html>
<html lang="fr">
	<head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
      <meta name="description" content="Script ATC Theso">
      <meta name="keywords" content="Script, ATC, Theso">
      <meta name="author" content="Pierre">

      <title>Outil ATC Thesorimed</title>
 
      <link rel="icon" type="image/png" href="img/favicon.png">
      <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
	
	   
      <link href="css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" media="screen" href="css/style.css">

      <script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
      <!--[if lte IE 7]><script src="js/lte-ie7.js"></script><![endif]-->
	</head>
	<body>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
   <div class="container-fluid">
      <div class="navbar-header">
         <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
         </button>
         <a class="navbar-brand" href="/index.php">Thesorimed</a>
      </div>

      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
         <ul class="nav navbar-nav">
            <li class="active"><a href="index.php?page=search">Outil ATC</a></li>
            <li><a href="http://theso.prod-deux.thesorimed.org/" target="_blank">Thesorimed.org</a></li>
         </ul>
         <ul class="nav navbar-nav navbar-right">
            <?php if(isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_SESSION['pwd']) && !empty($_SESSION['pwd'])) {
                        if($_SESSION['user'] == $userTheso && $_SESSION['pwd'] == $pwdTheso) {?>
            <li>
                <p><?php echo 'Bonjour '.$_SESSION['user']; ?> <a href="index.php?page=logout" class="btn btn-danger">Se déconnecter</a></p>
            </li>
            <?php }} else { ?>
            <li>
                              <form class="navbar-form navbar-left" role="login" action="index.php?page=login" method="post">
                              <div class="form-group">
                                <input type="text" class="form-control" placeholder="Identifiant" name="user">
                                <input type="password" class="form-control" placeholder="Mot de passe" name="pwd">
                              </div>
                              <button type="submit" class="btn btn-primary">Connexion</button>
                        </form>
            </li>
            <?php } ?>
         </ul>
      </div><!-- /.navbar-collapse -->
   </div><!-- /.container-fluid -->
</nav>