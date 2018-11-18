<?php
    include '../view/layout.php';
    include '../includes/functions.php';
?>

    <div id="content">
      <h1>Login</h1>  
        <div id="form" style="margin: 0px 35%;text-align: center;background-color: darkturquoise; padding-top:40px">
            <form id="msform" method="POST"  enctype="multipart/form-data" >
                <input id="email" type="email" name="email" placeholder="Email" autofocus required/>

                <input id="password" type="password" name="password" placeholder="Password" required/>

                <input id="submitlogin" type="submit" name="submitlogin"  value="Log in" required/>
            </form>
            
            <p>Dont Have an account ? <a href='register.php'>Sign Up</a></p>
        </div>
    </div>

<?php include '../view/footer.php' ?>