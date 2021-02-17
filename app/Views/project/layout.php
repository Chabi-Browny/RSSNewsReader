<!DOCTYPE html>
<html lang="en">
    <head>
            <meta charset="UTF-8">
            <title>RSS Reader</title>
            <meta name="description" content="The small framework with powerful features">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="shortcut icon" type="image/png" href="/favicon.ico"/>

            <!-- STYLES -->
            <link rel="stylesheet" type="text/css" href="<?php echo BASEURL;?>/assets/plugins/bootstrap-4.6/css/bootstrap.min.css">
            <link rel="stylesheet" type="text/css" href="<?php echo BASEURL;?>/assets/css/style.css">
    </head>
    <body>
        <div class="container-fluid centering main-container">
            <!-- HEADER: MENU + HEROE SECTION -->
            <div class="row">
                <?php echo $this->include('project/pageParts/header'); ?>
            </div>
            <!-- CONTENT -->
            <div class="row">
                <div class="col ">
                    <div class="content-main">
                        <?php  echo $this->renderSection('content'); ?>
                    </div>
                </div>
            </div>
            <!-- FOOTER: DEBUG INFO + COPYRIGHTS -->
            <div class="row">
                <?php echo $this->include('project/pageParts/footer');?>
            </div>
        </div>
        <!-- SCRIPTS -->
        <script src="<?php echo BASEURL;?>/assets/js/jquery-3.5.1.min.js"></script>
        <script src="<?php echo BASEURL;?>/assets/js/popper.min.js"></script>
        <script src="<?php echo BASEURL;?>/assets/plugins/bootstrap-4.6/js/bootstrap.min.js"></script>
        
        <?php 
        if( !empty($javascripts))
        {
            foreach($javascripts as $js)
            {
                echo $js;
            }
        }
        
        ?>
        
    </body>
</html>
