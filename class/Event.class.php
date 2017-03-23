<?php
class Event {
    
    private $connection;
	
	function __construct($mysqli){
		$this->connection = $mysqli;
	}
	
		
	function saveEvent($tn_vanus, $tn_kirjeldus, $tn_nimi, $tn_kauplus, $tn_95, $tn_98, $tn_diisel) {
				
		$stmt = $this->connection->prepare("INSERT INTO tanklainfo (tn_vanus, tn_kirjeldus, tn_nimi, tn_kauplus, tn_95, tn_98, tn_diisel) VALUE (?, ?, ?, ?, ?, ?, ?)");
		echo $this->connection->error;
		
		$stmt->bind_param("issssss", $tn_vanus, $tn_kirjeldus, $tn_nimi, $tn_kauplus, $tn_95, $tn_98, $tn_diisel);
		
		if ( $stmt->execute() ) {
			echo "õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}
		
	}
	
	function getAllPeople($q, $sort, $order) {
		
		$allowedSort = ["id", "tn_vanus", "tn_kirjeldus", "tn_nimi", "tn_kauplus", "tn_95", "tn_98", "tn_diisel"];
		
		// sort ei kuulu lubatud tulpade sisse 
		if(!in_array($sort, $allowedSort)){
			$sort = "id";
		}
		
		$orderBy = "ASC";
		
		if($order == "DESC") {
			$orderBy = "DESC";
		}
		
		echo "Sorteerin: ".$sort." ".$orderBy." ";
		
		
		if ($q != "") {
			//otsin
			echo "otsin: ".$q;
			
			$stmt = $this->connection->prepare("
				SELECT id, tn_vanus, tn_kirjeldus, tn_nimi, tn_kauplus, tn_95, tn_98, tn_diisel
				FROM tanklainfo
				WHERE deleted IS NULL
				AND ( age LIKE ? OR color LIKE ? )
				ORDER BY $sort $orderBy
			");
			
			$searchWord = "%".$q."%";
			
			$stmt->bind_param("ss", $searchWord, $searchWord);
			
		} else {
			// ei otsi
			$stmt = $this->connection->prepare("
				SELECT id, tn_vanus, tn_kirjeldus, tn_nimi, tn_kauplus, tn_95, tn_98, tn_diisel
				FROM tanklainfo
				WHERE deleted IS NULL
				ORDER BY $sort $orderBy
			");
		}
		
		$stmt->bind_result($id, $tn_vanus, $tn_kirjeldus, $tn_nimi, $tn_kauplus, $tn_95, $tn_98, $tn_diisel);
		$stmt->execute();
		
		$results = array();
		
		// tsükli sisu tehakse nii mitu korda, mitu rida
		// SQL lausega tuleb
		while ($stmt->fetch()) {
			
			$human = new StdClass();
			$human->id = $id;
			$human->tn_vanus = $tn_vanus;
			$human->tn_kirjeldus = $tn_kirjeldus;
			$human->tn_nimi = $tn_nimi;
			$human->tn_kauplus = $tn_kauplus;
			$human->tn_95 = $tn_95;
			$human->tn_98 = $tn_98;
			$human->tn_diisel = $tn_diisel;
			
			
			
			//echo $color."<br>";
			array_push($results, $human);
			
		}
		
		return $results;
		
	}
	
	
	function getSinglePerosonData($edit_id){
    
		
		$stmt = $this->connection->prepare("SELECT tn_vanus, tn_kirjeldus, tn_nimi, tn_kauplus, tn_95, tn_98, tn_diisel FROM tanklainfo WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($tn_vanus, $tn_kirjeldus, $tn_nimi, $tn_kauplus, $tn_95, $tn_98, $tn_diisel);
		$stmt->execute();
		
		//tekitan objekti
		$p = new Stdclass();
		
		//saime ühe rea andmeid
		if($stmt->fetch()){
			// saan siin alles kasutada bind_result muutujaid
			$p->tn_vanus = $tn_vanus;
			$p->tn_kirjeldus = $tn_kirjeldus;
			$p->tn_nimi = $tn_nimi;
			$p->tn_kauplus = $tn_kauplus;
			$p->tn_95 = $tn_95;
			$p->tn_98 = $tn_98;
			$p->tn_diisel = $tn_diisel;
			
			
		}else{
			// ei saanud rida andmeid kätte
			// sellist id'd ei ole olemas
			// see rida võib olla kustutatud
			header("Location: data.php");
			exit();
		}
		
		$stmt->close();
		
		return $p;
		
	}
	function updatePerson($id, $tn_vanus, $tn_kirjeldus, $tn_nimi, $tn_kauplus, $tn_95, $tn_98, $tn_diisel){
    			
		$stmt = $this->connection->prepare("UPDATE tanklainfo SET tn_vanus=?, tn_kirjeldus=?, tn_nimi=?, tn_kauplus=?, tn_95=?, tn_98=?, tn_diisel=? WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("isissss",$tn_vanus, $tn_kirjeldus, $tn_nimi, $tn_kauplus, $tn_95, $tn_98, $tn_diisel, $id);
		
		// kas õnnestus salvestada
		if($stmt->execute()){
			// õnnestus
			echo "salvestus õnnestus!";
		}
		
		$stmt->close();
		
	}
	
	function deletePerson($id){
    	
        $database = "if16_kirikotk_4";		
		
		$stmt = $this->connection->prepare("
		UPDATE tanklainfo SET deleted=NOW()
		WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i",$id);
		
		// kas õnnestus salvestada
		if($stmt->execute()){
			// õnnestus
			echo "salvestus õnnestus!";
		}
		
		$stmt->close();
		
	}
	
	
}
?>