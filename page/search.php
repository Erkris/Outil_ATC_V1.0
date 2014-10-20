<!-- NavBar: Vous êtes connectés -->
<?php if (isset($_SESSION['user']) && isset($_SESSION['pwd'])){
  if($_SESSION['user'] == $userTheso && $_SESSION['pwd'] == $pwdTheso) { ?>


<!-- Container Page Search -->
<div class="content container">
	<!-- Affichage du résultat de la recherche faite avec l'input -->
      <div class="row">
        <div class="col-md-3">
          <h2>Classes ATC Niveau 1</h1>
        <?php
        $code = htmlentities($_GET["code"]);

        $stmt = $bdd->prepare('SELECT CATC_CODE_PK, CATC_NOMF FROM CATC_CLASSEATC WHERE LENGTH(CATC_CODE_PK) = 1 AND CATC_CODE_PK NOT IN ("X","Z")');
        $stmt->execute();
        echo "<ul id='arbo_base' class='nav nav-pills nav-stacked'>";
            while($row = $stmt->fetch()) {
                  echo "<li class='link-code'>".$row['CATC_CODE_PK']." - ".$row['CATC_NOMF']."</li>";
              }
        echo "</ul>";
        ?>
      </div>

    <!--  -->
    <div class="col-md-9">
      <form role="form" id="search_form">
        <div class="form-group">
          <label for="exampleInputEmail1">Recherche</label>
          <input type="text" size="30" class="form-control" id="search" placeholder="Code ATC ou Nom" autocomplete="off" >
        </div>
      </form>
      <!-- Affichage de la recherche faite avec l'input -->
      <ul id="search_results"></ul>
    </div>
    <div id="code_results" CLASS="col-md-9">
      
    </div>
  </div>
</div>
<!--Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">En cours de création</h4>
      </div>
      <div class="modal-body">
        On affichera ici ce que vous voudrez en relation avec les classes ATC <br/>
        ex: N02BE01 Paracétamol, Dolipranne 1G Comprimé Code CIP
      </div>
      <div class="modal-footer">
        <a href="" style="display: none;" id="linkExport"></a>
        <button id="btnExport" type="button" class="btn btn-primary" data-dismiss="alert">Export</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="js/atc.js"></script>
<script type="text/javascript" src="js/spe.js"></script>
<?php 
}} else {
  $mess = "Vous venez de vous déconnecter, veuillez vous reconnecter.";
  header('location: index.php?page=login');
}
?>
