<?php include '../view/layout.php' ?>
        <div id="content">
          <h1>Shopping Cart</h1>  
          <div id="displayAll" style="text-align:center"></div>
            <br>
            <div id="clinks" style="text-align:center">
                <a href="product.php">Continue Shopping</a>
                <?php
                    if(isset($_SESSION["name"]))
                        echo "<a href='checkout.php'>Checkout</a>";
                    else
                        echo "<a href='login.php'>Checkout</a>";   
                ?>
                
            </div>
        </div>
<?php include '../view/footer.php' ?>