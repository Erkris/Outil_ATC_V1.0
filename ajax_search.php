<?php

@require_once("config/config.php");

if(isset($_GET["req"]) && !empty($_GET["req"])){
	$req = htmlentities($_GET["req"]);
	switch($req){
		case 1 : 
			if (isset($_GET['search']) && !empty($_GET['search'])){
				$search = htmlentities($_GET['search']);
			    $results = array();
			     
			    $stmt = $bdd->prepare('SELECT CATC_CODE_PK, CATC_NOMF FROM CATC_CLASSEATC WHERE CATC_CODE_PK LIKE UPPER(:search) OR CATC_NOMF LIKE UPPER(:search) AND CATC_CODE_PK NOT IN ("X","Z")');
			    $stmt->execute(array('search' => $search."%"));
			    
			    while($row = $stmt->fetch()) {
			        echo "<li>".$row['CATC_CODE_PK']." - ".$row['CATC_NOMF']."</li>";
			    }
			}
		break;
		// Requete pour descendre dans la hierarchie (ex: A01 --> A01A)
		case 2 :
			if(isset($_GET["code"]) && !empty($_GET["code"])){
			    $code = htmlentities($_GET["code"]);

			    $stmt = $bdd->prepare('SELECT CATC_CODE_PK, CATC_NOMF FROM CATC_CLASSEATC WHERE CATC_CODE_PK LIKE UPPER(:code)');
				
			    $size = strlen($code);
			    switch($size){
			     	case 3:
			     	case 4:
			      		$stmt->execute(array('code' => $code.'_'));
			     	break;
			     	case 1:
			     	case 5:
			      		$stmt->execute(array('code' => $code.'__'));
			     	break;
			     	default:
			      		$stmt->execute(array('code' => $code));
			     	break; 
				}
				

				// On affiche le bouton pour descendre dans les classes ATC
				if(strlen($code) >= 1){
		            echo "<br/><p class='downATC'><span class='glyphicon glyphicon-arrow-up'></span>Monter dans la hiérarchie</p>";
		        }

		        // On affiche le résultat des classes ATC
				echo "<table class='table table-striped'>
						<thead>
							<th>Code ATC</th>
							<th>Libellé</th>
							<th style='width:30%;'>Actions</th>
						</thead>
						<tbody>";
				while($row = $stmt->fetch()) {
			        echo 	"<tr>";
		        		if(strlen($code) < 5){
				            echo "<td class='link-code'>".$row['CATC_CODE_PK']."</td>";
				        }else{
				        	echo "<td>".$row['CATC_CODE_PK']."</td>";
				        }
			        	echo 	"<td>".$row['CATC_NOMF']."</td>";
			        	echo "<td>
			        			<ul>";
			        				if($size > 3){
			        					$stmt2 = $bdd->prepare('SELECT CATC.CATC_CODE_PK, CATC.CATC_NOMF, SP.SP_CODE_SQ_PK, SP.SP_NOM, CDF_FO.CDF_NOM AS CDFFO, CDF_VO.CDF_NOM AS CDFVO
										FROM CATC_CLASSEATC CATC
										JOIN SP_SPECIALITE SP ON (SP.SP_CATC_CODE_FK = CATC.CATC_CODE_PK
											AND SP_CDF_SLAB_CODE_FK != 7)
										JOIN SPFO_SPECIALITE_FORME SPFO ON (SPFO.SPFO_SP_CODE_FK_PK = SP.SP_CODE_SQ_PK)
										JOIN CDF_CODIF CDF_FO ON (CDF_FO.CDF_CODE_PK = SPFO.SPFO_CDF_FO_CODE_FK_PK
										  AND CDF_FO.CDF_NUMERO_PK = "06")
										JOIN SPVO_SPECIALITE_VOIE SPVO ON (SPVO.SPVO_SP_CODE_FK_PK = SP.SP_CODE_SQ_PK)
										JOIN CDF_CODIF CDF_VO ON (CDF_VO.CDF_CODE_PK = SPVO.SPVO_CDF_VO_CODE_FK_PK
										  AND CDF_VO.CDF_NUMERO_PK = "18")
										WHERE CATC.CATC_CODE_PK LIKE (:code)
										ORDER BY 1');

			        					$stmt2->execute(array('code' => $row['CATC_CODE_PK'].'%'));
										$count = $stmt2->rowCount();
										if ($count != 0) {
											echo "<li><a href='' data-atc='".$row['CATC_CODE_PK']."' data-toggle='modal' data-target='#myModal' class='title_spe'>Afficher les spécialités</a> (".$count.")</li>";
										} else {
											echo "<li style='color: red;'>Afficher spécialités</li>";
										}
			        				} else {
			        					echo "<li>Afficher spécialités</li>";
			        			}
			        					echo "<li><p>Afficher autre chose</p></li>
			        			</ul>
							</td>
						</tr>";
			    }
			    echo "</tbody>
			    	</table>";
			}
		break;
		// Requete pour monter dans la hierarchie (ex: A01A --> A01)
		case 3 :
			if(isset($_GET["code"]) && !empty($_GET["code"])){
			    $code = htmlentities($_GET["code"]);

			    $stmt = $bdd->prepare('SELECT CATC_CODE_PK, CATC_NOMF FROM CATC_CLASSEATC WHERE CATC_CODE_PK LIKE UPPER(:code)');

			    $size = strlen($code);
			    switch($size){
			     	case 4:
			      		$stmt->execute(array('code' => substr($code, 0, -2)."_")); 
			     	break;
			     	case 5:
			      		$stmt->execute(array('code' => substr($code, 0, -2)."_")); 
			     	break;
			     	case 3:
			     	case 7:
			      		$stmt->execute(array('code' => substr($code, 0, -3)."_")); 
			     	break;
			     	default:
			      		$stmt->execute(array('code' => $code));
			     	break; 
				}

				// On affiche le bouton pour remonter dans les classes ATC
				if(strlen($code) > 3){
		            echo "<br/><p class='downATC'><span class='glyphicon glyphicon-arrow-up'></span>Monter dans la hiérarchie</p>";
		        }

				// On affiche le résultat des classes ATC
				echo "<table class='table table-striped'>
						<thead>
							<th>Code ATC</th>
							<th>Libellé</th>
							<th style='width:30%;'>Actions</th>
						</thead>
						<tbody>";
				while($row = $stmt->fetch()) {
			        echo "<tr>";
		        		if($size > 1){
				            echo "<td class='link-code'>".$row['CATC_CODE_PK']."</td>";
				        }else{
				        	echo "<td>".$row['CATC_CODE_PK']."</td>";
				        }
			        	echo "<td>".$row['CATC_NOMF']."</td>";
			        	echo "<td>
			        			<ul>";
			        				if($size > 5){

			        					$stmt2 = $bdd->prepare('SELECT CATC.CATC_CODE_PK, CATC.CATC_NOMF, SP.SP_CODE_SQ_PK, SP.SP_NOM, CDF_FO.CDF_NOM AS CDFFO, CDF_VO.CDF_NOM AS CDFVO
										FROM CATC_CLASSEATC CATC
										JOIN SP_SPECIALITE SP ON (SP.SP_CATC_CODE_FK = CATC.CATC_CODE_PK
											AND SP_CDF_SLAB_CODE_FK != 7)
										JOIN SPFO_SPECIALITE_FORME SPFO ON (SPFO.SPFO_SP_CODE_FK_PK = SP.SP_CODE_SQ_PK)
										JOIN CDF_CODIF CDF_FO ON (CDF_FO.CDF_CODE_PK = SPFO.SPFO_CDF_FO_CODE_FK_PK
										  AND CDF_FO.CDF_NUMERO_PK = "06")
										JOIN SPVO_SPECIALITE_VOIE SPVO ON (SPVO.SPVO_SP_CODE_FK_PK = SP.SP_CODE_SQ_PK)
										JOIN CDF_CODIF CDF_VO ON (CDF_VO.CDF_CODE_PK = SPVO.SPVO_CDF_VO_CODE_FK_PK
										  AND CDF_VO.CDF_NUMERO_PK = "18")
										WHERE CATC.CATC_CODE_PK LIKE (:code)
										ORDER BY 1');
			        					
			        					$stmt2->execute(array('code' => $row['CATC_CODE_PK'].'%'));
										$count = $stmt2->rowCount();
										if ($count != 0) {
											echo "<li><a href='' data-atc='".$row['CATC_CODE_PK']."' data-toggle='modal' data-target='#myModal' class='title_spe'>Afficher les spécialités</a> (".$count.")</li>";
										} else {
											echo "<li style='color: red;'>Afficher spécialités</li>";
										}
			        				} else {
			        					echo "<li>Afficher spécialités</li>";
			        			}
			        					echo "<li><p>Afficher autre chose</p></li>
			        			</ul>
							</td>
						</tr>";
			    }
			    echo "</tbody>
			    	</table>";
			}
		break;
		// requête pour afficher les spé dans le modal
	  	case 4 :
			if(isset($_GET["code"]) && !empty($_GET["code"])){
				$code = htmlentities($_GET["code"]);

				$stmt = $bdd->prepare('SELECT CATC.CATC_CODE_PK, CATC.CATC_NOMF, SP.SP_CODE_SQ_PK, SP.SP_NOM, SP.SP_CIPUCD, CDF_FO.CDF_NOM AS CDFFO, CDF_VO.CDF_NOM AS CDFVO
										FROM CATC_CLASSEATC CATC
										JOIN SP_SPECIALITE SP ON (SP.SP_CATC_CODE_FK = CATC.CATC_CODE_PK
											AND SP_CDF_SLAB_CODE_FK != 7)
										JOIN SPFO_SPECIALITE_FORME SPFO ON (SPFO.SPFO_SP_CODE_FK_PK = SP.SP_CODE_SQ_PK)
										JOIN CDF_CODIF CDF_FO ON (CDF_FO.CDF_CODE_PK = SPFO.SPFO_CDF_FO_CODE_FK_PK
										  AND CDF_FO.CDF_NUMERO_PK = "06")
										JOIN SPVO_SPECIALITE_VOIE SPVO ON (SPVO.SPVO_SP_CODE_FK_PK = SP.SP_CODE_SQ_PK)
										JOIN CDF_CODIF CDF_VO ON (CDF_VO.CDF_CODE_PK = SPVO.SPVO_CDF_VO_CODE_FK_PK
										  AND CDF_VO.CDF_NUMERO_PK = "18")
										WHERE CATC.CATC_CODE_PK LIKE (:code)
										ORDER BY 1');
				$stmt->execute(array('code' => $code.'%'));
				echo "<table>
					<tr>
						<td><span class='check' id='checkAllButNsfp'></span></td>
						<td> &nbsp;&nbsp;Cocher ou décocher les NSFP</td>
					</tr></table>";
				echo "<table class='table table-striped'>
						<thead>
							<th><span class='check' id='checkAll'></span></th>
							<th>Code ATC</th>
							<th>Libellé ATC</th>
							<th>Code SPE</th>
							<th>Nom SPE</th>
							<th>CIP SPE</th>
							<th>Forme SPE</th>
							<th>Voie SPE</th>
						</thead>
						<tbody>";

				while ($row = $stmt->fetch()) {
					if(strpos($row['SP_NOM'], 'NSFP') !== false){
						echo "<tr class='nsfp'>";
					}else{
						echo "<tr>";
					}
					echo "<td><span class='check' data-info='".$row['CATC_CODE_PK']."-".$row['CATC_NOMF']."-".$row['SP_CODE_SQ_PK']."-".$row['SP_NOM']."-".$row['CDFFO']."-".$row['CDFVO']."'></span></td>";
					echo "<td>".$row['CATC_CODE_PK']."</td>";
					echo "<td>".$row['CATC_NOMF']."</td>";
					echo "<td>".$row['SP_CODE_SQ_PK']."</td>";
					echo "<td>".$row['SP_NOM']."</td>";
					echo "<td>".$row['SP_CIPUCD']."</td>";
					echo "<td>".$row['CDFFO']."</td>";
					echo "<td>".$row['CDFVO']."</td>";
					echo "</tr>";

				}
				echo "</tbody>
				</table>";
			}
		break;
		// requête pour afficher les spé dans le modal
	  	case 5 :
			if(empty($_GET["code"])){

				$stmt = $bdd->prepare('SELECT CATC_CODE_PK, CATC_NOMF FROM CATC_CLASSEATC WHERE LENGTH(CATC_CODE_PK) = 1');
				$stmt->execute(array());
				$count = $stmt->rowCount();
				echo "$count";
			}
		break;
		//affiche erreur
		default: 
			echo "error";
		break;
	}
} 

?>