<?php include '../includes/functions.php'; ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">

  <title>GamFruits: Products you can trust!</title>
  <meta name="description" content="The HTML5 Herald">
  <meta name="author" content="SitePoint">

  <link rel="stylesheet" href="../css/style.css">
  <!--<script type="text/javascript" src="js/scripts.js"></script>-->
     <script type="text/javascript">
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
                    addingProduct();
                ?>
            }
        }
    </script>

</head>

<body>
    <div id= "container">
        <div id="header">
            <img src="../image/Banner.JPG">    
        </div>
        <div id="form" style="margin: 10px 35%;text-align: center;background-color: darkturquoise">
            <form id="msform" method="POST" onsubmit="return validateDetails()" enctype="multipart/form-data" action="ProductForm.php">
                    <h2 style="">Add Product</h2>
                    <input id="title" type="text" name="title" placeholder="Title" />
                    <!--<input id="quant" type="number" name="quant" placeholder="Quantity" />-->
                    <input id="price" type="number" name="price" placeholder="price" min="0" />
                    <textarea id="desc" name="desc" class="form-control" cols="" rows="5" placeholder="Description"></textarea>
                    
                    <select name="brand">
                        <?php
                            populateFields("brand_id","brand_name","brands");
                        ?>
                    </select>
                    <select name="cat">
                        <?php  
                            populateFields("cat_id","cat_name","categories");
                        ?>
                    </select>
                    <input id="kw" type="text" name="kw" placeholder="Key Words" />
                    <input id="img" type="file" name="image" placeholder="Upload Image" accept="image/*"/>
                    <input id="submit" type="submit" name="submit" value="Add Product" />
                </form>
            
            
        </div>
        <div id="footer" style="background: #3D3D3D; text-align:center">
            <div style="padding-top:20px"><a target="_blank" href="https://www.facebook.com/GamFruits-1826542117618203/" style="color:#EBEBEB"><img class="media" src="../image/facebook.jpg"></a><a target="_blank" href="https://twitter.com/GamFruits" style="color:#EBEBEB"><img class="media" src="../image/Twitter.jpg"></a><a target="_blank" href="#" style="color:#EBEBEB"><img class="media" src="../image/Youtube.jpg"></a> </div>
            <div id="copyright" style="color:#EBEBEB">© 2018 · All Rights Reserved · GamFruits </div>
        </div>
    </div>
   
</body>
</html>