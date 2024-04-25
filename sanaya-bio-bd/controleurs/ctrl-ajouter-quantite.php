<?php
	
	session_start() ;
	
	$code = $_GET[ 'codeProduit' ] ;
	$quantite = $_GET[ 'quantite' ] ;

	try {
		$bd = new PDO(
			'mysql:host=localhost;dbname=sanayabio_stocks' ,
			'sanayabio' ,
			'sb2021'
		);

		$sql_select = 'SELECT quantite FROM Produit WHERE code = :code';
		$st_select = $bd->prepare($sql_select);
		   
		$st_select->execute(array(':code' => $code));
		$result = $st_select->fetch(PDO::FETCH_ASSOC);
		$quantite_actuelle = $result['quantite'];

		$nouvelle_quantite = $quantite_actuelle + $quantite;

		$sql_update = 'UPDATE Produit SET quantite = :nouvelle_quantite WHERE code = :code';
		$st_update = $bd->prepare($sql_update);

		$st_update->execute(array(':nouvelle_quantite' => $nouvelle_quantite, ':code' => $code));
		
		unset($bd);
		
		header('Location: ../vues/vue-stock.php');
	}
	catch(PDOException $e) {

		session_unset() ;
		session_destroy() ;
		
		header('Location: ../index.php?echec=0');
	}	
		
	
?>
