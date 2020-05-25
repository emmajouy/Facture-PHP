<?php 

$entreprises = array(
	array("Nom" =>"FNAC Paris Saint Lazare",
		"Adresse" =>"109 rue Saint Lazare, Paris 75009",
		"Telephone" =>"09 18 94 53 02",
		"Mail" => "contact@fnac.fr"),
	array("Nom" =>"Emma Jouy",
		"Adresse" =>"48 rue de Turbigo, Paris 75003",
		"Telephone" =>"06 95 47 93 18",
		"Mail" => "emma.jouy14@gmail.com") 

);

$numero_facture = mt_rand();
$date_facture = date("d/m/Y");

function quantite () {
	$quantite = mt_rand(1,3);
	return $quantite;
}


function make_facture($ref, $designation, $prix, $quantite) {
	return [
		"Reference" => $ref,
		"Designation" => $designation,
		"Prixunitaire" => $prix,
		"Quantite" => $quantite,
		"Prixtotal" => $prix * $quantite
	];
}

$facture = [
	make_facture(mt_rand(), "Enceinte UE Boom 2", 100, quantite()),
    make_facture(mt_rand(), "Switch Lite Grise", 200, quantite()),
    make_facture(mt_rand(), "Animal Crossing NH", 54.99, quantite()),
    make_facture(mt_rand(), "Zelda : Breath of the Wild", 55.99, quantite()),
    make_facture(mt_rand(), "Reflex Canon EOS 800D", 665, quantite())
];



require ('fpdf.php');




$pdf = new FPDF();
$pdf->AddPage();
$pdf->Setfont('Helvetica','B',10);
$pdf->Image('https://upload.wikimedia.org/wikipedia/commons/thumb/2/2e/Fnac_Logo.svg/1200px-Fnac_Logo.svg.png',10,10,-900);
$pdf->Cell(120);
$pdf->Cell(75,10, $entreprises[0]["Nom"],0,0,'L');
$pdf->Ln();
$pdf->Cell(120);
$pdf->Cell(75,10,$entreprises[0]["Adresse"],0,0,'L');
$pdf->Ln();
$pdf->Cell(120);
$pdf->Cell(75,10,$entreprises[0]["Telephone"],0,0,'L');
$pdf->Ln();
$pdf->Cell(120);
$pdf->Cell(75,10,$entreprises[0]["Mail"],0,0,'L');
$pdf->Ln();
$pdf->Cell(75,10,$entreprises[1]["Nom"],0,0,);
$pdf->Ln();
$pdf->Cell(75,10,$entreprises[1]["Adresse"],0,0,);
$pdf->Ln();
$pdf->Cell(75,10,$entreprises[1]["Telephone"],0,0,);
$pdf->Ln();
$pdf->Cell(75,10,$entreprises[1]["Mail"],0,0,);
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(18,10,'Facture #');
$pdf->Cell(75,10,$numero_facture);
$pdf->Ln();
$pdf->Cell(25,10,utf8_decode('Fait à Paris le'));
$pdf->Cell(75,10,$date_facture);
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(30,10,utf8_decode('Référence'),1);
$pdf->Cell(75,10,utf8_decode('Désignation'),1);
$pdf->Cell(30,10,'Prix U',1);
$pdf->Cell(25,10,utf8_decode('Quantité'),1);
$pdf->Cell(35,10,'Prix Total',1);
$pdf->Ln();

foreach ($facture as $item) {
	$pdf->Cell(30,10,$item["Reference"]); 
	
	$pdf->Cell(75,10,$item["Designation"]);

	$pdf->Cell(30,10,$item["Prixunitaire"]);
	 
	$pdf->Cell(25,10,$item["Quantite"]); 
	$pdf->Cell(35,10,$item["Prixtotal"]);  
	$pdf->Ln(); 
}

function prixht ($facture){
	$result = 0;
		foreach ($facture as $item) {
		$result += $item["Prixtotal"];

		}		
			return ($result);

}

function ttc ($ht) {

	$ttc = $ht * 1.2 ;
		return ($ttc);
				
}

	$ht = prixht($facture);
	$prixttc = ttc($ht,2);


	$ht = number_format($ht,2);
	$prixttc = number_format($prixttc,2);



$pdf->Ln();
$pdf->Cell(130);
$pdf->Cell(30,10, 'Prix HT : ',1);
$pdf->Cell(30,10, $ht,1 );
$pdf->Ln();
$pdf->Cell(130);
$pdf->Cell(30,10, 'TVA (20%) : ',1);
$pdf->Cell(30,10, (ttc(prixht($facture)) - prixht($facture)),1 );
$pdf->Ln();
$pdf->Cell(130,10,utf8_decode("Date d'écheance : 20/06/2020"));
$pdf->Cell(30,10, 'Prix TTC : ',1);
$pdf->Cell(30,10, $prixttc ,1);

$pdf->Ln();
$pdf->Ln();


$pdf->Cell(200,5, utf8_decode("Conformément aux dispositions de l'article L.441-6 du code de commerce, tout retard de paiement entraine le"));
$pdf->Ln();
$pdf->Cell(200,5, utf8_decode("règlement de pénalités de retard au taux annuel de 14%. Aucun escompte ne sera accordé en cas de paiement"));
$pdf->Ln();
$pdf->Cell(200,5, utf8_decode("anticipé. Les remises appliquées sont des remises commerciales appliquées à titre exceptionnel."));
$pdf->Ln();
$pdf->Cell(200,5, utf8_decode(" Code commerce art D441-5 Indemnité forfaitaire frais de recouvrement 40 EUR."));

$pdf->output();

?>