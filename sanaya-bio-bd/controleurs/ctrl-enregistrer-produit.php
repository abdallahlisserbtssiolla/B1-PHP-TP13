<?php

	session_start() ;
	
	$resOp = TRUE ;
	
	$code = $_GET[ 'code' ] ;
	$libelle = $_GET[ 'libelle' ] ;
	$quantite = $_GET[ 'quantite' ] ;
	
	try {
		$bd = new PDO(
			'mysql:host=localhost;dbname=sanayabio_stocks' ,
			'sanayabio' ,
			'sb2021'
		);

		$sql_select = 'SELECT code FROM Produit WHERE code = :code';
		$st_select = $bd->prepare($sql_select);
		$st_select->execute(array(':code' => $code));
		$result = $st_select->fetch(PDO::FETCH_ASSOC);

		if ($result) {
			$resOp = FALSE;
		} else {
			$sql_insert = 'INSERT INTO Produit (code, libelle, quantite) VALUES (:code, :libelle, :quantite)';
			$st_insert = $bd->prepare($sql_insert);
			$st_insert->execute(array(':code' => $code, ':libelle' => $libelle, ':quantite' => $quantite));
		}

		unset($bd);

		if( $resOp == TRUE ){
			header( 'Location: ../vues/vue-nouveau-produit.php?code=' . $code ) ;
		}
		else {
			header( 'Location: ../vues/vue-nouveau-produit.php?code=NOK&libelle=' . $libelle . '&quantite=' . $quantite ) ;
		}
	}
	catch( PDOException $e ){
		session_unset() ;
		session_destroy() ;
		header( 'Location: ../index.php?echec=0' ) ;
	}
	
?>
