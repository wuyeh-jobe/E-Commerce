<?php 
    include '../view/layout.php';
    include '../includes/functions.php';
?>

    <div id="content">
      <h1>Register</h1>  
        <div id="form" style="margin: 0px 35%;text-align: center;background-color: darkturquoise; padding-top:40px">
            <form id="msform" method="POST"  enctype="multipart/form-data" action="">
                    <input id="name" type="text" name="name" placeholder="Name" required/>
                    <input id="email" type="email" name="email" placeholder="Email" autofocus required/>
                   
                    <input id="password" type="password" name="password" placeholder="Password" required/>
                    <input id="country" type="text" name="country" placeholder="Country" required/>
                    <input id="city" type="text" name="city" placeholder="City" required/>
                    <input id="contact" type="text" name="contact" placeholder="Contact"/>
                    <input id="image" type="file" name="image" placeholder="Upload Image" accept="image/*" required/>
                    <textarea id="address" name="address" class="form-control" cols="" rows="5" placeholder="Address"></textarea>
                    <input onclick="validateRegister()" id="submitregister" type="submit" name="submitregister"  value="Create Accout"/>
                </form>
            
            
        </div>
    </div>

<?php include '../view/footer.php' ?>