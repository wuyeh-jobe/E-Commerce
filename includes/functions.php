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
//$id = 0;
function displayProducts($page){
        $conn = OpenCon();
        $sql = "SELECT * FROM products";
        $result = $conn -> query($sql);
        while ($rows = $result->fetch_assoc()){
            $title = $rows["product_title"];
            $price = $rows["product_price"];
            $id = $rows["product_id"];
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
function addFromSingle(/*$quantity,$p_id*/){
    $conn = OpenCon();
    if(isset($_POST['submit'])){
        $p_id = $_POST['p_id'];
        $qty = $_POST['quantity'];
        $sql1 = "SELECT * FROM cart where p_id = ".$p_id;
        $result = $conn -> query($sql1);
        while ($rows = $result->fetch_assoc()){
            $oldQty = $rows['qty'];
            $newQty = $qty + $oldQty;
            $conn -> query("UPDATE cart SET qty =".$newQty. " WHERE p_id = ".$p_id);
        }
    }
    
    CloseCon($conn);
    
}


?>