<?php
	session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;" charset="utf-8">
		<link href="Bootstrap3/css/bootstrap.css" rel="stylesheet">
		<link rel="stylesheet" href="designShop.css">
	</head>
	<body class="index_page">
	<?php
		 if(isset($_POST['cmd']) && $_POST['cmd']=='enregistrer')
        {
            include 'Enregistrement_Controller.php';
        }
	?>	
		<div >
			<form action="connexion_controller.php" method="POST">
				<div class="formulaire_connexion">
					<fieldset>
		    			<legend>Connexion</legend>
		    			<div class="form-group">
						    <label for="exampleInputEmail1">Login (Adresse mail)</label>
						    <input type="text" class="form-control" id="login" name="login" placeholder="Entrez votre email">
		    			</div>
		    			<div class="form-group">
					   		<label for="exampleInputPassword1">Password</label>
					    	<input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" placeholder="Password">
					    </div>
		    		</fieldset>
		    		<button type="submit" class="btn btn-primary">Submit</button>
		    		<a class="btn btn-secondary" href="Enregistrement.php?">S'inscrire<span class="sr-only">(current)</span></a>
		    		<a class="btn btn-secondary" href="accueil.php?">Retour<span class="sr-only">(current)</span></a>
		    		
	    		</div>
			</form>
		</div>
	</body>
</html>
