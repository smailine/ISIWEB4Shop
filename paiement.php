<?php
include "setup_inc.php"; 
require_once "DialogueBD.php";
session_start();
	$login = null;
	if(isset($_SESSION['login'])){
		$login = $_SESSION['login'];
	}
try{
		$undlg 			= new DialogueBD();
		$strCategorie 	= "";
		$strProduit 	= "";
		
		if(isset($_GET['categ'])){
			$strCategorie 	= $_GET['categ'];
		}
		
		$tabCategorieRecup = $undlg->getCategories($cnx);
		$cmd = filter_input(INPUT_GET, 'cmd');
			if (is_null($cmd)){
				$cmd = filter_input(INPUT_POST, 'cmd');
			} 
 			
			if ($cmd != '') { 
				include "paiement_controller.php"; 
			}
$deconnecter = filter_input(INPUT_GET, 'deconnecter');
			
 			
			if ($deconnecter != '') { 
				include "connexion_controller.php"; 
			}
		}catch(Exception $e){
			$erreur = $e->getMessage();
		}
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<title>ISIWEB4Shop : découvrez nos produits en vente en ligne</title>
		<link href="Bootstrap3/css/bootstrap.css" rel="stylesheet">
		<link rel="stylesheet" href="designShop.css">
	</head>
	<body>
		<nav class="navbar navbar-expand-lg navbar-dark bg-primary">			
			<a class="navbar-brand" href="#">ISIWEB4Shop</a>	
			<div class="collapse navbar-collapse" id="navbarColor01">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<?php 
								
							foreach ($tabCategorieRecup as $categorie) {
								echo '<li class="nav-item">';
								echo '<a class="nav-link" href="listeProduit.php?categ='.$categorie['id'].'">'.$categorie['name'].'<span class="sr-only">(current)</span></a>';
								echo '</li>';
								
							} 

							echo '</li>';
							if(isset($login)){
								echo '<a class="navbar-brand" href="#">Bonjour '.$login.'</a>';
								//echo '<div class="left_li">';
									echo '<a class="nav-link" href="Accueil.php?deconnecter=true">Deconnection<span class="sr-only">(current)</span></a>';
							}else{
									echo '<a class="nav-link" href="panier.php">Mon panier<span class="sr-only">(current)</span></a>';
									echo '<a class="nav-link" href="connexion.php">Connexion<span class="sr-only">(current)</span></a>';
									
							}
						
					?>
					</li>
				</ul>
	 		</div>
		</nav>
		
		<div class="jumbotron">
			<h2>Paiement</h2>
			<form method="POST" action="paiementEffectue.php">
				<label>Mode de paiement :</label>
				<input type="radio" id="cheque" name="paiement" value="1">
				<label for="cheque">Chèque</label>
				<input type="radio" id="paypal" name="paiement" value="2">
				<label for="paypal">Paypal</label>
				<br />
				<input type="submit" name="Enregistrer" value="Enregistrer">
			</form>
			
		</div>	
	</body>
</html>