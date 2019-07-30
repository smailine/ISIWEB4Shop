<?php
include_once "setup_inc.php";
	class DialogueBD {

		function getCategories($connexionBase){
			
			try{
				$sql = "SELECT * FROM categories";
				$sthCategorie= $connexionBase->prepare($sql);
				$sthCategorie->execute();
				$tabCategorie = $sthCategorie->fetchAll(PDO::FETCH_ASSOC);
				return $tabCategorie;
			}catch(PDOException $e){
				$erreur = $e->getMessage();
			}
		}

		function getListeProduit($connexionBase,$categorie){
			try{
				$sql = "SELECT * FROM products where cat_id=".$categorie;
				$sthListeProduit= $connexionBase->prepare($sql);
				$sthListeProduit->execute();
				$tabListeProduit = $sthListeProduit->fetchAll(PDO::FETCH_ASSOC);
				return $tabListeProduit;
			}catch(PDOException $e){
				$erreur = $e->getMessage();
			}
		}

		function getNbProduit($connexionBase,$categorie){
			try{
				$sql = "SELECT COUNT(*) as nombre FROM products GROUP BY cat_id HAVING cat_id=".$categorie;
				$sthNbProduit= $connexionBase->prepare($sql);
				$sthNbProduit->execute();
				$tabNbProduit = $sthNbProduit->fetchAll(PDO::FETCH_ASSOC);
				return $tabNbProduit;
			}catch(PDOException $e){
				$erreur = $e->getMessage();
			}
		}

		function getProduit($connexionBase,$produit){
			try{
				$sql = "SELECT * FROM products where id=".$produit;
				$sthProduit= $connexionBase->prepare($sql);
				$sthProduit->execute();
				$tabProduit = $sthProduit->fetchAll(PDO::FETCH_ASSOC);
				return $tabProduit;
			}catch(PDOException $e){
				$erreur = $e->getMessage();
			}
		}

		function getUtilisateur($connexionBase,$login,$mdp){
			$verifier = false;
			try{
				$sql = 'SELECT * FROM logins where username="'.$login.'" AND password="'.$mdp.'";';
				$sthUtilisateur= $connexionBase->prepare($sql);
				$sthUtilisateur->execute();
				$tabUtilisateur = $sthUtilisateur->fetchAll(PDO::FETCH_ASSOC);

				if(count($tabUtilisateur) == 1){
					//header('Location: http://localhost/isiweb4shop/connexion.php');
					$verifier = true;

				}
			}catch(Exception $e){
				$msgErreur = $e->getMessage() . '(' . $e->getFile() . ', ligne ' .$e->getLine() . ')';
			}
			return $verifier;
		}

		
		function getCustomerViaLogin($connexionBase,$login){
			try{
				$sql = 'SELECT * FROM logins where username="'.$login.'";';
				$sthIdCustomer= $connexionBase->prepare($sql);
				$sthIdCustomer->execute();
				$tabIdCustomer = $sthIdCustomer->fetchAll(PDO::FETCH_ASSOC);
				
				return $tabIdCustomer;
				
			}catch(Exception $e){
				$msgErreur = $e->getMessage() . '(' . $e->getFile() . ', ligne ' .$e->getLine() . ')';
			}
		}

		function getIdCommande($connexionBase,$idCustomer){
			try{
				$sql = 'SELECT id FROM orders where customer_id="'.$idCustomer.'" AND status=0;';
				$sthIdCommande= $connexionBase->prepare($sql);
				$sthIdCommande->execute();
				$tabIdCommande = $sthIdCommande->fetchAll(PDO::FETCH_ASSOC);
				return $tabIdCommande;
				
			}catch(Exception $e){
				$msgErreur = $e->getMessage() . '(' . $e->getFile() . ', ligne ' .$e->getLine() . ')';
			}
		}

		function insertionNouvelleCommandePanier($connexionBase,$idCustomer){
			try{
				$date_auj = date("y-m-d");
				$sql = "INSERT INTO orders (customer_id,registered,delivery_add_id,payment_type,date,status,session,total) VALUES ('".$idCustomer."',1,1,1,'".$date_auj."',0,'null',0);";
				$sthInsertion = $connexionBase->prepare($sql);
				$sthInsertion->execute();

				$message = "La commande a été ajouté avec succès";
			}catch(Exception $e){
				$message = $e->getMessage() . '(' . $e->getFile() . ', ligne ' .$e->getLine() . ')';
			}

			return $message;

		}

		function insertionCommandeProduit($connexionBase,$idCommande,$idProduit,$quantite){
			try{
				$sql = "INSERT INTO orderitems (order_id,product_id,quantity) VALUES ('".$idCommande."','".$idProduit."','".$quantite."');";
				$sthInsertion= $connexionBase->prepare($sql);
				$sthInsertion->execute();

				$message = "La commande du produit a été ajouté avec succès";
			}catch(Exception $e){
				$message = $e->getMessage() . '(' . $e->getFile() . ', ligne ' .$e->getLine() . ')';
			}

			return $message;
		}

		function getPanier($connexionBase,$idCommande){
			try{
				$sql = 'SELECT * FROM orderitems where order_id="'.$idCommande.'";';
				$sthPanier= $connexionBase->prepare($sql);
				$sthPanier->execute();
				$tabPanier = $sthPanier->fetchAll(PDO::FETCH_ASSOC);
				
				return $tabPanier;
				
			}catch(Exception $e){
				$msgErreur = $e->getMessage() . '(' . $e->getFile() . ', ligne ' .$e->getLine() . ')';
			}
		}

		function supprimerProduit($connexionBase,$idProduit){
			try{
				$sql = "DELETE FROM orderitems WHERE id=".$idProduit; 
				$sthSuppression= $connexionBase->prepare($sql);
				$sthSuppression->execute();

				$message = "La commande du produit a été supprimée avec succès";
			}catch(Exception $e){
				$message = $e->getMessage() . '(' . $e->getFile() . ', ligne ' .$e->getLine() . ')';
			}

			return $message;
		}

		function getInfoCustomer($connexionBase,$idCustomer){
			try{
				$sql = 'SELECT * FROM customers where id="'.$idCustomer.'";';
				$sthCustomer= $connexionBase->prepare($sql);
				$sthCustomer->execute();
				$tabCustomer = $sthCustomer->fetchAll(PDO::FETCH_ASSOC);
				return $tabCustomer;
				
			}catch(Exception $e){
				$msgErreur = $e->getMessage() . '(' . $e->getFile() . ', ligne ' .$e->getLine() . ')';
			}
		}

		function getAdresseCustomer($connexionBase,$firstname,$lastname){
			try{
				$sql = 'SELECT * FROM delivery_addresses where firstname="'.$firstname.'" AND lastname="'.$lastname.'";';
				$sthAdresseCustomer= $connexionBase->prepare($sql);
				$sthAdresseCustomer->execute();
				$tabAdresseCustomer = $sthAdresseCustomer->fetchAll(PDO::FETCH_ASSOC);
				return $tabAdresseCustomer;
				
			}catch(Exception $e){
				$msgErreur = $e->getMessage() . '(' . $e->getFile() . ', ligne ' .$e->getLine() . ')';
			}
		}

		function updateStatut($connexionBase,$idCommande,$statut){
			try{
				$sql = "UPDATE orders SET status = '".$statut."' WHERE id = ".$idCommande;
				$sthUpdate= $connexionBase->prepare($sql);
				$sthUpdate->execute();

				$message = "La commande a été mis à jour avec succès";
				
			}catch(Exception $e){
				$message = $e->getMessage() . '(' . $e->getFile() . ', ligne ' .$e->getLine() . ')';
			}

			return $message;
		}

		function updateOrderAdresse($connexionBase,$idCommande,$idAdresse){
			try{
				$sql = "UPDATE orders SET delivery_add_id = ".$idAdresse." WHERE id = ".$idCommande;
				$sthUpdate= $connexionBase->prepare($sql);
				$sthUpdate->execute();

				$message = "La commande a été mis à jour avec succès";
				
			}catch(Exception $e){
				$message = $e->getMessage() . '(' . $e->getFile() . ', ligne ' .$e->getLine() . ')';
			}

			return $message;
		}

		function getIdAdresse($connexionBase,$adresse){
			try{
				$sql = 'SELECT * FROM delivery_addresses where add1 = "'.$adresse.'";';
				$sthIdAdresseCustomer =  $connexionBase->prepare($sql);
				$sthIdAdresseCustomer->execute();
				$sthIdAdresseCustomer = $sthIdAdresseCustomer->fetchAll(PDO::FETCH_ASSOC);
				return $sthIdAdresseCustomer;
				
			}catch(Exception $e){
				$msgErreur = $e->getMessage() . '(' . $e->getFile() . ', ligne ' .$e->getLine() . ')';
			}
		}

		function getAdmin($connexionBase,$login,$mdp){
	    $verifier = false;
	    try{
	            $sql = 'SELECT * FROM admin where username="'.$login.'" AND password="'.$mdp.'";';
	            $sthUtilisateur= $connexionBase->prepare($sql);
	            $sthUtilisateur->execute();
	            $tabUtilisateur = $sthUtilisateur->fetchAll(PDO::FETCH_ASSOC);

	            if(count($tabUtilisateur) == 1){
	                    //header('Location: http://localhost/isiweb4shop/connexion.php');
	                    $verifier = true;

	            }
	    }catch(Exception $e){
	            $msgErreur = $e->getMessage() . '(' . $e->getFile() . ', ligne ' .$e->getLine() . ')';
	    }
	    	return $verifier;
	    }

	    function getCommandes($connexionBase,$status){
            try{
                    $sql = "SELECT * FROM orders where status='".$status."'";
                    $sthListeCommandes= $connexionBase->prepare($sql);
                    $sthListeCommandes->execute();
                    $tabListeCommandes = $sthListeCommandes->fetchAll(PDO::FETCH_ASSOC);

                    return $tabListeCommandes;
            }catch(PDOException $e){
                    $erreur = $e->getMessage();
                    
            }
   		}
    //donne une commande par statu et id_client
	    function getCommandesEncours($connexionBase,$status, $id_client){
	           try{
	                   $sql = "SELECT * FROM ordres where status='".$status."' and id_customer='".$id_client."'";
	                   $sthListeCommandes= $connexionBase->prepare($sql);
	                   $sthListeCommandes->execute();
	                   $tabListeCommandes = $sthListeCommandes->fetchAll(PDO::FETCH_ASSOC);
	                   return $tabListeCommandes;
	           }catch(PDOException $e){
	                   $erreur = $e->getMessage();
	           }
	   }

	   // change le statu d'une commande
    	function StatusCommande($connexionBase,$id,$status){
                try{

                    $sql = "update orders set status='".$status."' where id='".$id."'";
                    $sthListeCommandes= $connexionBase->prepare($sql);
                    $sthListeCommandes->execute();
                    $tabListeCommandes = $sthListeCommandes->fetchAll(PDO::FETCH_ASSOC);
                    return $tabListeCommandes;
                }catch(PDOException $e){
                    	$erreur = $e->getMessage();
                    }
                }
                 //donne un produit par son id           
   		function getCostumersI($connexionBase){
	        try{
	             $sql = "SELECT * FROM customers ORDER BY ID DESC";
	             $b= $connexionBase ->prepare($sql);
	             $b->execute();
	             $id_cos = $b->fetchAll(PDO::FETCH_ASSOC);
	            
	             return $id_cos;

		    }catch(PDOException $e){
		             $erreur = $e->getMessage();
		   	}
		}

		function getAdresseAlternatif($cnx,$id_orders, $id_client){
	        
	    }
	    function getAdresse($cnx,$id_client){
	         try{

	                    $sql = "SELECT * FROM customers where id='".$id_client."'";
	                    $sthAdd= $connexionBase->prepare($sql);
	                    $sthAdd->execute();
	                    $tabAdd = $sthAdd->fetchAll(PDO::FETCH_ASSOC);
	                    return $tabAdd;

	            }catch(PDOException $e){
	                    $erreur = $e->getMessage();
	            }
	    }
	    function getCostumerByLogin($cnx,$login){
	         try{

	                    $sql = "SELECT customer_id FROM logins where username='".$login."'";
	                    $id= $connexionBase->prepare($sql);
	                    $id->execute();
	                    $id_cos = $id->fetchAll(PDO::FETCH_ASSOC);
	                    
	                    $sql1 = "SELECT * FROM customers where id='".$i_cos->id."'";
	                    $cos= $connexionBase->prepare($sql);
	                    $cos->execute();
	                    $lecos = $id->fetchAll(PDO::FETCH_ASSOC);
	                    return $lecos;

	            }catch(PDOException $e){
	                    $erreur = $e->getMessage();
	            }
	    }

	    function  getOrderItem($connexionBase,$id){
	       	$sql = "SELECT * FROM order_items where order_id='".$id."'";
	        $sthProd= $connexionBase->prepare($sql);
	        $sthProd->execute();
	        $tabProdcts = $sthProd->fetchAll(PDO::FETCH_ASSOC);
	        return $tabProdcts;
	   	}	

	    FUNCTION dernierIndex($cnx){
	        return $cnx->lastInsertId();
	    }

		

		function Enregistrement2($connexionBase,$firstname,$surname,$add1,$add2,$city,$postcode,$email,$phone,$registered)
	    {

	        try{
	        
	                $sql1 = "INSERT INTO customers(id,firstname, surname, add1, add2, postcode, city, phone, email, registered) VALUES (NULL,'".$firstname."','".$surname."','".$add1."','".$add2."','".$city."','".$postcode."','".$email."','".$phone."','".$registered."');";
	                $id = $connexionBase->prepare($sql1);
	                $id->execute();
 					$message = "Le client a été ajouté avec succès";
				

	         }catch(PDOException $e){
	                 $message = $e->getMessage() . '(' . $e->getFile() . ', ligne ' .$e->getLine() . ')';
	         }

	         return $message;
	    }

	    function Enregistrement1($connexionBase,$id,$login, $mdp)
	   {

	       try{
	                $sql2 = "INSERT INTO logins (customer_id, username, password) VALUES ('".$id."','".$login."','".$mdp."' )";
	                $cos2= $connexionBase->prepare($sql2);
	                $cos2->execute();
	                $lecos2 = $cos2->fetchAll(PDO::FETCH_ASSOC);


	        }catch(PDOException $e){
	                $erreur = $e->getMessage();
	        }

	   }

	    function insertionNouvelleCommandePanierNonCompte($connexionBase,$idCustomer,$sessionId){
			try{
				$date_auj = date("y-m-d");
				$sql = "INSERT INTO orders (customer_id,registered,delivery_add_id,payment_type,date,status,session,total) VALUES ('".$idCustomer."',0,'".$idCustomer."',1,'".$date_auj."',0,'".$sessionId."',0);";
				$sthInsertion = $connexionBase->prepare($sql);
				$sthInsertion->execute();

				$message = "La commande a été ajouté avec succès";
			}catch(Exception $e){
				$message = $e->getMessage() . '(' . $e->getFile() . ', ligne ' .$e->getLine() . ')';
			}

			return $message;

		}

		function updatePrixCommande($connexionBase,$idCommande,$prixTotal){
			try{
				$sql = "UPDATE orders SET total = '".$prixTotal."' WHERE id = ".$idCommande;
				$sthUpdate= $connexionBase->prepare($sql);
				$sthUpdate->execute();

				$message = "La commande a été mis à jour avec succès";
				
			}catch(Exception $e){
				$message = $e->getMessage() . '(' . $e->getFile() . ', ligne ' .$e->getLine() . ')';
			}

			return $message;
		} 

		function getLastCustomer($connexionBase){
			try{
				$sql = 'SELECT MAX(id) as maxi FROM customers;';
				
				$sthMaxId =  $connexionBase->prepare($sql);
				$sthMaxId->execute();
				$tabMaxId = $sthMaxId->fetchAll(PDO::FETCH_ASSOC);
		
		
				return $tabMaxId;
				
			}catch(Exception $e){
				$msgErreur = $e->getMessage() . '(' . $e->getFile() . ', ligne ' .$e->getLine() . ')';
			}
		}

		function updateInfoCustomer($connexionBase,$firstname,$surname,$add1,$add2,$postcode,$city,$phone,$email,$idC){
			try{
				$sql = "UPDATE customers SET firstname = '".$firstname."', surname = '".$surname."', add1 = '".$add1."', add2 = '".$add2."' , postcode = '".$postcode."' , city = '".$city."'  , phone = '".$phone."'  , email = '".$email."' WHERE id=".$idC;
				$sthUpdate= $connexionBase->prepare($sql);
				$sthUpdate->execute();

				$message = "Le client a été mis à jour avec succès";
				
			}catch(Exception $e){
				$message = $e->getMessage() . '(' . $e->getFile() . ', ligne ' .$e->getLine() . ')';
			}

			return $message;

		}

		function insertionAdresseInDeliveryAdresse($connexionBase,$adresse1,$adresse2,$firstname,$lastname,$city,$postcode,$phone,$email){

			try{
				$sql = "INSERT INTO delivery_addresses (id,firstname,lastname,add1,add2,city,postcode,phone,email) VALUES (NULL,'".$firstname."','".$lastname."','".$adresse1."','".$adresse2."','".$city."','".$postcode."','".$phone."','".$email."');";
				$sthInsertion = $connexionBase->prepare($sql);
				$sthInsertion->execute();

				$message = "L'adresse de la commande a été ajouté avec succès";
			}catch(Exception $e){
				$message = $e->getMessage() . '(' . $e->getFile() . ', ligne ' .$e->getLine() . ')';
			}

			return $message;

		}



	}

?>
