<?php 
	//ühendan sessiooniga
	require("../functions.php");
	
	//kui ei ole sisseloginud, suunan login lehele
	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
	
	//kas aadressireal on logout
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login.php");
		exit();
		
	}
	
	
	if ( isset($_POST["tn_vanus"]) && 
		 isset($_POST["tn_kirjeldus"]) && 
		 isset($_POST["tn_nimi"]) && 
		 isset($_POST["tn_kauplus"]) &&
		 isset($_POST["tn_95"]) && 
		 isset($_POST["tn_98"]) &&
		 isset($_POST["tn_diisel"]) && 		 
		 !empty($_POST["tn_vanus"]) &&
		 !empty($_POST["tn_kirjeldus"]) &&
		 !empty($_POST["tn_nimi"]) &&
		 !empty($_POST["tn_kauplus"]) &&
		 !empty($_POST["tn_95"]) &&
		 !empty($_POST["tn_98"]) &&
		 !empty($_POST["tn_diisel"]) 
	) {
		
		
		$tn_kirjeldus = $Helper->cleanInput($_POST["tn_kirjeldus"]);
		$tn_nimi = $Helper->cleanInput($_POST["tn_nimi"]);
		$tn_kauplus = $Helper->cleanInput($_POST["tn_kauplus"]);
		$tn_95 = $Helper->cleanInput($_POST["tn_95"]);
		$tn_98 = $Helper->cleanInput($_POST["tn_98"]);
		$tn_diisel = $Helper->cleanInput($_POST["tn_diisel"]);
		
		$Event->saveEvent($Helper->cleanInput($_POST["tn_vanus"]), $tn_kirjeldus, $tn_nimi, $tn_kauplus, $tn_95, $tn_98, $tn_diisel);
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
	
	
	echo "<pre>";
	var_dump($people[0]);
	echo "</pre>";
	
?>

<?php require("../header.php"); ?>
<h1>Data</h1>

<?php echo $_SESSION["userEmail"];?>

<?=$_SESSION["userEmail"];?>

<p>
	Tere tulemast <?=$_SESSION["userEmail"];?></a>!
	<a href="?logout=1">logi välja</a>
</p>

<div class="col-sm-4 col-md-3">
<h2>Salvesta sündmus</h2>
<form method="POST" >
	
	<label>Kauplus</label><br>
   <input type="radio" name="tn_kauplus" value="Olemas"> Olemas<Br>
   <input type="radio" name="tn_kauplus" value="Ei ole"> Ei ole</input>
		
	<br><br>
	
	<label>Tankla nimi</label><br>
	<input class="form-control" name="tn_nimi" type="text">
	<br>
	
	<label>Tankla vanus</label><br>
	<input class="form-control" name="tn_vanus" type="text">
	
	<br>
	<label>Tankla adress</label><br>
	<textarea rows="3" class="form-control" name="tn_kirjeldus" type="text"></textarea>
	
	<br>
	<label>Hind 95</label><br>
	<input class="form-control" name="tn_95" type="text">
	
    <br>
	<label>Hind 98</label><br>
	<input class="form-control" name="tn_98" type="text">
	
    <br>
	<label>Hind Diisel</label><br>
	<input class="form-control" name="tn_diisel" type="text">
	
	
	<br><br>
	
	<input class="btn btn-primary btn-sm hidden-xs" type="submit" value="Salvesta">

</form>
</div>

<div class="col-sm-4 col-md-3">

<form>
</form>
</div>

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
					 
			$html .= "<th>Edit</th>";
		$html .= "</tr>";
		
		
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
                $html .= "<td><a class='btn btn-default btn xc' href='edit.php?id=".$p->id."'>
				<span class='glyphicon glyphicon-pencil'></span> Muuda
				</a>
				</td>";
			$html .= "</tr>";
		
		}
		
	$html .= "</table>";
	
	echo $html;
?>


<?php require("../footer.php"); ?>


