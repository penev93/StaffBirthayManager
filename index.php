<?php
include_once "config.php";
include_once "routes.php";
include_once "functions.php";
$router = new Router();
$usersData = basicRequest($router, $_REQUEST['action'], $_GET['$atr1']);
$current_template = $router->getTemplate();
?>
<!DOCTYPE html>
<html>
<head>
    <base href="/birthday/"/>
    <meta charset="UTF-8">
    <title><?php echo $_GET['atr1']; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1">
    <script type="text/javascript">
        var HOME_URL = "<?php echo HOME_URL ?>";
    </script>
    <link rel="stylesheet" href="<?php echo HOME_URL ?>/assets/css/Bootstrap/bootstrap.css"
    / >
    <link rel="stylesheet" href="<?php echo HOME_URL ?>/assets/css/index.css"
    / >
    <link rel="stylesheet" href="<?php echo HOME_URL ?>/assets/css/Bootstrap/bootstrap-switch.min.css"
    / >

    <link rel="stylesheet" href="<?php echo HOME_URL ?>/assets/css/edit.css"
    / >
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"/>
</head>
<body>
<div class="container">
    <div class="row">
        <!--header-->
        <?php
        if (isset($_SESSION['user'])) {
            require_once "Templates/partials/header.php";
        }
        ?>
        <!--header end-->


        <!--Main-->
        <?php

        require_once $current_template;
        ?>
        <!--End Main-->

        <!--footer-->
        <!--end footer-->
    </div>
</div>


<script src="<?php echo HOME_URL ?>/assets/js/jquery-3.1.1.js" type="text/javascript"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="<?php echo HOME_URL ?>/assets/js/bootstrap-switch.js" type="text/javascript"></script>
<script src="<?php echo HOME_URL ?>/assets/js/bootstrap.js" type="text/javascript"></script>
<script src="<?php echo HOME_URL ?>/assets/js/login.js" type="text/javascript"></script>
<script src="<?php echo HOME_URL ?>/assets/js/homepage.js" type="text/javascript"></script>
<script src="<?php echo HOME_URL ?>/assets/js/add_user.js" type="text/javascript"></script>
<script src="<?php echo HOME_URL ?>/assets/js/bootbox/bootbox.min.js" type="text/javascript"></script>
<script src="<?php echo HOME_URL ?>/assets/js/bootbox/bootbox-fix.js" type="text/javascript"></script>
<script src="<?php echo HOME_URL ?>/assets/js/edit_birthday_status.js" type="text/javascript"></script>
<script src="<?php echo HOME_URL ?>/assets/js/admin.js" type="text/javascript"></script>
<script src="<?php echo HOME_URL ?>/assets/js/update.js" type="text/javascript"></script>
<!--<script src="<?php /*echo HOME_URL */ ?>/assets/js/index.js" type="text/javascript"></script>-->


</body>
</html>
