<?php include '../view/layout.php';
    include '../includes/functions.php';
?>
        <div id="content">
            <?php 
                transaction();                
            ?>
          <h1>Payment Details</h1> 
            <p>You have successfully made your payment. <br>
            Thank you for shopping with us <b> <?php echo $_SESSION["name"] ?> </b>. Below are your details.</p>
       <div>
           <table>
               <h4>Order Details</h4>
                <tr>
                   <th>Item</th>
                   <th>Quantity</th>
                   <th>Amount</th>
                </tr>
                 <tr>
                   <td><?php echo $_SESSION["item"]  ?></td>
                   <td> 1 </td>
                   <td><?php echo $_SESSION["amount"]  ?></td>
                </tr>
           </table>
           
        </div>
            <?php echo $_SESSION["address"]  ?>
    </div>
<?php include '../view/footer.php' ?>