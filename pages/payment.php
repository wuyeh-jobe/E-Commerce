<?php include '../view/layout.php' ?>
        <div id="content">
          <h1>Payment</h1> 
        <div style="margin-left:50%">
         <form action="payment_success.php" method="post">
              <!-- Identify your business so that you can collect the payments. -->
              <input type="hidden" name="business" value="herschelgomez@xyzzyu.com">

              <!-- Specify a Buy Now button. -->
              <input type="hidden" name="cmd" value="_xclick">

              <!-- Specify details about the item that buyers will purchase. -->
              <input type="hidden" name="item_name" value="<?php echo $_SESSION["item"] ?>">
              <input type="hidden" name="amount" value="<?php echo $_SESSION["amount"] ?>">
              <input type="hidden" name="currency_code" value="USD">

              <!-- Display the payment button. -->
              <input type="image" name="submit" border="0"
              src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
              alt="Buy Now">
              <img alt="" border="0" width="1" height="1"
              src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >

        </form>
            
            <a href="#"><button>Pay with Mobile money</button></a>
            
        </div>
    </div>
<?php include '../view/footer.php' ?>