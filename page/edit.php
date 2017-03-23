<?php
	//edit.php
	require("../functions.php");
	
	if(isset($_GET["delete"]) && isset($_GET["id"])) {
		// kustutan
		
		$Event->deletePerson($Helper->cleanInput($_GET["id"]));
		header("Location: data.php");
		exit();
	}
	
	
	//kas kasutaja uuendab andmeid
	if(isset($_POST["update"])){
		
		$Event->updatePerson(cleanInput($_POST["id"]), $Helper->cleanInput($_POST["tn_nimi"]), $Helper->cleanInput($_POST["tn_vanus"]), $Helper->cleanInput($_POST["tn_kirjeldus"]), $Helper->cleanInput($_POST["tn_95"]), $Helper->cleanInput($_POST["tn_98"]), $Helper->cleanInput($_POST["tn_diisel"]));
		
		header("Location: edit.php?id=".$_POST["id"]."&success=true");
        exit();	
		
	}
	
	//saadan kaasa id
	$p = $Event->getSinglePerosonData($_GET["id"]);
	var_dump($p);
	
?>
<?php require("../header.php"); ?>
<br><br>

<div class="col-sm-4 col-md-3">
<a href="data.php"> tagasi </a>
<h2>Muuda kirjet</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?=$_GET["id"];?>" > 
	<label for="tn_nimi" >Tankla nimi</label><br>
	<input class="form-control" id="tn_nimi" name="name" type="text" value="<?php echo $p->tn_nimi;?>" ><br><br>
  	<label for="tn_vanus" >Tankla vanus</label><br>
	<input class="form-control" id="tn_vanus" name="age" type="text" value="<?php echo $p->tn_vanus;?>" ><br><br>
	<label for="tn_kirjeldus" >Tankla adress</label><br>
	<input class="form-control" id="tn_kirjeldus" name="text" type="text" value="<?php echo $p->tn_kirjeldus;?>" ><br><br>
	<label for="tn_95" >Hind 95</label><br>
	<input class="form-control" id="tn_95" name="text" type="text" value="<?php echo $p->tn_95;?>" ><br><br>
    <label for="tn_98" >Hind 98</label><br>
	<input class="form-control" id="tn_98" name="text" type="text" value="<?php echo $p->tn_98;?>" ><br><br>
	<label for="tn_98" >Hind Diisel</label><br>
	<input class="form-control" id="tn_diisel" name="text" type="text" value="<?php echo $p->tn_diisel;?>" ><br><br>
  	
	<input class="btn btn-primary btn-sm hidden-xs" type="submit" name="update" value="Salvesta">
	<a class="btn btn-primary btn-sm hidden-xs" href="?id=<?=$_GET["id"];?>&delete=true">Kustuta</a>
  </form>

  </div>
  
<?php require("../footer.php"); ?>