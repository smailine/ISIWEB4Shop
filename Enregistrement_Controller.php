<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

	include_once "setup_inc.php";
	require_once "DialogueBD.php";

	$firstname=$_POST['firstname'];
	$surname=$_POST['surname'];
	$add1=$_POST['add1'];
	$add2=$_POST['add2'];
	$city=$_POST['city'];
	$postcode=$_POST['postcode'];
	$email=$_POST['email'];
	$phone=$_POST['phone'];
	$resgistered=1;
	$login=$_POST['login'];
	$mdp=$_POST['mot_de_passe'];


	 $obj = new DialogueBD();
	$obj->Enregistrement1($cnx,$firstname,$surname,$add1,$add2,$city,$postcode,$email,$phone,$resgistered);
	$idg= $obj->dernierIndex($cnx);

	$obj->Enregistrement1($cnx,$idg,$login,$mdp);

	?>


