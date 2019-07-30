<?php
//if(isset($_SESSION['commande'])){
require'FPDF/fpdf.php';
require_once 'DialogueBD.php';
session_start();
$undlg = new DialogueBD();
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Facture','C');
$pdf->Ln();
$pdf->Cell(40,10,'ISIWebShop',0,0,'L');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$pdf->Ln();
$c = null;

if(isset($_SESSION['adresse1'])){
	$c=utf8_decode($_SESSION['adresse1']);
}
$s = null;
if(isset($_SESSION['nom'])){
	$s=utf8_decode($_SESSION['nom']);
}
$n = null;
if(isset($_SESSION['prenom'])){
	$n=utf8_decode($_SESSION['prenom']);
}
$p = null;
if(isset($_SESSION['codeP'])){
	$p=utf8_decode($_SESSION['codeP']);
}
$v = null;
if($_SESSION['city']){
	$v=utf8_decode($_SESSION['city']);
}


$pdf->Cell(75,8,'Mr./Mme '.$n.' '.$s,0,0,'R');
$pdf->Ln();
$pdf->Cell(43,10,'Adresse: '.$c,0,0,'R');
$pdf->Ln();
$pdf->Cell(85,10,'Code postal et Ville: '.$p.' '.$v,0,0,'R');
$pdf->Ln();
$login = null;
if(isset($_SESSION['commande'])){
	$idCommande = $_SESSION['commande'];
	$idCustomer = null;
	if(isset($_SESSION['login'])){
		$login = $_SESSION['login'];
		$idCustomer =  $undlg->getCustomerViaLogin($cnx,$login);
	}else{
		$idCustomer = $_SESSION['idCustomer'];
	}
	$prod=$undlg->getPanier($cnx,$idCommande);
}

$pdf->SetFont('Arial','B',12);
$t=array(100,40,40);
$ent=array(utf8_decode('Produit'),utf8_decode('Quantité en euros'),utf8_decode('Prix en euros'));
$pdf->Cell($t[0],10,$ent[0],1,0,'L');//entete
$pdf->Cell($t[1],10,$ent[1],1,0,'L');
$pdf->Cell($t[2],10,$ent[2],1,0,'L');
$pdf->Ln();
$prixTotal = null;
if(isset($_SESSION['prixTotal'])){
	$prixTotal = $_SESSION['prixTotal'];
}

foreach ($prod as $p)
{
    $pg=$undlg->getProduit($cnx,$p["product_id"]);
   
    foreach($pg as $g){
        $co= utf8_decode($g['name']);
       

        $pdf->Cell($t[0],30,$co,1,0,'L');//contenu

        $pdf->Cell($t[1],30,utf8_decode($g['price']),1,0,'L');//contenu

        $pdf->Cell($t[2],30,utf8_decode( $p['quantity']),1,0,'L');//contenu
    }
    $pdf->Ln();
}
$pdf->Ln();
 $pdf->Cell(70,10,'',0,0,'L');
 $pdf->Cell(70,10,'Total',1,0,'L');
$pdf->Cell(40,10,utf8_decode($prixTotal),1,0,'L');

$pdf->Output();

//}
?>