<?php 
    include 'view/layout.php';
?>

    <div id="content">
        <?php 
            include 'includes/functions.php'; 
            displayProducts("index");
            addFromSingle();
        ?>
        
    </div>

<?php include 'view/footer.php' ?>
