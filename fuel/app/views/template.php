<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <?php echo Asset::css('bootstrap.css'); ?>

    <style type="text/css">
        body {
            padding-top: 60px;
            padding-bottom: 40px;
        }

        .sidebar-nav {
            padding: 9px 0;
        }
    </style>

    <style type="text/css">
        body {

            position: relative;

            background-color: white;
            background-image: url(../assets/img/grid-18px-masked.png);
            background-repeat: repeat-x;
            background-position: 0 40px;
        }

        .container_main {
            padding-bottom: 60px;
        }

        .bottombar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
        }
    </style>
    <?php echo Asset::css('bootstrap-responsive.css'); ?>


    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

   
   

    <?php echo Asset::css('select2.css'); ?>

    <?php echo Asset::css('font-awesome.min.css'); ?>
    <!--[if lte IE 7]>
    <?php echo Asset::css('font-awesome-ie7.min.css'); ?>
    <![endif]-->

    <?php echo Asset::css('datepicker.css'); ?>
    <?php echo Asset::css('backgrid.min.css'); ?>
    <?php echo Asset::css('backgrid-text-cell.min.css'); ?>
    <?php echo Asset::css('backgrid-select-all.min.css'); ?>
    <?php echo Asset::css('site.css'); ?>

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">


</head>
<body>

<div id="content_main">

    <?php echo $content; ?>

</div>


<div class="modal hide" id="login_modal" tabindex="-1" role="dialog"
     aria-labelledby="login_modal_Label" aria-hidden="true">
    <div class="modal-header" style="background-color: #9CC1FD;">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="login_modal_Label">Please Login</h3>
    </div>
    <div class="modal-body">
        <p><strong>Session expired, please login with your username and password.</strong></p><br/>
        <div class="input-prepend" style="text-align: right">
            <span class="add-on" style="width:75px;">Username</span><input class="span2" autocomplete="on" id="modal_username" size="35"
                                                                           type="text"
                                                                           tabindex="1">
        </div>
        <div class="input-prepend" style="text-align: right">
            <span class="add-on" style="width:75px;">Password</span><input class="span2" id="modal_password" autocomplete="off" size="35"
                                                                           type="password" tabindex="2">
        </div>
    </div>
    <div class="modal-footer">
        <input class="btn" type="button" id="login_modal_login_btn" value="Login &raquo;"  tabindex="3">
<!--        <button class="btn btn-primary" id="login_modal_login_btn">Login »</button>-->
    </div>
</div>

</body>
</html>
