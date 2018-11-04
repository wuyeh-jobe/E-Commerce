
<?php

header("Content-type: application/json; charset=UTF-8");
$id = $_POST["x"];
$ip_add = $_POST["z"];
$action = $_POST["a"];
$obj = json_decode($_POST["y"], false);


//$conn = new mysqli("localhost", "root", "", "shoppn");
//echo $search_term;

include 'db_connection.php';
$conn = OpenCon();
if ($id != -1){
    $result = $conn -> query("SELECT * FROM cart");
    //echo $result->num_rows;
    if ($result->num_rows==0){
        $query = "INSERT INTO cart (p_id, ip_add, qty) VALUES ('$id','$ip_add','1')";
        $conn->query($query);
    }
    while ($rows = $result->fetch_assoc()){
        $qty = $rows["qty"];
        if($rows["p_id"] == $id && $rows["ip_add"]==$ip_add){
            //-50 is used to denote if a user wants to add to cart
            //echo $action;
            if($action==-50){
                $qty = $qty+1;
                $query = " UPDATE cart SET qty =".$qty. " where p_id=". $rows["p_id"];
            }
            else{
                    $qty = $qty-1;
                    $query = " UPDATE cart SET qty =".$qty. " where p_id=". $rows["p_id"];
            }
            
        }else{
            $query = "INSERT INTO cart (p_id, ip_add, qty) VALUES ('$id','$ip_add','1')";
        }
        //$query = "DELETE FROM cart WHERE qty = 0";
        $conn->query($query);
        
    }
    $conn->query("DELETE FROM cart WHERE qty = -1");
    
}



$stmt = $conn->prepare("SELECT qty, product_price, product_title, p_id FROM cart , products where p_id=product_id");
$stmt->execute();
$result2 = $stmt->get_result();
$outp = $result2->fetch_all(MYSQLI_ASSOC);
CloseCon($conn);
echo json_encode($outp);


?>