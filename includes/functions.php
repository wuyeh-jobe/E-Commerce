<?php
include 'db_connection.php';
function addingProduct()
{
    if(isset($_POST['submit'])){
        $conn = OpenCon();
        $title= $_POST['title'];
        $price=$_POST['price'];
        $description=$_POST['desc'];
        $brand = $_POST['brand'];
        $category = $_POST['cat'];
        $k_words = $_POST['kw'];
        
        $currentDir = getcwd();
        
        $uploadDirectory = "\image\\";
        $fileName = $_FILES['image']['name'];
        $fileTmpName  = $_FILES['image']['tmp_name'];
        $uploadPath = $currentDir . $uploadDirectory . basename($fileName); 
        $didUpload = move_uploaded_file($fileTmpName, $uploadPath);
        $sql = "INSERT INTO products (product_cat,product_brand,product_title,product_price,product_desc,product_image,product_keywords) VALUES ('$category','$brand','$title','$price','$description','$fileName','$k_words')";
        
            if ($conn->query($sql) === TRUE) {
                echo "<p> New record created successfully <p>";

            } else {    
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        CloseCon($conn);

    }
}

//This function populates the dropdown list in the add product form
function populateFields($table_item1,$table_item2,$table)
{
        $conn = OpenCon();  
        $sql = "SELECT ".$table_item1.",".$table_item2." FROM ". $table;
        $result = $conn -> query($sql);
        while ($rows = $result->fetch_assoc()){
            $id = $rows[$table_item1];
            $name = $rows[$table_item2];
            echo "<option value='$id'>" . $name . "</option>";
        }
        CloseCon($conn);
}
//This function displays the products from the database
function displayProducts($page){
        $conn = OpenCon();
        $sql = "SELECT * FROM products";
        $result = $conn -> query($sql);
        while ($rows = $result->fetch_assoc()){
            $title = $rows["product_title"];
            $price = $rows["product_price"];
            $id = $rows["product_id"];
            
            //FOr putting just one product with a quantity of one in the cart w
            $_SESSION["item"] = $title;
            $_SESSION["amount"] = $price;
            $_SESSION["p_id"] = $id;
            if($page=="index"){
               $imgSrc = "image/".$rows["product_image"]; 
                echo "<div class='product'>
                <a href='pages/productview.php?id=".$id."'><img src='$imgSrc'><a>
                <p> $title <br> $ $price <br>
                <a class= 'btn_cart' id='$id' href='#' onclick='aggregate(this.id,-50)'>Add to Cart</a>
                </div>";
            }else{
                $imgSrc = "../image/".$rows["product_image"];
                echo "<div class='product' id='$id'>
                <a href='../pages/productview.php?id=".$id."'><img src='$imgSrc'><a>
                <p> $title <br> Ghs $price <br>
                <a class= 'btn_cart' id='$id' href='#' onclick='aggregate(this.id,-50)'>Add to Cart</a>
                </div>";
            }
            
            
            
            
        }  
        CloseCon($conn);
}

//This function displays the single product given an id
function singleProduct($product_id){
        $conn = OpenCon();
        $sql = "SELECT * FROM products where product_id=".$product_id;
        $result = $conn -> query($sql);
        while ($rows = $result->fetch_assoc()){
            $imgSrc = "../image/".$rows["product_image"];
            $title = $rows["product_title"];
            $price = $rows["product_price"];
            $desc = $rows["product_desc"];
            $cat_id = $rows["product_cat"];
            $p_id = $rows["product_id"];
            //get categories using cat_id in products
            $sql2 = "SELECT * FROM categories where cat_id=".$cat_id;
            $result2 = $conn -> query($sql2);
             while ($row = $result2->fetch_assoc()){
                 $cat = $row["cat_name"];
                 echo    "<div id='pImage'>
                        <img src='$imgSrc' style='width:650px;height:600px'>
                    </div>
                    <div id='details'>
                        <h1> $title </h1>
                        <p> $ $price <strike> $150</strike></p>
                        <form method='post' action='../'>
                        <input type='number' name='quantity' placeholder='Quantity' value='1' min='1'> 
                        <input type='hidden' name='p_id' value='$p_id'>
                        <a><button><input id='submit' type='hidden' name='submit'>Add to Cart </button></a>
                        </form>
                        <p>Category: $cat </p>
                        <button>Description</button>
                        <button>Reviews</button>
                        <p id='desc'>$desc</p>
                    </div>";
             }
            
        }  
        CloseCon($conn);
}

//This function adds to cart from the single product page view
function addFromSingle(/*$quantity,$p_id*/){
    $conn = OpenCon();
    if(isset($_POST['submit'])){
        $p_id = $_POST['p_id'];
        $qty = $_POST['quantity'];
        $sql1 = "SELECT * FROM cart where p_id = ".$p_id;
        $result = $conn -> query($sql1);
        if ($result->num_rows==0){
            $query = "INSERT INTO cart (p_id, ip_add, qty) VALUES ('$id','$ip_add','$qty')";
            $conn->query($query);
        }
        while ($rows = $result->fetch_assoc()){
            $oldQty = $rows['qty'];
            $newQty = $qty + $oldQty;
            $conn -> query("UPDATE cart SET qty =".$newQty. " WHERE p_id = ".$p_id);
        }
    }
    
    CloseCon($conn);
    
}

//This function is for registering a user
function register()
{
    if(isset($_POST['submit'])){
        $name= sanitize($_POST['name']);
        $email=sanitize($_POST['email']);
        $password= $_POST['password'];
        $country = sanitize($_POST['country']);
        $city = sanitize($_POST['city']);
        $contact = sanitize($_POST['contact']);
        $image = $_FILES['image']['name'];
        $address = sanitize($_POST['address']);
        $ip_add = $_SERVER['REMOTE_ADDR'];
    
        //hash the password
        $password = password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));
        
        if ($email == "" || $name == "" || $password == "" || $country == "" || $city == "" || $contact == "" || $image == "" || $address == "" || $ip_add == ""){
            return "<h4 style='text-align:center'>None of the fields should be empty </a></h4>";
        }
        else{
            //check if email already exist before inserting
            $result = executeQuery("SELECT customer_email FROM customer WHERE customer_email = '".$email."'");
            if($result->num_rows > 0){ // email exists
                
                return "<h4 style='text-align:center'>Email already exist. If you have forgotten your password <a href='#'>change it.</h4>";
            }
            else{
                //Insert into the database
                if(executeQuery("INSERT into customer (customer_ip,customer_name,customer_email,customer_pass,customer_country,customer_city,customer_contact,customer_image,customer_address) Values('$ip_add','$name','$email', '$password', '$country', '$city', '$contact', '$image', '$address')")){
                    return "<h4 style='text-align:center'>You are registered successfully</h4>";
                }
                else{
                    redirect("register.php");
                    return 'insertion failed';
                }
            }
        }
        
        


    }
}

//This function is used to login a user
function login(){
        
        $email = sanitize($_POST['email']);
        $password = sanitize($_POST['password']);
        $result = executeQuery("SELECT * FROM customer WHERE customer_email = '".$email."'" );
        $row = $result->fetch_assoc();
        $validPassword = password_verify($password, $row['customer_pass']);
        if ($validPassword) { 
            $_SESSION["name"] = $row['customer_name'];
            $_SESSION["id"] = $row['customer_id'];
            $_SESSION["email"] = $row['customer_email'];
            $_SESSION["address"] = "<table>
               <h4>Contact and Adress details</h4>
                <tr>
                   <th>Email</th>
                   <td>".$row['customer_email']."</td>
                </tr>
                
                <tr>
                   <th>Contact</th>
                   <td>".$row['customer_contact']."</td>
                </tr>
                
                 <tr>
                   <th>Address</th>
                   <td>".$row['customer_address']."<br>".$row['customer_city']."<br>".$row['customer_country']."</td>
                </tr>
                
           </table>";
           
            redirect("../index.php");
        }
        else{
            return "<h4 style='text-align:center'>Wrong email and password combination</h4>";
        }	
    
}

//This function sends an email to the user, return "Completed" when the email is sent and "In Progress" when it's not sent
function sendEmail(){
    $to = $_SESSION["email"];
    $email= 'jwuyeh@gmail.com';

    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= "From: " . $email . "\r\n"; // Sender's E-mail
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    $message ='<table style="width:100%">
                <h4>Order Details</h4>
                <tr>
                   <th>Item</th>
                   <th>Quantity</th>
                   <th>Amount</th>
                </tr>
                 <tr>
                   <td>'.$_SESSION["item"].'</td>
                   <td> 1 </td>
                   <td>'.$_SESSION["amount"].'</td>
                </tr>
        
    </table><br>'.$_SESSION["address"];
    
    

    if (@mail($to, $email, $message, $headers))
    {
        return 'Completed.';
    }else{
        return 'In Progress';
    }
}
//This function is called after a transaction has been comppleted to insert the order and payment, and delete the product from the cart
function transaction(){
    $p_id = $_SESSION["p_id"];
    $c_id = $_SESSION["id"];
    $invoice = mt_rand();
    $qty = 1;
    $date = date("Y-m-d");
    $status = sendEmail();
    
    $amount = $_SESSION["amount"];
    $query = "INSERT INTO orders (product_id, customer_id, invoice_no, qty,`order-date`, status) VALUES ('$p_id','$c_id','$invoice','$qty','$date','$status')";
    executeQuery($query);
    
    $query2 = "INSERT INTO payment (amt, customer_id, product_id,currency,payment_date) VALUES ('$amount','$c_id','$p_id','USD','$date')";
    executeQuery($query2);
    
    executeQuery("DELETE from cart where p_id =".$p_id);
    
    
}
//This function calls register when the create acount button on the register page is clicked.
if(isset($_POST['submitregister'])){
    echo register();
}

//This calls the login function when the user clicks on login on the login page
if(isset($_POST['submitlogin'])){
    echo login();
}

//This function redirects the user to the specified URL
function redirect($URL){
    echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">'; 
}




// a function that executes every query
function executeQuery($query){
	$conn = OpenCon();
	$result = $conn->query($query);
	CloseCon($conn);
    return $result;
}

// a function that sanitizes a string to avoid sql injection
function sanitize($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


?>