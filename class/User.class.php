<?php 

class User {
	
	private $connection;
	
	//käivitatakse siis kui on new User(see jõuab siia)
	function __construct($mysqli){
		//this viitab sellele klassile ja selle klassi mutujale
		$this->connection = $mysqli;
	}
	
	/* KÕIK FUNKTSIOONID*/
	
		function login($email, $password) {
		
		$notice = "";
		
		$stmt = $this->connection->prepare("
			SELECT id, email, password, created
			FROM tankla_users
			WHERE email = ?
		");
		
		echo $this->connection->error;
		
		//asendan küsimärgi
		$stmt->bind_param("s", $email);
		
		//rea kohta tulba väärtus
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		
		$stmt->execute();
		
		//ainult SELECT'i puhul
		if($stmt->fetch()) {
			// oli olemas, rida käes
			//kasutaja sisestas sisselogimiseks
			$hash = hash("sha512", $password);
			
			if ($hash == $passwordFromDb) {
				echo "Kasutaja $id logis sisse";
				
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				//echo "ERROR";
				
				header("Location: data.php");
				exit();
				
			} else {
				$notice = "parool vale";
			}
			
			
		} else {
			
			//ei olnud ühtegi rida
			$notice = "Sellise emailiga ".$email." kasutajat ei ole olemas";
		}
		
		
		$stmt->close();
		
		return $notice;
		

	}
	
		function signup($email, $password, $tanklanimi, $name, $surname, $phone) {
	
		
		$stmt = $this->connection->prepare("INSERT INTO tankla_users (email, password, tanklanimi, name, surname, phone) VALUE (?, ?, ?, ?, ?, ?)");
		echo $this->connection->error;
		
		$stmt->bind_param("ssssss", $email, $password, $tanklanimi, $name, $surname, $phone);
		
		if ( $stmt->execute() ) {
			echo "õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}
		
	}
	
}


?>