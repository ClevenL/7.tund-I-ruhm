<?php
	
	require("../../config.php");
	require("function.php");
	//var_dump();
	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);
	if (isset ($_SESSION["userId"])) {
		
		header("Location: data.php");
		exit();
	}
	//MUUTUJAD
	$signupUsernameError="";
	$username="";
	$signupUsername="";
	$signupEmailError="";
	$signupPasswordError="";
	$signupPassword2Error="";
	$loginEmail="";
	$loginEmailError="";
	$loginPasswordError="";
	$signupEmail ="";
	
	// kas e-post oli olemas
	if (isset($_POST["signupPassword"])){
		
		if (empty($_POST["signupPassword"])){
			
			$signupPasswordError="See vali on kohustuslik!";
			
				} else {
			
				if (strlen($_POST["signupPassword"]) <8) {
					$signupPasswordError="Parool peab olema vahemalt 8 tahemarki pikk";
				}
		}
	}
	
	if (isset($_POST["signupPassword2"])){
		
		if (empty($_POST["signupPassword2"])){
			
			$signupPasswordError="See vali on kohustuslik!";
			
				} else {
			
				if (($_POST["signupPassword"])!=($_POST["signupPassword2"]) ){
					$signupPassword2Error="Paroolid ei klapi!";
				}
		}
	}
	
	if (isset($_POST["signupEmail"])){
				
		if (empty($_POST["signupEmail"])){
					
			$signupEmailError="See vali on kohustuslik!";
			
		} else {
			$signupEmail =$_POST["signupEmail"];
			
		
	
		}
	}
	
	if (isset($_POST["signupUsername"])){
				
		if (empty($_POST["signupUsername"])){
					
			$signupUsernameError="See vali on kohustuslik!";
			
		} else {
			$signupUsername=$_POST["signupUsername"];
			
		
	
		}
	}
	
	if (isset($_POST["loginPassword"])){
		
		if (empty($_POST["loginPassword"])){
			
			$loginPasswordError="Sisestage siia oma parool, et sisse logida!";
			
				} else {
			
				if (strlen($_POST["loginPassword"]) <8) {
					$loginPasswordError="Parool peab olema vahemalt 8 tahemarki pikk";
				}
			
		}
	}
	if (isset($_POST["loginEmail"])){
				
		if (empty($_POST["loginEmail"])){
					
			$loginEmailError="Sisestage siia oma e-post, et sisse logida!";
		
			} else {
			$loginEmail=$_POST["loginEmail"];	
		}
	}
	
	
	
	//Kus tean et uhtegi viga ei olnud ja saan kasutaja andmed salvestada
	if ( isset($_POST["signupPassword"]) &&
		 isset($_POST["signupEmail"]) &&
		 isset($_POST["signupUsername"]) &&
		 empty($signupUsernameError) &&
		 empty($signupPassword2Error) &&
		 empty($signupEmailError) &&
		 empty($signupPasswordError) 
	   ) {
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		
		$signupEmail=cleanInput($signupEmail);
		$signupUsername=cleanInput($signupUsername);
		$password=cleanInput($password);
		
		
		$User->signUp($signupEmail, $signupUsername, $password);
		
		
	}
	
	$error = "";
	
	if( isset($_POST["loginEmail"]) && isset($_POST["loginPassword"]) && !empty($_POST["loginEmail"]) && !empty($_POST["loginPassword"])){
	
		$error = $User->login($_POST["loginEmail"], $_POST["loginPassword"]);
	}
?>



<!DOCTYPE html>
<html>

	

	<head>
		<title>Sisselogimise lehekülg</title>
	</head>
		<body style="background-color:bisque;">

			<h1>Logi sisse</h1>
		
			<form method="POST">
			
				<p style ="color:red;"><?=$error;?></p>
				
				<input name="loginEmail" type="email" placeholder="E-post" value="<?=$loginEmail;?>"> <?php echo $loginEmailError;?>
				
				<br><br>
				
				<input name="loginPassword" type="password" placeholder="Parool"> <?php echo $loginPasswordError;?>
				
				<br> <br>
				
				<input type="submit" value="Logi sisse">
				
			
			</form>
			
			<br><br>
			
			<h3>Kasutajat pole?</h3>
			<h1>Loo kasutaja</h1>
			
			<form method="POST">
			
				<label>Kasutajanimi</label>
				<br>
				<input name="signupUsername" type="username" value="<?=$signupUsername;?>"> <?php echo $signupUsernameError;?>
				<br><br>
			
				<label>E-post</label>
				<br>
				<input name="signupEmail" type="email" value="<?=$signupEmail;?>"> <?php echo $signupEmailError;?>
				<br><br>
				
				<label>Parool</label>
				<br>
				<input name="signupPassword" type="password"> <?php echo $signupPasswordError;?>
				<br> <br>
				
				<label>Parool uuesti</label>
				<br>
				<input name="signupPassword2" type="password"> <?php echo $signupPassword2Error;?>
				<br> <br>
				
				<h4>Vali oma sugu</h4>
				
				<input type="radio" name="gender" value="male" checked> Male
				<br>
				<input type="radio" name="gender" value="female"> Female
				<br>
				<input type="radio" name="gender" value="other"> Other
				<br><br>
				
				<input type="submit" value="Loo kasutaja">
				
				

				
			
			</form>

	</body>
</html>
