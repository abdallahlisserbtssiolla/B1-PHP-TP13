<?php

	session_start() ;
	
	$code = $_GET[ 'codeProduit' ] ;
		
	try {
		$bd = new PDO(
			'mysql:host=localhost;dbname=sanayabio_stocks' ,
			'sanayabio' ,
			'sb2021'
		);

		$sql = 'DELETE FROM Produit WHERE code = :code';
		$st = $bd->prepare($sql);

		$st->execute(array(':code' => $code));
		
		unset($bd);

		header('Location: ../vues/vue-stock.php');
	}
	catch(PDOException $e) {
		session_unset();
		session_destroy();
		header('Location: ../index.php?echec=0');
	}
?>
