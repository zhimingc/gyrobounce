<?php
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$conn = new mysqli($server, $username, $password, $db);

$conn->query(
	"CREATE TABLE IF NOT EXISTS scores(
	  	id int(11) NOT NULL auto_increment,   
	 	name VARCHAR(16) NOT NULL,
	 	score int(11) NOT NULL
	)"
);
echo "Starting";
//Post 
header('Content-Type: application/json');
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	echo "post";
	$name = $_POST['name'];
	$score = $_POST['score'];
	if ($name && $score){
		// $result = $conn->query("SELECT * FROM scores order by score desc")
		$sql = "INSERT INTO scores (name, score) VALUES ('$name', '$score')";
		echo $sql;
		// if ($conn->query($sql) === TRUE) {
		//     echo "{status:'ok', name: '$name', score: '$score'}";
		// } else {
		//     echo "{status: 'error', error: '$sql - $conn->error'}";
		// }
	}
}
//Else return results
else{	
	echo "get";
	$myArray = array();
	if ($result = $conn->query("SELECT * FROM scores order by score desc")) {

	    while($row = $result->fetch_array(MYSQL_ASSOC)) {
	            $myArray[] = $row;
	    }
	    echo json_encode($myArray);
		}
}

?>