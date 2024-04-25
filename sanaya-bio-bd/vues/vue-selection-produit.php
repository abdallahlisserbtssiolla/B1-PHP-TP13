<?php session_start() ; ?>


<?php

	$produits = array() ;

	try {
		
		// La variable $produits (tableau de tableaux associatifs) doit-être valorisée avec les valeurs de la table 
		// Produit de la base de données.
		// Chaque élément de la variable $produits est un tableau associatif qui correspond à un produit et dont les 
		// deux éléments ont pour clés 'code' et 'libelle'.
		
		$bd = new PDO(
						'mysql:host=localhost;dbname=sanayabio_stocks' ,
						'sanayabio' ,
						'sb2021'
			) ;
			
		$sql = 'select code , libelle '
			 . 'from Produit ' ;
			 
		$st = $bd -> prepare( $sql ) ;
		
		$st -> execute() ;
		$produits = $st -> fetchall() ;
		
	}
	catch( PDOException $e ){
	
		session_unset() ;
		session_destroy() ;
	
		header( 'Location: ../index.php?echec=0' ) ;
	}


?>


<!DOCTYPE html>
<html lang="fr">

	<head>
		<meta charset="utf-8">
		<title>Sanaya Bio - Gestion des Stocks</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

	</head>

	<body>
		
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<div class="container-fluid">
				<a class="navbar-brand" href="#">Sanaya Bio</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="nav navbar-nav me-auto mb-2 mb-lg-0">
						<li class="nav-item">
							<a class="nav-link" href="../vues/vue-stock.php">Stock</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="../vues/vue-nouveau-produit.php">Nouveau</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="../vues/vue-selection-produit.php">Retrait</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="../vues/vue-entree-quantite.php">Entrée</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="../vues/vue-sortie-quantite.php">Sortie</a>
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="nav-item">
							<a class="nav-link" href="#"><?php echo $_SESSION[ 'prenom' ] . ' ' . $_SESSION[ 'nom' ]  ?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="../controleurs/ctrl-deconnexion.php">se déconnecte...</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		
		<div class="container-fluid">
		
			<h4 class="alert alert-primary" role="alert">
				Produit à retirer de la vente
			</h4>
			
			<div class="row">
				
				<div class="col-lg-4"></div>
				
				<div class="col-lg-4">
			
					<form action="../controleurs/ctrl-supprimer-produit.php" method="GET">
					
						<div class="mb-3">
							<label class="col-sm-2 col-form-label">Produit :</label>
							<select class="form-select" name="codeProduit">
							
								<?php foreach( $produits as $unProduit ){ ?>
									<option value="<?php echo $unProduit[ 'code' ] ?>"><?php echo $unProduit[ 'code' ] . ' : ' . $unProduit[ 'libelle' ] ?></option>
								<?php } ?>
							
							</select>
						</div>
						
						<div class="mb-3">
							<button class="btn btn-primary" type="submit">Supprimer</button>
							<button class="btn btn-primary" type="reset">Annuler</button>
						</div>
					
					</form>
				
				</div>
				
				<div class="col-lg-4"></div>
				
			</div>
		
		</div>
		
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

	</body>

</html>
