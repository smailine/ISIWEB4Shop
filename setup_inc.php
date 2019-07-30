<?php
	include_once "config_inc.php";
  	try{
			$cnx = new PDO("mysql:host=$dbhost;dbname=$dbbase", $dbuser, $dbpwd);
			$cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$cnx->exec('SET CHARACTER SET utf8');
		} catch (PDOException $e) {
			$erreur = $e->getMessage();

	}
?>