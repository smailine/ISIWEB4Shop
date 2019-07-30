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
		$idCommande = null;
		if(isset($_SESSION['commande'])){
			$idCommande = $_SESSION['commande'];
		}
		$tabCategorieRecup = $undlg->getCategories($cnx);
		$modePaiement = null;
		if(isset($_SESSION['paiement'])){
			$modePaiement = $_SESSION['paiement'];
		}else{
			$modePaiement = $_POST['paiement'];
		}
		$undlg -> updateStatut($cnx,$idCommande,2);
		$cmd = filter_input(INPUT_GET, 'cmd');
			if (is_null($cmd)){
				$cmd = filter_input(INPUT_POST, 'cmd');
			} 
 			
			if ($cmd != '') { 
				include "paiementEffectue_controller.php"; 
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
			<?php
				if($modePaiement=='1'){
					echo '<p>Voici ci joint votre facture. Pour déposer votre chèque, il suffit que vous le déposiez dans un de nos magasin qui se trouve près de chez vous. Après avoir reçu votre chèque, nous vous enverrons un mail pour vous avertir. Votre commande sera traitée dans les plus brefs délais.</p>';
					echo '<p>Nous vous remercions pour votre confiance </p>';
					echo '<a class="btn btn-secondary" href="facture.php">Facture</a>';
				}else{
					echo '<p>Vous avez choisi de payer par Paypal. Cliquez sur le bouton pour accéder au site paypal afin de payer votre commande </p>';
					echo '<a class="btn btn-secondary" href="https://www.paypal.com/fr/home">Payer sur Paypal</a>';
				}
				$listeProduit = null;
				if(isset($_SESSION['idCustomer'])){
					$listeProduit = $undlg->getPanier($cnx,$_SESSION['idCustomer']);
				}else{
					$tabInfoClient = $undlg->getCustomerViaLogin($cnx,$login);
					foreach ($tabInfoClient as $info) {
						$idC = $info['id'];
					}
					$listeProduit = $undlg->getPanier($cnx,$idC);
				}
				
			

			?>
			
		</div>	
	</body>
</html>