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
		if(isset($_GET['produit'])){
			$strProduit 		= $_GET['produit'];
		}

		
		$tabCategorieRecup = $undlg->getCategories($cnx);
		$tabListeProduitRecup = $undlg->getListeProduit($cnx,$strCategorie);
		
		$tabProduit = $undlg->getProduit($cnx,$strProduit);
		
		$cmd = filter_input(INPUT_GET, 'cmd',FILTER_SANITIZE_STRING); 
		$produit = filter_input(INPUT_GET, 'produit',FILTER_SANITIZE_NUMBER_INT);
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
					<br />
				<form method="POST" action="panier.php">
				<input type="hidden" name="cmd" value="<?php echo $cmd ?>">
				<input type="hidden" name="produit" value="<?php echo $produit ?>"> 
				<ul>

						<?php

							foreach ($tabProduit as $produit) {
								
								
								echo '<div class="li_produit">';
								echo '<div class="image_produit">';
								echo '<li>';
								echo '<img class="imageProduit" src="images/'.$produit['image'].'">';
								echo '</li>';
								echo '</div>';
								
								echo '<div class="info_produit">';
								echo '<li>';
								echo '<p><strong>Prix : '.$produit['name'].'</strong></p>';
								echo '</li>';
								echo '<li>';
								echo '<p>'.$produit['description'].'</strong></p>';
								echo '</li>';
								echo '<li>';
								echo '<p><strong>Notre prix : '.$produit['price'].'</strong></p>';
								echo '</li>';
								echo '<label>Quantité : </label>';
								echo '<select name="quantite">';
								
									echo '<option value="1" selected>1</option>';
										for($i = 2 ; $i<21; $i++){
											echo '<option value="'.$i.'">'.$i.'</option>';

										}
								echo '</select>';
									echo '<br/>';
								
									echo '</div>';
							}

						
						?>	
				</ul>
				<input type="submit" name="enregistrer" value="Sauvegarder"><br>
			</form>
		</div>	
	</body>
</html>