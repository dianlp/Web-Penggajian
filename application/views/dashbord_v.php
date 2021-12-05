<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view("templates/head.php") ?>
</head>
<body>
<body>
    <div class="wrapper">
        <?php $this->load->view("templates/sidebar.php") ?>
        <div class="main-panel">
            <!-- Navbar -->
            <?php $this->load->view("templates/navbar.php") ?>
            <!-- End Navbar -->
            <div class="content">
                <div class="container-fluid">
                    
                </div>
            </div>
            <?php $this->load->view("templates/footer.php") ?>
        </div>
    </div>
</body>
<?php $this->load->view("templates/js.php") ?>

</html>