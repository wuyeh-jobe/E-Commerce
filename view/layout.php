<?php session_start();  ?>
<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>GamFruits: Products you can trust!</title>
  <meta name="description" content="The HTML5 Herald">
  <meta name="author" content="SitePoint">

  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="../css/style.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.js"></script>
    <script>
        function showResult(str) {
          if (str.length==0) { 
            //document.getElementById("form-popup").innerHTML= "Nothing Matched";
            document.getElementById("myForm").style.display = "none";
            str = "none";
          }
          if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
          } else {  // code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
            var obj, xmlhttp, dbParam, myObj, x, y, txt = "";
            obj = { "table":"products", "limit":10 };
            dbParam = JSON.stringify(obj);
            xmlhttp = new XMLHttpRequest();
            var loc = window.location.pathname;
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    myObj = JSON.parse(this.responseText);
                    if(Object.keys(myObj).length==0){
                        document.getElementById("myForm").style.display = "block";
                       document.getElementById("myForm").innerHTML= "Nothing Matched";
                    }
                    else{
                        for (y in myObj) {
                            if(loc.includes("pages")){
                                var imgSrc = "../image/"+ myObj[y].product_image;
                            }
                            else{
                                var imgSrc = "image/"+ myObj[y].product_image;
                            }
                            
                            txt += "<div class='product' id='"+ myObj[y].product_id +"'><a href='pages/productview.php?id="+ myObj[y].product_id +"'><img src='"+imgSrc+"'><a><p>"+ myObj[y].product_title + "<br> $"+ myObj[y].product_price + "<br><a class= 'btn_cart' id='"+myObj[y].product_id+"' href='#' onclick='aggregate(this.id,-50)'>Add to Cart</a></div>";
                        }
                        document.getElementById("content").innerHTML=txt;
                         document.getElementById("myForm").style.display = "none";
                    }
                }
            }
            if(loc.includes("pages")){
                xmlhttp.open("POST", "../includes/getSearchData.php", true);
            }
            else{
                xmlhttp.open("POST", "./includes/getSearchData.php", true);
            }
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            //send multiple body data, in this case x is sending the input string
            //and y is sending the json database parameter
            xmlhttp.send("x=" + str+"&"+"y=" + dbParam);
        }
        function aggregate(id,action){
          if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
          } else {  // code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
            var obj, xmlhttp, dbParam, myObj, x, y, txt, txt2, ip_add = "";
            obj = { "table":"products", "limit":10 };
            dbParam = JSON.stringify(obj);
            xmlhttp = new XMLHttpRequest();
            //Get the current path
            var loc = window.location.pathname;
            //Sum of quantity
            var tqty = 0;
            //Sum of price
            var tprice = 0;
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    myObj = JSON.parse(this.responseText);
                    txt2 = "<table><tr><th>Product</th><th>Price</th><th>Quantity</th><th>Amount</th><th>Actions</th></tr>";
                    for (y in myObj) {
                        //console.log(myObj[y].qty);
                        if(myObj[y].qty==0){
                           var r = confirm("Want to remove "+myObj[y].product_title+ " from the list?");
                            if (r == true) {
                                alert(myObj[y].product_title+ " will be removed. You can add it again by clicking on 'Continue Shopping'");
                                aggregate(myObj[y].p_id,-100);
                            } else {
                                aggregate(myObj[y].p_id,-50);
                            }
                        }
                        else{
                            tqty += myObj[y].qty;
                            tprice += myObj[y].product_price * myObj[y].qty;
                            txt2 += "<tr><td>"+myObj[y].product_title+"</td><td>"+ myObj[y].product_price +"</td><td>"+ myObj[y].qty +"</td><td>"+myObj[y].product_price * myObj[y].qty+"</td><td><button id='"+myObj[y].p_id+"' style='font-size:20px;width:40px' onclick='aggregate(this.id,-50)'> + </button> <button id='"+myObj[y].p_id+"' style='font-size:20px;width:40px' onclick='aggregate(this.id,-100)'> - </button></td></tr>";
                        }
                        

                    }
                    txt = "Shopping Cart - Total Items: "+ tqty + " | Total Price: "+ "$"+tprice;
                    txt2 += "<tr><th>Total</th><th></th><th>"+tqty+"</th><th>"+tprice+"</th><th></th></tr></table>";
                    document.getElementById("pUpdate").innerHTML=txt;
                    document.getElementById("displayAll").innerHTML=txt2;
                }
            }
            //This condition selects the correct path base on the relative folder
            if(loc.includes("pages")){
                xmlhttp.open("POST", "../includes/getCartData.php", true);
            }
            else{
                xmlhttp.open("POST", "./includes/getCartData.php", true);
            }
            //Get ip address and assign it to the variable ip_add
            $.getJSON("https://jsonip.com?callback=?", function(data) {
                ip_add =  data.ip;
            });
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            //send multiple body data, in this case x is sending the input string
            //and y is sending the json database parameter
            xmlhttp.send("x=" + id+"&y=" + dbParam+"&z="+ip_add+"&a="+action);
        }
        
        
        function validateRegister(){
            if (document.getElementById("name").value == "" || document.getElementById("email").value == "" || document.getElementById("password").value == "" || document.getElementById("country").value == "" || document.getElementById("city").value == "" || document.getElementById("contact").value == "" || document.getElementById("image").value == "" || document.getElementById("address").value == ""){
                alert("None of the fields should be empty");
                return false;
            }
                
        }

        
        
    </script>
    <style>
        /* The popup search result box - hidden by default */
        .form-popup {
          display: none;
          position: fixed;
          top: 25%;
          right: 10%;
          border: 3px solid green;
          z-index: 9;
            background-color: antiquewhite;
            text-align: center;
            width: 150px;
        }
    
    </style>
</head>

<body onload="aggregate(-1,-1)">
    <div id= "container">
        <?php
         $path = explode("\\", getcwd());
        if ($path[sizeof($path)-1]=="pages"){
            if (isset($_SESSION["name"]))
                {
                    
                echo "<div style='margin-left:80%'>Welcome ".$_SESSION["name"]." <a href='logout.php'>Logout</a> </div>";
            } 
            else{
                echo "<div style='margin-left:80%'><a href='login.php'>Login</a> </div>";
            }
        }else{
            if (isset($_SESSION["name"]))
                {
                    
                echo "<div style='margin-left:80%'>Welcome ".$_SESSION["name"]." <a href='./pages/logout.php'>Logout</a> </div>";
            } 
            else{
                echo "<div style='margin-left:80%'><a href='./pages/login.php'>Login</a> </div>";
            }
        }
        
        ?>
        
        
        <div id="header">
            <?php
                $path = explode("\\", getcwd());
                if ($path[sizeof($path)-1]=="pages"){
                   echo "
                   <img src='../image/Banner.JPG'>
                    </div>
                    <div id='menu'>
                        <ol>
                            <a href='../index.php'><li class='menu_li'>Home</li></a>
                            <a href='product.php'><li class='menu_li'>Products</li></a>
                            <a href='account.php'><li class='menu_li'>Account</li></a>
                            <a href='register.php'><li class='menu_li'>Sign Up</li></a>
                            <a href='ShoppingCart.php'><li class='menu_li'>Shopping Cart</li></a>
                            <a href='contactUs.php'><li class='menu_li'>Contact Us</li></a>
                            <li class='menu_li'><input type='text' onkeyup='showResult(this.value)' placeholder='Start typing to search'><button>Search</button></li>
                        </ol>
                    </div>";
                }
                else{
                   echo "
                   <img src='image/Banner.JPG'>
                    </div>
                    <div id='menu'>
                        <ol>
                            <a href='index.php'><li class='menu_li'>Home</li></a>
                            <a href='./pages/product.php'><li class='menu_li'>Products</li></a>
                            <a href='./pages/account.php'><li class='menu_li'>Account</li></a>
                            <a href='./pages/register.php'><li class='menu_li'>Sign Up</li></a>
                            <a href='./pages/ShoppingCart.php'><li class='menu_li'>Shopping Cart</li></a>
                            <a href='./pages/contactUs.php'><li class='menu_li'>Contact Us</li></a>
                             <li class='menu_li'><input type='text' onkeyup='showResult(this.value)' placeholder='Start typing to search'><button>Search</button></li>
                        </ol>
                    </div>";
                }
            ?>
        <div class="form-popup" id="myForm">
          No Product Matched
        </div>
        <div id="middle">
            <div id="sidebar">
                <h2>Categories</h2>
                <ol style="list-style-type:none">
                    <a href="#"><li class="cat">Category 1</li></a>
                    <a href="#"><li class="cat">Category 2</li></a>
                    <a href="#"><li class="cat">Category 3</li></a>
                    <a href="#"><li class="cat">Category 4</li></a>
                    <a href="#"><li class="cat">Category 5</li></a>
                </ol>
                <h2>Brands</h2>
                <ol style="list-style-type:none">
                    <li class="bran"><a href="#">Brand 1</a></li>
                    <li class="bran"><a href="#">Brand 2</a></li>
                    <li class="bran"><a href="#">Brand 3</a></li>
                    <li class="bran"><a href="#">Brand 4</a></li>
                    <li class="bran"><a href="#">Brand 5</a></li>
                </ol>
            </div>
            <div id="side">
                <div id="breadcrumbs">
                   <em><b style="color:brown">We care about you! We care about your health! <br>That's why our products, even from the looks, are 100% organic!</b></em>
                    <ol id="ol2">                        
                        <li class="bre">Welcome Guest</li>
                        <li id="pUpdate" class="bre"></li>
                        <?php
                        $path = explode("\\", getcwd());
                            if ($path[sizeof($path)-1]=="pages"){
                                echo "<li class='bre'><a href='ShoppingCart.php'>Go to Cart</a></li>";
                            }else{
                                echo "<li class='bre'><a href='./pages/ShoppingCart.php'>Go to Cart</a></li>";
                            }
                        ?>
                    </ol>
                </div>
                
                