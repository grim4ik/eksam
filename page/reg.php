<?php 
	var_dump($_POST);
	var_dump(isset($_POST["signupEmail"]));
	
	
	require("../functions.php");
	
	// kui on sisseloginud siis suunan data lehele
	if (isset($_SESSION["userId"])) {
		header("Location: data.php");
		exit();
	}
	
	//var_dump($_GET);
	
	//echo "<br>";
	
	//var_dump($_POST);
	
	//MUUTUJAD
	$signupEmailError = "*";
	$signupEmail = "";
	
	//kas keegi vajutas nuppu ja see on olemas
	
	if (isset ($_POST["signupEmail"])) {
		
		//on olemas
		// kas epost on tuhi
		if (empty ($_POST["signupEmail"])) {
			
			// on tuhi
			$signupEmailError = "* Vali on kohustuslik!";
			
		} else {
			// email on olemas ja oige
			$signupEmail = $_POST["signupEmail"];
			
		}
		
	} 
	
	$signupLoginError = "*";
	$signupLogin = "";
	
	//kas keegi vajutas nuppu ja see on olemas
	
	if (isset ($_POST["signupLogin"])) {
		
		//on olemas
		// kas epost on tuhi
		if (empty ($_POST["signupLogin"])) {
			
			// on tuhi
			$signupLoginError = "* Vali on kohustuslik!";
			
		} else {
			// email on olemas ja oige
			$signupLogin = $_POST["signupLogin"];
			
		}
		
	}
	
	$signupNameError = "*";
	$signupName = "";
	
	//kas keegi vajutas nuppu ja see on olemas
	
	if (isset ($_POST["signupName"])) {
		
		//on olemas
		// kas epost on tuhi
		if (empty ($_POST["signupName"])) {
			
			// on tuhi
			$signupNameError = "* Vali on kohustuslik!";
			
		} else {
			// email on olemas ja oige
			$signupName = $_POST["signupName"];
			
		}
		
	}
	
	$signupSurnameError = "*";
	$signupSurname = "";
	
	//kas keegi vajutas nuppu ja see on olemas
	
	if (isset ($_POST["signupSurname"])) {
		
		//on olemas
		// kas epost on tuhi
		if (empty ($_POST["signupSurname"])) {
			
			// on tuhi
			$signupSurnameError = "* Vali on kohustuslik!";
			
		} else {
			// email on olemas ja oige
			$signupSurname = $_POST["signupSurname"];
			
		}
		
	}
	
	$signupPhoneError = "*";
	$signupPhone = "";
	
	//kas keegi vajutas nuppu ja see on olemas
	
	if (isset ($_POST["signupPhone"])) {
		
		//on olemas
		// kas epost on tuhi
		if (empty ($_POST["signupPhone"])) {
			
			// on tuhi
			$signupPhoneError = "* Vali on kohustuslik!";
			
		} else {
			// email on olemas ja oige
			$signupPhone = $_POST["signupPhone"];
			
		}
		
	}
	
	$signupPasswordError = "*";
	
	if (isset ($_POST["signupPassword"])) {
		
		if (empty ($_POST["signupPassword"])) {
			
			$signupPasswordError = "* Vali on kohustuslik!";
			
		} else {
			
			// parool ei olnud tuhi
			
			if ( strlen($_POST["signupPassword"]) < 8 ) {
				
				$signupPasswordError = "* Parool peab olema vahemalt 8 tahemarkki pikk!";
				
			}
			
		}
		
		/* GENDER */
		
		if (!isset ($_POST["gender"])) {
			
			//error
		}else {
			// annad vaartuse
		}
		
	}
	
	//vaikimisi vaartus
	$gender = "";
	
	if (isset ($_POST["gender"])) {
		if (empty ($_POST["gender"])) {
			$genderError = "* Vali on kohustuslik!";
		} else {
			$gender = $_POST["gender"];
		}
		
	} 
	
	
	
	
	if ( $signupEmailError == "*" AND
		 $signupLoginError == "*" &&
		 $signupPasswordError == "*" &&
		 $signupNameError == "*" &&
		 $signupSurnameError == "*" &&
		 $signupPhoneError == "*" &&
		 isset($_POST["signupEmail"]) &&
		 isset($_POST["signupLogin"]) &&
		 isset($_POST["signupPassword"]) &&
		 isset($_POST["signupName"]) &&
		 isset($_POST["signupSurname"]) &&
		 isset($_POST["signupPhone"]) 
	  ) {
		
		//vigu ei olnud, koik on olemas	
		echo "Salvestan...<br>";
		echo "email ".$signupEmail."<br>";
		echo "login ".$signupLogin."<br>";
		echo "nimi ".$signupName."<br>";
		echo "perekonnanimi ".$signupSurname."<br>";
		echo "telefoni number ".$signupPhone."<br>";
		echo "parool ".$_POST["signupPassword"]."<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		echo $password."<br>";
		
		$User->signup($signupEmail, $password, $signupLogin, $signupName, $signupSurname, $signupPhone);
		
		
	}
?>
<?php require("../header.php"); ?>

<div class="container"> 
	<div class="row">
		
		<div class="col-sm-4 col-sm-offset-2 col-md-3 col-md-offset-3">
		<h1>Loo kasutaja</h1>
		
		<form method="POST" >
			

			<input class="form-control" name="signupEmail" placeholder="E-post" type="email" value="<?=$signupEmail;?>"> <?php echo $signupEmailError; ?>
			
			<br>
			
			<input class="form-control" name="signupPassword" placeholder="Parool" type="password"> <?php echo $signupPasswordError; ?>
			
			<br>
			
			<input class="form-control" name="signupLogin" placeholder="Tankla nimi" type="login" value="<?=$signupLogin;?>"> <?php echo $signupLoginError; ?>
			
			<br>
			
			<input class="form-control" name="signupName" placeholder="Nimi" type="name"> <?php echo $signupNameError; ?>
			
			<br>
			
			<input class="form-control" name="signupSurname" placeholder="Perekonnanimi" type="name"> <?php echo $signupSurnameError; ?>
			
			<br>
			
			<input class="form-control" name="signupPhone" placeholder="Telefoni number" type="phone"> <?php echo $signupPhoneError; ?>
			
			<br>
					
			<input class="btn btn-primary btn-sm" type="submit" value="Loo kasutaja">
			<a class="btn btn-info" href="login.php"><-Tagasi</a>
		
		</form>
		</div>

	</body>
</html>
</div>
</div>

<?php require("../footer.php"); ?>