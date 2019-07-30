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
		$tabProduitRecup = $undlg->getListeProduit($cnx,$strCategorie);
		$nbProduit = $undlg->getNbProduit($cnx,$strCategorie);
		
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
		<br>
		<div class="jumbotron">
						<?php 
							foreach ($tabProduitRecup as $produit) {
								echo '<ul>';
								echo '<div class="li_produit">';
								echo '<div class="image_produit">';
								echo '<li>';
								echo '<img class="imageProduit" src="images/'.$produit['image'].'">';
								echo '</li>';
								echo '</div>';
							
								echo '<div class="info_produit">';
								echo '<li>';
								echo '<p><strong>Produit : '.$produit['name'].'</strong></p>';
								echo '</li>';
								echo '<li>';
								echo '<p>'.$produit['description'].'</strong></p>';
								echo '</li>';
								echo '<li>';
								echo '<p><strong>Notre prix : '.$produit['price'].'</strong></p>';
								echo '</li>';
								
								echo '<a class="nav-link" href="produitQuantite.php?cmd=ajouter&categ='.$strCategorie.'&produit='.$produit['id'].'">[Acheter]</a>';
								echo '</div>';
								echo '</ul>';
								echo '<br />';
							}
							
						?>
		</div>	
	</body>
</html>