<?php
	include "setup_inc.php"; 
	require_once "DialogueBD.php";
	if(!isset($_SESSION)) 
    { 
        session_start(); 
    }	$login_saisi = $_POST['login'];
	$mdp_saisi = $_POST['mot_de_passe']; 
	$undlg 			= new DialogueBD();
	$verifier = $undlg->getUtilisateur($cnx,$login_saisi,$mdp_saisi);
	$verif=$undlg->getAdmin($cnx, $login_saisi, $mdp_saisi);

	if($verifier == false && $verif==false){
		header('Location: http://localhost/isiweb4shop/connexion.php');
               
	}else if($verifier==true){
		$_SESSION['login'] = $login_saisi;
		header('Location: http://localhost/isiweb4shop/accueil.php');
	}
        else if($verif==true){
		$_SESSION['login'] = $login_saisi;
                $role='admin';
                $_SESSION['role']=$role;
		header('Location: http://localhost/isiweb4shop/accueil.php');
	}


	if(isset($_GET['deconnecter'])){
		$str_deconnecter = $_GET['deconnecter'];

		if($str_deconnecter == true){
			
			session_unset();
			
			header('Location: http://localhost/isiweb4shop/accueil.php');
		}
	}
?>
