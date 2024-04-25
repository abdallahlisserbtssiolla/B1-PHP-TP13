<?php
	
	$login = $_GET[ 'login' ] ;
	$mdp = $_GET[ 'mdp' ] ;
	
	try {

		$bd = new PDO(
						'mysql:host=localhost;dbname=sanayabio_stocks' ,
						'sanayabio' ,
						'sb2021'
			) ;
			
		$sql = 'select numero , nom , prenom '
			 . 'from Compte '
			 . 'where login = :login '
			 . 'and mdp = :mdp' ;
			 
		$st = $bd -> prepare( $sql ) ;
		
		$st -> execute( array( 
								':login' => $login ,
								':mdp' => $mdp 
						) 
					) ;
		$resultat = $st -> fetchall() ;
			
		unset( $bd ) ;
		
		if( count( $resultat ) == 1 ) {
			session_start() ;
			$_SESSION[ 'numero' ] = $resultat[0]['numero'] ;
			$_SESSION[ 'nom' ] = $resultat[0]['nom'] ;
			$_SESSION[ 'prenom' ] = $resultat[0]['prenom'] ;
			
			$_SESSION[ 'login' ] = $login ;
			
			header( 'Location: ../vues/vue-stock.php' ) ;
		}
		else {
			header( 'Location: ../index.php?echec=1&login=' . $login ) ;
		}
	}
	catch( PDOException $e ){
		
		header( 'Location: ../index.php?echec=0' ) ;
	}

?>
