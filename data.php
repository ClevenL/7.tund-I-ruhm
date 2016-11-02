<?php
	//katsetus
	require("function.php");
	require("../../config.php");
	
	$trendColor="";
	$trendGender="";
	
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login.php");
		exit();
	}
	
	if (!isset($_SESSION["userId"])) {
		
		
		
		header("Location: login.php");
		exit();
	}
	
	if ( isset($_POST["sugu"]) &&
		 isset($_POST["url"]) &&
		 isset($_POST["color"]) &&
		 !empty($_POST["sugu"]) &&
		 !empty($_POST["url"]) &&
		 !empty($_POST["color"])
	   ) {
		
		$User->trend(cleanInput($_POST["sugu"]),cleanInput($_POST["url"]),cleanInput($_POST["color"]));
		
	}
	
	
	$database = "if16_clevenl";
		//uhendus
	$mysqli = new mysqli($serverHost,$serverUsername,$serverPassword,$database);
		
	$stmt = $mysqli->prepare("INSERT INTO trend (sugu, url, color) VALUES (?,?,?)");
		
		//asendan kusimargi vaartustega
		//iga muutuja kohta 1 taht, mis tuupi muutuja on
		// s - string
		// i - integer
		// d - double/float
	$stmt->bind_param("sss", $sugu, $url, $color);
	
	
	$people=$User->getAllPeople();
	
	//echo "<pre>";
	//var_dump($people);
	//echo "</pre>";


?>



<h1>Esileht</h1>
<p>

	Tere tulemast <a href="user.php"><?=$_SESSION["username"];?>!</a>! Nuudsest on sinu nimi juhuslikult valituna Gaylord.
	<br>
	Kui sulle see ei meeldi, siis palun lahku! 
	<a href="?logout=1">Logi valja</a>

</p>




<!DOCTYPE html>
<html>
	
	<body style="background-color:bisque;">
	
		<h1>Uldine paneel</h1>
		<h2>Tekita thread</h2>
			
			
			<form method="POST">
			
				<label>Threadi pealkiri</label>
				<br>
				<input name="sugu" type="text">
				<br><br>
				
				<label>Pildi URL</label>
				<br>
				<input name="url" type="text">
				<br><br>
			
				<label>Sisu</label>
				<br>
				<textarea rows="5" cols="40" name="color">
				
			
				</textarea>
				<br><br>
				<input type="submit" value="Postita">
				
			</form>
			
		
	
	</body>
</html>

<h2></h2>
<?php
	foreach($people as $p) {
		
		echo 	"<h2>$p->sugu</h2>
				<br><br>
				
				<img src=' ".$p->url." '>
				
				
				<br><br>
				$p->color"
				;
	}
	
	
?>

<h2>Threadid</h2>
<?php 
	
	$html = "<table>";
	
	$html .= "<tr>";
		$html .= "<th>id</th>";
		$html .= "<th>sugu</th>";
		$html .= "<th>url</th>";
		$html .= "<th>color</th>";
	$html .= "</tr>";
	
	//iga liikme kohta massiivis
	foreach($people as $p){
		// iga auto on $c
		//echo $c->plate."<br>";
		
		$html .= "<tr>";
			$html .= "<td>".$p->id."</td>";
			$html .= "<td>".$p->sugu."</td>";
			$html .= "<td>".$p->url."</td>";
			$html .= "<td>".$p->color."</td>";
            $html .= "<td><a href='edit.php?id=".$p->id."'>edit.php</a></td>";
		$html .= "</tr>";
	}
	
	$html .= "</table>";
	
	echo $html;
	
	
	$listHtml = "<br><br>";
	
	foreach($people as $p){
		
		
		$listHtml .= "<h1>".$p->sugu."</h1>";
		$listHtml .= "<p>".$p->url."</p>";
		$listHtml .= "<p>".$p->color."</p>";
	}
	
	echo $listHtml;
	
	
	
?>