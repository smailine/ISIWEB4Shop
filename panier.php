<?php
	include "setup_inc.php"; 
	require_once "DialogueBD.php";
	
	session_start();

	try{
		$undlg 			= new DialogueBD();
		$strCategorie 	= "";
		$strProduit 	= "";
		//$strCategorieLibelle 	= "";
		//$strPlat 		= "";

		if(isset($_GET['categ'])){
			$strCategorie 	= $_GET['categ'];
		}
		$customerCommande = null;

		$cmd = filter_input(INPUT_GET, 'cmd');
		if (is_null($cmd)){
			$cmd = filter_input(INPUT_POST, 'cmd');
		} 
			
		if ($cmd != '') { 
			include "panier_controller.php"; 
		}
		$deconnecter = filter_input(INPUT_GET, 'deconnecter');
		
			
		if ($deconnecter != '') { 
			include "connexion_controller.php"; 
		}
		$commandeTotal = 0;



		if(isset($_SESSION['commande'])){
			$customerCommande = $_SESSION['commande'];
		}
		
		
		$tabCategorieRecup = $undlg->getCategories($cnx);

		
		
		$tabPanierRecup = $undlg->getPanier($cnx,$customerCommande);
		
		
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
				<h2>Votre panier</h2>
					<br />
				<?php
				if(empty($tabPanierRecup)){
					echo '<h4>Votre panier est vide</h4>';
				}else{
				?>
				
				<table name="panier" >
					<tr class="table-info">
						<th scope="row">Image</th>
					
						<th scope="row">Nom du produit</th>

						<th scope="row">Prix unitaire</th>
					
						<th scope="row">Quantité commandée</th>
					
						<th scope="row">Total</th>

						<th scope="row">Action</th>
					</tr>
						<?php 
							
							foreach ($tabPanierRecup as $produitPanier) {
								$tabProduit = $undlg->getProduit($cnx,$produitPanier['product_id']);
							
							foreach ($tabProduit as $produit) {
								echo '<div class="li_produit">';
								echo '<div class="image_produit">';
								echo '<tr>';
								echo '<td>';
								echo '<img class="imageProduit" src="images/'.$produit['image'].'">';
								echo '</td>';

								echo '</div>';
								echo '<div class="info_produit">';
								echo '<td>';
								echo $produit['name'];
								echo '</td>';
								echo '<td>';
								echo $produit['price'];
								echo '</td>';
								echo '<td>';
								echo $produitPanier['quantity'];
								echo '</td>';
								echo '<td>';
								$produitMontantTotal = $produitPanier['quantity']*$produit['price'];
								$commandeTotal = $commandeTotal + $produitMontantTotal;
								echo $produitMontantTotal;
								echo '</td>';
								echo '<td>';
								echo '<div class="all_action_buttons">';
								echo '
										<a class="btn btn-secondary" href="panier.php?cmd=supprimer&produitPanier='.$produitPanier['id'].'">Supprimer</a>';
									
								
								echo '<div>';
								echo '</td>';
								echo '</tr>';
							}
							}
						}
						$_SESSION['prixTotal'] = $commandeTotal;
						if(!empty($tabPanierRecup)){
							echo '<a class="btn btn-secondary" href="renseignement.php?cmd=caisse">Aller à la caisse</a>';
						}
						

						?>

				</table>
		</div>	
	</body>
</html>