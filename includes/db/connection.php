<?php 
// dbc : mysqli ,, db: pdo
		include("config.php");
		$dbc=@new mysqli(HOST,USERNAME,PASSWORD,DBNAME);
		if($dbc->connect_error){
			die("Connection Failed, ".$dbc->connect_error);
		}
		$dbc->set_charset("utf8"); 
		// Connection To DataBase .. 
		// I need To Create Setup In This Projects At The End .. So User Name And Password Will Be Change .. 
		try
		{
			$arabic=[PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"];
			$db = new PDO ('mysql:host=' . HOST . ';dbname=' . DBNAME,USERNAME,PASSWORD,$arabic);
			$db -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
			exit;
		}

?>