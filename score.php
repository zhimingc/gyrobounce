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

//Post 
if($_SERVER['REQUEST_METHOD'] == 'POST'){

	$name = $_POST['name'];
	$score = $_POST['score'];

	if (!$name || !$score){

	}

}
//Else return results
else{
	$myArray = array();
	if ($result = $conn->query("SELECT * FROM scores order by score desc")) {

	    while($row = $result->fetch_array(MYSQL_ASSOC)) {
	            $myArray[] = $row;
	    }
	    echo json_encode($myArray);
		}
	$result->close();
}
$conn->close();

?>