<?php
session_start();
$login=$_SESSION['login'];

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include "setup_inc.php";
require_once "DialogueBD.php";

$undlg = new DialogueBD();
$cmd = filter_input(INPUT_GET, 'cmd');

if (is_null($cmd)){
    $cmd = filter_input(INPUT_POST, 'cmd');
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
							echo '</li>';
							if($login != null){
                                echo '<a class="nav-link" href="Accueil.php?deconnecter=true">Deconnection<span class="sr-only">(current)</span></a>';
								echo '<a class="navbar-brand" href="#">Bonjour '.$login.'</a></li>';
							}
						?>
                                               
					</li>
				</ul>
	 		</div>
		</nav>
            <br />                   
            <div class="corps">
    <?php 
                                                   
    if ($_SESSION['role']=='admin' && $cmd=='Listecommandes'|| $_SESSION['role']=='admin' && $cmd=='Confirmer'){

        if($cmd=='Confirmer'){    $id= filter_input(INPUT_POST, 'id');  $status= 10;  
        
        $undlg->StatusCommande($cnx,$id,$status);}// mis à jour de la table 
        $status= 2; //commande confirmé par le client.
        $commandes = $undlg->getCommandes($cnx,$status);

        if($commandes==null){
            echo '</br>'
            . '</br> </br></br><h2>Aucune commande en cours</h2>';
            
        }

        else{
             echo '<div> <form action="ListeCommande.php" method="POST">';
            echo ' <table>
                <tr class="table-info"><th> Identifiant Client</th><th>resgistred</th><th>Id Adresse de livraison</th>
            <th>Type de paiement</th><th>Date</th><th>status</th>
            <th>Session</th><th>Total</th></tr>';

             foreach ($commandes as $co) {
                    echo '<tr><td >';
                    echo ''.$co['id'].'';
                    echo '</td>';
                    echo '<td>';
                    echo ''.$co['registered'].'';
                    echo '</td>';
                    echo '<td >';
                    echo ''.$co['delivery_add_id'].'';
                    echo '</td>';

                    echo '<td >';
                    echo ''.$co['payment_type'].'';
                    echo '</td>';
                    echo '<td >';
                    echo ''.$co['date'].'';
                    echo '</td>';
                    echo '<td >';
                    echo ''.$co['status'].'';
                    echo '</td>';

                    echo '<td >';
                    echo ''.$co['session'].'';
                    echo '</td>';
                    echo '<td>';
                    echo ''.$co['total'].'€';
                    echo '</td>';
                    echo '<td><input type="hidden" name="id" value="'.$co['id'].'">'
                    . '<input type="submit" name="cmd" value="Confirmer"/></td></tr>'; 

            }   
            echo '</table>';
            echo '</form ></div>';
        }

    }
    ?>
         </div>
				
        </body>		
	
</html>