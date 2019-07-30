<?php
	$undlg = new DialogueBD();
	$login = null;
	$idCustomer = null;
	$tabInfoCustomer = null;
	if (isset($_SESSION['login'])) {
		$login = $_SESSION['login'];
		$tabCustomer = $undlg -> getCustomerViaLogin($cnx,$login);

			foreach ($tabCustomer as $customer) {
				$idCustomer = $customer['customer_id'];
				//pour le passage en caisse
				$tabInfoCustomer = $undlg -> getInfoCustomer($cnx,$idCustomer);
			}
		
	}else{
		if(isset($_SESSION['idCustomer']))
		{
			$idCustomer = $_SESSION['idCustomer'];
			$tabInfoCustomer = $undlg -> getInfoCustomer($cnx,$idCustomer);	

		}
		
		
	}
	

	if($cmd=='caisse'){
		$prixTotal = null;
		$idCommande = $_SESSION['commande'];
		if(isset($_SESSION['prixTotal'])){
			$prixTotal = $_SESSION['prixTotal'];
			$undlg->updatePrixCommande($cnx,$idCommande,$prixTotal);
		}
		
		
		/*$_SESSION['nom'] = null;
		$_SESSION['prenom'] = null;
		$_SESSION['city'] = null;
		$_SESSION['phone'] = null;
		$_SESSION['email'] = null;*/
		$nom = null;
		$prenom = null;
	
		foreach ($tabInfoCustomer as $info) {
			$_SESSION['nom'] = $info['surname'];
			$_SESSION['prenom'] = $info['firstname'];
			
			$_SESSION['city'] = $info['city'];
			$_SESSION['phone'] = $info['phone'];
			$_SESSION['email'] = $info['email'];
			//var_dump($info['email']);
			$_SESSION['adresse1'] = $info['add1'];
			$_SESSION['adresse2'] = $info['add2'];
			$_SESSION['codeP'] = $info['postcode'];
		}
		



	}elseif($cmd='changerAdresse'){
		$tabInfoCustomer = $undlg -> getInfoCustomer($cnx,$idCustomer);
		
		foreach ($tabInfoCustomer as $info) {
			if($_SESSION['adresse1']==$info['add1']){
				$_SESSION['adresse1'] = $info['add2'];
				$_SESSION['adresse2'] = $info['add1'];
			}else{
				$_SESSION['adresse1'] = $info['add1'];
				$_SESSION['adresse2'] = $info['add2'];
			}
			
		}
	}




?>