<?php
	if(isset($_POST['paiement'])){
			$modePaiement = $_POST['paiement'];
		}
		
	$_SESSION['modePaiement'] = $modePaiement;

	}

?>