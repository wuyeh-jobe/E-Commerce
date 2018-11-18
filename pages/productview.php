<?php include '../view/layout.php' ?>
    <div id="content2">
        <?php 
            include '../includes/functions.php';
            //get id of the product the user clicks
            if(isset($_GET['id'])){
              $product_id = $_GET['id'];
               // call the singleProduct function
               singleProduct($product_id );
            } else {
              echo "<h2> <br> <br> <br> <hr> <br>The item you clicked on the index<br>
                        shall be displayed here </h2> <br> <hr>";
            }
            
        ?>
    </div>
<?php include '../view/footer.php' ?>