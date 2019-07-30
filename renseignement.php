<?php
include "setup_inc.php"; 
require_once "DialogueBD.php";
session_start();
try{

	$cmd = filter_input(INPUT_GET, 'cmd');
			if (is_null($cmd)){
				$cmd = filter_input(INPUT_POST, 'cmd');
			} 
 			
			if ($cmd != '') { 
				include "renseignement_controller.php"; 
			}
$deconnecter = filter_input(INPUT_GET, 'deconnecter');
			
 			
			if ($deconnecter != '') { 
				include "connexion_controller.php"; 
			}
	$login = null;
	if(isset($_SESSION['login'])){
		$login = $_SESSION['login'];
	}
	$customerNom = null;
	if(isset($_SESSION['nom'])){
		$customerNom = $_SESSION['nom'];
		if($customerNom=='null'){
			$customerNom = "";
		}
	}
	$customerPrenom = null;
	if (isset($_SESSION['prenom'])) {
		$customerPrenom = $_SESSION['prenom'];
		if($customerPrenom=='null'){
			$customerPrenom = "";
		}
	}
	$customerAdresse = null;
	if (isset($_SESSION['adresse1'])) {
		$customerAdresse = $_SESSION['adresse1'];
		if($customerAdresse =='null'){
			$customerAdresse = "";
		}
	}
	$customerCodeP = null;
	if (isset($_SESSION['codeP'])) {
		$customerCodeP = $_SESSION['codeP'];
		if($customerCodeP == 'null'){
			$customerCodeP = "";
		}
	}
	$customerVille = null;
	if (isset($_SESSION['city'])) {
		$customerVille = $_SESSION['city'];
		if($customerVille =='null'){
			$customerVille = "";
		}
	}
	$customerTel = null;
	if (isset($_SESSION['phone']))  {
		$customerTel = $_SESSION['phone'];
		if($customerTel =='null'){
			$customerTel = "";
		}
	}
	$customerEmail = null;
	if (isset($_SESSION['email'])) {
		$customerEmail = $_SESSION['email'];
		if($customerEmail =='null'){
			$customerEmail = "";
		}
	}

		$undlg 			= new DialogueBD();
		$strCategorie 	= "";
		$strProduit 	= "";
		
		if(isset($_GET['categ'])){
			$strCategorie 	= $_GET['categ'];
		}
		
		$tabCategorieRecup = $undlg->getCategories($cnx);
		
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
			<h2>Renseignements pour la commande </h2>
			<form method="POST" action="paiement.php?cmd=nonPaye">
				<?php
					if(isset($_SESSION['login'])){
						echo '<h4>Veuillez vérifier vos informations : </h4>';
					}else{
						echo '<h4>Entrez vos informations : </h4>';
					}

				?>
				<label>Votre nom : </label>
				<input type="text" name="nom" value="<?php echo $customerNom?>">
				<br />
				<label>Votre prénom : </label>
				<input type="text" name="prenom" value="<?php echo $customerPrenom?>">
				<br />
				<label>Votre adresse : </label>
				<input type="text" name="adresse" value="<?php echo $customerAdresse?>">
				<?php
					if($customerAdresse!=null){
						echo '<a class="btn btn-secondary" href="renseignement.php?cmd=changerAdresse">Changer adresse</a>';
						
					}
				?>
				<br />
				<label>Votre code postal : </label>
				<input type="text" name="codePostal" value="<?php echo $customerCodeP?>">
				<br />
				<label>Ville : </label>

				<input type="text" name="ville" value="<?php echo $customerVille?>">
				<br />
				<label>Votre numéro de téléphone : </label>
				<input type="text" name="tel" value="<?php echo $customerTel?>">
				<br />
				<label>Votre email : </label>
				<input type="email" name="email" value="<?php echo $customerEmail?>">
				<br />
				<input type="submit" name="Enregistrer" value="Enregistrer">
			</form>
			
		</div>	
	</body>
</html>