<?php


// siia tuleb ainult login ja signup
// ulejaanud klassid Thread.class.php nt, sinna k6ik sellega seonduv
// huvidega seonduv koik Interest.class.php 

// klassis koik funktsioonide nimed ilusaks, parast hea vaadata jne hea kraam



class User {
	
	private $connection;
	
	function __construct($mysqli){
		
		$this->connection=$mysqli;
		
	}
	
	function getAllPeople () {
		
		
		$stmt = $this->connection->prepare("SELECT id, sugu, url, color, created FROM trend WHERE deleted IS NULL");
		
		echo $this->connection->error;
		
		$stmt->bind_result($id, $sugu, $url, $color, $created);
		$stmt->execute();
		
		$result = array();
		
		while ($stmt->fetch()) {
			
			$person = new StdClass();
			$person->id=$id;
			$person->sugu=$sugu;
			$person->url=$url;
			$person->color=$color;
			$person->created=$created;
			
			array_push($result, $person);
			
		}
		
		$stmt->close();
		
		return $result;
	}
	function trend ($sugu, $color, $url) {
		
		
		$stmt = $this->connection->prepare("INSERT INTO trend (sugu, url, color) VALUES (?,?,?)");
		
		$stmt->bind_param("sss", $sugu, $color, $url);
		
		if ($stmt->execute()) {
			
			echo "Edukalt postitatud! <br>";
		} else {
			echo "ERROR ".$stmt->error;
		}
	}
	function login ($email, $password) {
		
		$error = "";
		
		$stmt = $this->connection->prepare("
		
			SELECT id, email, username, password, created
			FROM user_sample
			WHERE email = ?
		
		");
		
		$stmt->bind_param("s", $email);
		
		$stmt->bind_result($id, $emailFromDb, $usernameFromDb, $passwordFromDb, $created);
		$stmt->execute();
		
		if($stmt->fetch()){
			
			$hash = hash("sha512", $password);
			if($hash == $passwordFromDb) {
				echo "kasutaja ".$id." logis sisse";
				
				$_SESSION["userId"] = $id;
				$_SESSION["email"] = $emailFromDb;
				$_SESSION["username"] = $usernameFromDb;
				
				
				header("Location: data.php");
				exit();
				
			} else {
				$error = "Parool vale, proovi uuesti!";
			}
			
		} else {	
			
			$error = "Sellise ".$email." emailiga kasutajat ei ole salvestatud";
		}
		
		return $error;
		
	}
	function signup ($email, $username, $password) {
		
		
		$stmt = $this->connection->prepare("INSERT INTO user_sample (email, username, password) VALUES (?,?,?)");

		$stmt->bind_param("sss", $email, $username, $password);
		
		if ($stmt->execute()) {
			
			echo "Salvestamine 6nnestus!";
		} else {
			echo "ERROR ".$stmt->error;
		}
	
	}
}



?>