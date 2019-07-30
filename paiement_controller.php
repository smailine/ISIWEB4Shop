<?php
	$undlg = new DialogueBD();
	if($cmd='nonPaye'){
		$firstname = $_POST['nom'];
		$surname = $_POST['prenom'];
		$add1 = $_POST['adresse'];
		$city= $_POST['ville'];
		$postcode = $_POST['codePostal'];
		$email = $_POST['email'];
		$phone = $_POST['tel'];
		$add2 = $_SESSION['adresse2'];
		
		if(isset($_SESSION['idCustomer'])){
			$idC = $_SESSION['idCustomer'];
		}else{
			if(isset($_SESSION['login'])){
				$tabInfoClient = $undlg->getCustomerViaLogin($cnx,$login);
				foreach ($tabInfoClient as $info) {
					$idC = $info['id'];
				}
			}
			
		}

		$messageUpdateInfoCustomer = $undlg->updateInfoCustomer($cnx,$firstname,$surname,$add1,$add2,$postcode,$city,$phone,$email,$idC);
		

		$tabInfoCustomer = $undlg -> getInfoCustomer($cnx,$idC);
	
		$_SESSION['nom'] = null;
		$_SESSION['prenom'] = null;
		$_SESSION['city'] = null;
		$_SESSION['phone'] = null;
		$_SESSION['email'] = null;
		$nom = null;
		$prenom = null;
		
		foreach ($tabInfoCustomer as $info) {
			$_SESSION['nom'] = $info['surname'];
			$_SESSION['prenom'] = $info['firstname'];
			
			$_SESSION['city'] = $info['city'];
			$_SESSION['phone'] = $info['phone'];
			$_SESSION['email'] = $info['email'];
			
			$_SESSION['adresse1'] = $info['add1'];
			$_SESSION['adresse2'] = $info['add2'];
			$_SESSION['codeP'] = $info['postcode'];
		}
		


		$idCommande = $_SESSION['commande'];
		$message = $undlg -> updateStatut($cnx,$idCommande,1);
		$adresse = $_SESSION['adresse1'];
		
		
		$tabIdAdresse = $undlg -> getIdAdresse($cnx,$adresse);
		if(!empty($tabIdAdresse)){
			foreach ($tabIdAdresse as $idAdresse) {
				$message2 = $undlg -> updateOrderAdresse($cnx,$idCommande,$idAdresse['id']);
			}
		}else{
				//On ajoute dans la table delivery_adresses, l'adresse qui a été donné par le client
				$messageInsertionAdresse = $undlg->insertionAdresseInDeliveryAdresse($cnx,$adresse,$add2,$firstname,$surname,$city,$postcode,$phone,$email);
				/*$messageInsertionAdresse = $undlg->insertionAdresseInDeliveryAdresse($cnx,$add2,$adresse,$firstname,$surname,$city,$postcode,$phone,$email);*/
				$tabIdAdresse = $undlg -> getIdAdresse($cnx,$adresse);
				foreach ($tabIdAdresse as $idAdresse) {
					$message2 = $undlg -> updateOrderAdresse($cnx,$idCommande,$idAdresse['id']);
				}

			}
		}
		
	
?>