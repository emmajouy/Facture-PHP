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
	make_facture(mt_rand(), "Enceinte UE Boom 2",100, quantite()),
    make_facture(mt_rand(), "Switch Lite Grise", 200, quantite()),
    make_facture(mt_rand(), "Animal Crossing New Horizons", 54.99, quantite()),
    make_facture(mt_rand(), "Zelda : Breath of the Wild", 55.99 , quantite()),
    make_facture(mt_rand(), "Reflex Canon EOS 800D", 665, quantite())
];

?>

<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Facture Emma Jouy</title>
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" type="text/css" href="impression.css" media="print">
	<link href="https://fonts.googleapis.com/css2?family=Jost:wght@200;300;400;700&display=swap" rel="stylesheet">
</head>
<body>
	<form class="flex al-items-flex-start just-content-flex-start margin-left-20 none">
  <input id="impression" name="impression" type="button" onclick="window.print()" class="border-none padding-right-40" />
  <div class="margin-20"></div>
<a href="makepdf.php"><img src="https://cdg14.fr/wp-content/uploads/2017/12/PDF-LOGO.png" alt="PDF" width="70px" height="70px"></a>
	</form>
	<main class="format">
		<img src="https://maxibonsplans.info/wp-content/uploads//2016/06/fnac-logo.jpg" alt="fnac" align="center">
		<hr align="center" width="100%" color="black" size="2.5">

		<section class="flex flexrow margin-top-40">
		<div class="col l7"></div>
		<div class="col l5 column al-items-flex-end just-content-flex-end margin-right-20 uppercase color898585">
			<p><?= $entreprises[0]["Nom"] ?></p>
			<p><?= $entreprises[0]["Adresse"] ?></p>
			<p><a href="tel:+33918945302"><?= $entreprises[0]["Telephone"] ?></a></p>
			<p><a href="mailto:contact@fnac.fr"><?= $entreprises[0]["Mail"] ?></a></p>
		</div>
		</section>

		<section class="flex flexrow">
		<div class="col l4 column al-items-flex-start just-content-flex-start margin-left-20 uppercase">
			<p><?= $entreprises[1]["Nom"] ?></p>
			<p><?= $entreprises[1]["Adresse"] ?></p>
			<p><a href="tel:+33695479318"><?= $entreprises[1]["Telephone"] ?></a></p>
			<p><a href="mailto: emma.jouy14@gmail.com"><?= $entreprises[1]["Mail"] ?></a></p>
		</div>
		<div class="col l8"></div>
		</section>

		<section class="flex">
		<div class="uppercase col l6 column">
			<h1> F a c t u r e  #<?= $numero_facture ?></h1>
			<h2> <?= $date_facture ?> à Paris</h2>
		</div>
		<div class="col l6"></div>
		</section>


		<section class="col l12 just-content-center margin-20">
			<table class="width100 height-300 align-center collapse">
				<tr class="padding-20 font-size uppercase colorfnac">
					<th class="border-bottom-2px font-400">Référence</th>
					<th class="border-bottom-2px font-400">Désignation</th>
					<th class="border-bottom-2px font-400">Prix Unitaire</th>
					<th class="border-bottom-2px font-400">Quantité</th>
					<th class="border-bottom-2px font-400">Prix total</th>
				</tr>
				
				<?php foreach ($facture as $item) { ?>

				<tr>

					<td class="border-bottom"><?= $item["Reference"] ?></td>
					<td class="border-bottom"><?= $item["Designation"] ?></td>
					<td class="border-bottom"><?= $item["Prixunitaire"] ?></td>
					<td class="border-bottom"><?= $item["Quantite"] ?></td>
					<td class="border-bottom"><?= $item["Prixtotal"] ?></td>
				</tr>

				<?php } ?>

			</table>
		</section>

		<section class="flex flexrow just-content-sb margin-bottom-50">
			<div class="col l7 just-content-flex-start al-items-flex-end uppercase font-700">
				<p>Date d'échéance : 20/06/2020</p>
			</div>
			<?php function prixht ($facture){
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

				?>
			<div class="col l2 column al-items-flex-end just-content-flex-end uppercase">
				<p>Total HT</p>
				<p>TVA (20%)</p>
				<p class="font-size-20 font-700">Total TTC </p>
			</div>
			<div class="col l3 column al-items-flex-end just-content-flex-end margin-right-20 uppercase ">
				<p><?php echo $ht; ?> €</p>
				<p><?= (ttc(prixht($facture)) - prixht($facture)) ?> €</p>
				<p class="font-size-20 font-700"><?php echo $prixttc; ?> € </p>


			</div>
		</section>
		<p class="font-size-10 align-center">Conformément aux dispositions de l'article L.441-6 du code de commerce, tout retard de paiement entraîne le règlement de pénalités de retard au taux annuel de 14%.
		Aucun escompte ne sera accordé en cas de paiement anticipé. Les remises appliquées sont des remises commerciales appliquées à titre exceptionnel. Code commerce art D441-5 Indemnité forfaitaire frais de recouvrement 40 EUR.</p>
</div>
</main>
</body>
</html>