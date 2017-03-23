<?php 
	var_dump($_POST);
	var_dump(isset($_POST["signupEmail"]));
	
	
	require("../functions.php");
	
	// kui on sisseloginud siis suunan data lehele
	if (isset($_SESSION["userId"])) {
		header("Location: data.php");
		exit();
	}
	
	$notice = "";
	//kas kasutaja tahab sisse logida
	if ( isset($_POST["loginEmail"]) && 
		 isset($_POST["loginPassword"]) && 
		 !empty($_POST["loginEmail"]) &&
		 !empty($_POST["loginPassword"]) 
	) {
		
		$notice = $User->login($_POST["loginEmail"], $_POST["loginPassword"]);
		
	}
	
	
		// otsib
	if (isset($_GET["q"])) {
		
		$q = $_GET["q"];
	
	} else {
		//ei otsi
		$q = "";
	}
	
	//vaikimisi, kui keegi mingit linki ei vajuta
	$sort = "id";
	$order = "ASC";
	
	if (isset($_GET["sort"]) && isset($_GET["order"])) {
		$sort = $_GET["sort"];
		$order = $_GET["order"];
	}
	
	$people = $Event->getAllPeople($q, $sort, $order);
	
	
?>

<h1>Tanklad</h1>

<?php require("../header.php"); ?>

<div class="container"> 
	<div class="row">
	
		<div class="col-sm-4 col-md-3">

		<h1>Logi sisse</h1>
		<p style="color:red;"><?=$notice;?></p>
		<form method="POST" >
			
			<div class="form-group">
				<input class="form-control" placeholder="E-post" name="loginEmail" type="email">
			</div>
			
			<div class="form-group">
				<input class="form-control" name="loginPassword" placeholder="Parool" type="password">
			</div>
			
			
			<input class="btn btn-primary btn-sm hidden-xs" type="submit" value="Logi sisse 1">
			<input class="btn btn-primary btn-sm btn-block visible-xs-block" type="submit" value="Logi sisse 2">
			<a class="btn btn-primary btn-sm hidden-xs" href="reg.php">Loo kasutaja</a>
			<a class="btn btn-primary btn-sm btn-block visible-xs-block" href="reg.php">Loo kasutaja</a>
		
		</form>
		</div>
		
		<div class="col-sm-4 col-sm-offset-2 col-md-3 col-md-offset-3">
		
		

	</body>
</html>
</div>
</div>
<h2>Tanklad</h2>

<?php 
	
	$html = "<table class='table table-striped table-condensed'>";
	
		$html .= "<tr>";
		
			$orderId = "ASC";
			$arr="&darr;";
			if (isset($_GET["order"]) && 
				$_GET["order"] == "ASC" &&
				$_GET["sort"] == "id" ) {
					
				$orderId = "DESC";
				$arr="&uarr;";
			}
		
			$html .= "<th>
						<a href='?q=".$q."&sort=id&order=".$orderId."'>
							ID ".$arr."
						</a>
					 </th>";
					 
			
			$ordertn_kauplus = "ASC";
			if (isset($_GET["order"]) && 
				$_GET["order"] == "ASC" &&
				$_GET["sort"] == "tn_kauplus" ) {
					
				$ordertn_kauplus = "DESC";
			}
		
			$html .= "<th>
						<a href='?q=".$q."&sort=tn_kauplus&order=".$ordertn_kauplus."'>
							Kauplus
						</a>
					 </th>";	 
			
			$ordertn_nimi = "ASC";
			if (isset($_GET["order"]) && 
				$_GET["order"] == "ASC" &&
				$_GET["sort"] == "tn_nimi" ) {
					
				$ordertn_nimi = "DESC";
			}
		
			$html .= "<th>
						<a href='?q=".$q."&sort=tn_nimi&order=".$ordertn_nimi."'>
							Tankla nimi
						</a>
					 </th>";
			
			
			$ordertn_vanus = "ASC";
			if (isset($_GET["order"]) && 
				$_GET["order"] == "ASC" &&
				$_GET["sort"] == "tn_vanus" ) {
					
				$ordertn_vanus = "DESC";
			}
		
			$html .= "<th>
						<a href='?q=".$q."&sort=tn_vanus&order=".$ordertn_vanus."'>
							Tankla vanus
						</a>
					 </th>";
					 
			$ordertn_kirjeldus = "ASC";
			if (isset($_GET["order"]) && 
				$_GET["order"] == "ASC" &&
				$_GET["sort"] == "tn_kirjeldus" ) {
					
				$ordertn_kirjeldus = "DESC";
			}
		
			$html .= "<th>
						<a href='?q=".$q."&sort=tn_kirjeldus&order=".$ordertn_kirjeldus."'>
							Tankla aadress
						</a>
					 </th>";
					 
			
			$ordertn_95 = "ASC";
			if (isset($_GET["order"]) && 
				$_GET["order"] == "ASC" &&
				$_GET["sort"] == "tn_95" ) {
					
				$ordertn_95 = "DESC";
			}
		
			$html .= "<th>
						<a href='?q=".$q."&sort=tn_95&order=".$ordertn_95."'>
							Hind 95
						</a>
					 </th>";
					 
			$ordertn_98 = "ASC";
			if (isset($_GET["order"]) && 
				$_GET["order"] == "ASC" &&
				$_GET["sort"] == "tn_98" ) {
					
				$ordertn_98 = "DESC";
			}
		
			$html .= "<th>
						<a href='?q=".$q."&sort=tn_98&order=".$ordertn_98."'>
							Hind 98
						</a>
					 </th>";
					 
			$ordertn_diisel = "ASC";
			if (isset($_GET["order"]) && 
				$_GET["order"] == "ASC" &&
				$_GET["sort"] == "tn_diisel" ) {
					
				$ordertn_diisel = "DESC";
			}
		
			$html .= "<th>
						<a href='?q=".$q."&sort=tn_98&order=".$ordertn_diisel."'>
							Hind Diisel
						</a>
					 </th>";
					 
		
		
		//iga liikme kohta massiivis
		foreach ($people as $p) {
			
			$html .= "<tr>";
				$html .= "<td>".$p->id."</td>";
				$html .= "<td>".$p->tn_kauplus."</td>";
				$html .= "<td>".$p->tn_nimi."</td>";
				$html .= "<td>".$p->tn_vanus."</td>";
				$html .= "<td>".$p->tn_kirjeldus."</td>";
				$html .= "<td>".$p->tn_95."</td>";
				$html .= "<td>".$p->tn_98."</td>";
				$html .= "<td>".$p->tn_diisel."</td>";
			$html .= "</tr>";
		
		}
		
	$html .= "</table>";
	
	echo $html;
?>


<?php require("../footer.php"); ?>