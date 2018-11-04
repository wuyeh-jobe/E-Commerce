
<?php

header("Content-type: application/json; charset=UTF-8");
$search_term = $_POST["x"];
$obj = json_decode($_POST["y"], false);

//$conn = new mysqli("localhost", "root", "", "shoppn");
//echo $search_term;

include 'db_connection.php';
$conn = OpenCon();
if ($search_term=="none") {
	$stmt = $conn->prepare("SELECT * FROM products LIMIT 10");
}else{
	$stmt = $conn->prepare("SELECT * FROM products where product_title LIKE '%".$search_term."%' OR product_keywords LIKE '%".$search_term."%' LIMIT 10");
//$stmt->bind_param("ss", $obj->table, $obj->limit);
}
$stmt->execute();
$result = $stmt->get_result();
$outp = $result->fetch_all(MYSQLI_ASSOC);
CloseCon($conn);
echo json_encode($outp);


?>