<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

//DB Credentials
$server = "127.0.0.1";
$username = "root";
$password = "password";
$db = "monsterkitchen";
$secret="sdhfiuaef89shdf";

if($_GET["secret"] != $secret && $_POST["secret"] != $secret){
	echo "no secret sorry";
	exit;
}

$conn = new mysqli($server, $username, $password, $db);

if ($conn->query(
	"CREATE TABLE IF NOT EXISTS $db.scores(
	  	id int(11) NOT NULL auto_increment,   
	 	name VARCHAR(32) NOT NULL,
	 	score int(11) NOT NULL,
	 	PRIMARY KEY (id)
	)"
)==true){
// echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// echo "Starting";
//Post 
header('Content-Type: application/json');
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	// echo "post";
	$name = $_POST['name'];
	$score = $_POST['score'];
	if ($score>='999999'){
		echo "{status: 'error', error: 'STOP CHEATING'}";
	}
	else if ($name && $score){
		// $result = $conn->query("SELECT * FROM scores order by score desc")
		$sql = "INSERT INTO scores (name, score) VALUES ('$name', '$score')";
		// echo $sql;
		if ($conn->query($sql) === TRUE) {
		    // echo "{status:'ok', name: '$name', score: '$score'}";
		} else {
		    echo "{status: 'error', error: '$conn->error'}";
		}
	}
}
//Else return results
// else{
	// echo "get";
	$myArray = array();
	if ($result = $conn->query("SELECT name, max(score) as bestscore FROM scores group by name order by bestscore desc limit 10")) {

	    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
	        $myArray[] = $row;
	    }
	    echo json_encode($myArray);
		}
// }

?>
