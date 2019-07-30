<?php
	$undlg = new DialogueBD();
	if($cmd=='ajouter'){
		$produit = $_POST['produit'];
		$quantite = $_POST['quantite'];

		//$tabProduit = $undlg->getProduit($cnx,$produit);
		$login = null;
		$idC = null;
		if(isset($_SESSION['idCustomer'])){
			$idC = $_SESSION['idCustomer'];
		}
		//si on ne s'est pas loguer, alors on enregistre un customer vide 
		if(!isset($_SESSION['login'])){
			//le cas ou on n'a pas encore identifié le customer invité ce qui veut dire qu'll a dej
			if(!isset($_SESSION['idCustomer'])){
			$messageInsertion = $undlg->Enregistrement2($cnx,'null','null','null','null','null','null','null','null','0');
			$tabMaxId = $undlg->getLastCustomer($cnx);
		
				foreach ($tabMaxId as $lastIdInserer) {
					$idSession = session_id();
					$idC = $lastIdInserer['maxi'];
					$_SESSION['idCustomer'] = $idC;
				}

			}else{
				$idC = $_SESSION['idCustomer'];
				
			}	
				
		}else{
			$login = $_SESSION['login'];
			$tabIdCustomer = $undlg->getCustomerViaLogin($cnx,$login);
			foreach ($tabIdCustomer as $idCustomer ){
					$idC = $idCustomer['id'];
					
			}
		
		}
		$tabIdCommande = $undlg->getIdCommande($cnx,$idC);
		if(empty($tabIdCommande)){
			if(isset($_SESSION['login']))
			{
				$message = $undlg->insertionNouvelleCommandePanier($cnx,$idC);
			}else{
				
				$idSession = session_id();
				
				$messageInsertionCommande = $undlg-> insertionNouvelleCommandePanierNonCompte($cnx,$idC,$idSession);
				
			}
			
			$tabIdCommande2 = $undlg->getIdCommande($cnx,$idC);
			foreach ($tabIdCommande2 as $idCommande) {

				$idCommande2 = $idCommande['id'];
				$messageCommandeProduit = $undlg->insertionCommandeProduit($cnx,$idCommande2,$produit,$quantite);
				$_SESSION['commande'] = $idCommande2;
			}
			 
		}else{
			foreach ($tabIdCommande as $idCommande1) {
				$idCom = $idCommande1['id'];
				$messageCommandeProduit1 = $undlg->insertionCommandeProduit($cnx,$idCom,$produit,$quantite);
				$_SESSION['commande'] = $idCom;
			}
		}
		
	}elseif ($cmd=='supprimer') {
		$produitSelecPanier = filter_input(INPUT_GET, 'produitPanier',FILTER_SANITIZE_NUMBER_INT);
		$message = $undlg -> supprimerProduit($cnx,$produitSelecPanier);
	
	}else{
		if(isset($_SESSION['login'])){
			$login = $_SESSION['login'];
			$tabIdCustomer = $undlg->getCustomerViaLogin($cnx,$login);

			foreach ($tabIdCustomer as $idCustomer ){
				$idC = $idCustomer['id'];
			}
		}else{
			$idC = $_SESSION['idCustomer'];
		}
		
		$tabIdCommande = $undlg->getIdCommande($cnx,$idC);
		if(!empty($tabIdCommande)){
			$tabIdCommande2 = $undlg->getIdCommande($cnx,$idC);
			foreach ($tabIdCommande2 as $idCommande) {

				$idCommande2 = $idCommande['id'];
				
				$_SESSION['commande'] = $idCommande2;
			}
	}

}

?>