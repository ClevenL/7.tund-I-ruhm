<?php
	//edit.php
	require("function.php");
	
	//kas kasutaja uuendab andmeid
	if(isset($_POST["update"])){
		
		updateThread(cleanInput($_POST["id"]), cleanInput($_POST["sugu"]),cleanInput($_POST["url"]), cleanInput($_POST["color"]));
		
		//header("Location: edit.php?id=".$_POST["id"]."&success=true");
        //exit();	
		
	}
	
	if (isset($_GET["delete"])) {
		
		deleteThread(cleanInput($_GET["id"]));
		header("Location: data.php");
		exit();
		
	}
	//if (isset($_GET["success"])) {
		
		//updateThread(cleanInput($_POST["id"]), cleanInput($_POST["sugu"]), cleanInput($_POST["url"]), cleanInput($_POST["color"]));
		
		//header("Location: data.php");
		//exit();
	//
	
	//saadan kaasa id
	$t = getSinglePeopleData($_GET["id"]);
	
	
?>
<br><br>
<a href="data.php"> tagasi </a>

<h2>Muuda kirjet</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?=$_GET["id"];?>" > 
  	<label for="sugu" >Threadi pealkiri</label><br>
	<input id="sugu" name="sugu" type="text" value="<?php echo $t->sugu;?>" ><br><br>
	<label for="url" >Url</label><br>
	<input id="url" name="url" type="text" value="<?=$t->url;?>"><br><br>
  	<label for="color" >Sisu</label><br>
	<input id="color" name="color" type="text" value="<?=$t->color;?>"><br><br>
  	
	<input type="submit" name="update" value="Salvesta">
  </form>
  
  
  <br>
  <br>
  <a href="?id=<?=$_GET["id"];?>&delete=true">Kustuta</a>