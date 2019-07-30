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
                                echo '<a class="nav-link" href="panier.php">Mon panier<span class="sr-only">(current)</span></a>';
                                echo '</li>';
                               
                                    echo '<a class="nav-link" href="connexion.php">Connexion<span class="sr-only">(current)</span></a>';
                            ?>
                </ul>
            </div>
        </nav>
        <form action="Connexion.php" method="POST">
                    <div class="formulaire_Inscription">

                            <fieldset>


                            <legend>Inscription Client</legend>
                            <div class="form-group">
                                
                                        <label for="exampleInputEmail1">Prénom</label>
                                        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Entrez votre prénom" required >
                            </div>
                            <div class="form-group">
                                
                                        <label for="exampleInputEmail1">Nom</label>
                                        <input type="text" class="form-control" id="surname" name="surname" placeholder="Entrez votre nom" required >
                            </div>
                            <div class="form-group">
                                
                                        <label for="exampleInputEmail1">Adresse</label>
                                        <input type="text" class="form-control" id="add1" name="add1" placeholder="Entrez votre adresse" required >
                            </div>
                            <div class="form-group">
                                
                                        <label for="exampleInputEmail1">Complement Adresse</label>
                                        <input type="text" class="form-control" id="add2" name="add2" placeholder="Entrez votre complement d'adresse"required >
                            </div>
                            <div class="form-group">
                                
                                        <label for="exampleInputEmail1">Ville</label>
                                        <input type="text" class="form-control" id="city" name="city" placeholder="Entrez votre ville" required >
                            </div>
                             <div class="form-group">
                                
                                        <label for="exampleInputEmail1">Code Postal</label>
                                        <input type="text" class="form-control" id="postcode" name="postcode" placeholder="Entrez votre Code Postale " required >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Adresse mail</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Entrez votre email" required >
                            </div>
                            
                             <div class="form-group">
                                <label for="exampleInputEmail1">Telephone</label>
                                <input type="text" class="form-control" size="10" id="phone" name="phone" placeholder="Entrez votre telephone" required >
                            </div>
                            
                            </fieldset>
                            <fieldset>


                            <legend>Creaction du login </legend>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Login</label>
                                <input type="text" class="form-control" id="login" name="login" placeholder="Entrez le Login" required >
                            </div>
                            
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password"  class="form-control" id="mot_de_passe" name="mot_de_passe" placeholder="Password" required >
                            </div>
                    </fieldset>
                    <button type="submit"  name= 'cmd' value='enregistrer' class="btn btn-primary">Valider</button>
            </div>
          </form>
		
