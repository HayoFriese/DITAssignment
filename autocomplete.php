<?php
	include 'data_conn.php';
	///Request the keyword. if a value is returned, set it to that value, else return null.
	$keyword = isset($_REQUEST['term']) ? $_REQUEST['term']:null;
	//if the keyword is set:
	if(isset($keyword)){
		//connect to the Database using PDO (PHP Data Objects, an object oriented system);
		$db = new PDO( 'mysql:host=localhost;dbname=unn_w13020720', 'unn_w13020720', 'HIOMJV2R' );
		//create a query. :term is the object oriented request from the keyword text input, in the command version often displayed with a ?. Checks for similarity.
		$sqlQuery = "SELECT CDID AS value, CDTitle AS label FROM nmc_cd WHERE CDTitle LIKE :term ORDER BY value";
		//prepare a statement using the object oriented method
		$stmt = $db->prepare($sqlQuery);
		//execute the statement, processing each entry that is equivalent to $keyword 
		$stmt->execute(array(':term' => "%{$keyword}%"));
		//return all results to to the query
		$array = $stmt->fetchAll(PDO::FETCH_ASSOC);
		//display the content in JSON format
		header('Content-Type: application/json');
		//encode the array return value in JSON format.
		echo json_encode($array);
	}
?>