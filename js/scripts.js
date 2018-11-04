function validateDetails(){
    if(document.getElementById("title").value == "" || document.getElementById("price").value =="" || 
        document.getElementById("quant").value ==""){
            alert("Title, Price and Quantity Fields are mandatory");
                return false;
        }
        else if(document.getElementById("message").value==""){
            alert("Please write Description");
                 return false;
            }
        else{
           //This PHP adds the details to the database --->
            <?php
                include 'addProductCode.php';
            ?>
        }
    }