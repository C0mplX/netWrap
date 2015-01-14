<?php
require('core/init.php');

$return = array();

$check_table = $dbHandler->check_db_tables();

if($check_table === true){
    header('Location: index.php');
}else if($check_table === false){
    header('Location: setup-nw.php');
    //$create_tables = $dbHandler->instal_db_tables();
}
?>
<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>AdminLTE | Registration Page</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-black">

        <div class="form-box" id="login-box">
            <div class="header">Setup new account</div>
            <form action="core/signup-login.php" method="post">
                <div class="body bg-gray">
                    <div class="form-group">
                        <input type="text" id="setup_full_name_reg" name="name" class="form-control" placeholder="Full name"/>
                    </div>
                    <div class="form-group">
                        <input type="text" id="setup_user_name_reg" name="userid" class="form-control" placeholder="Username"/>
                    </div>
                    <div class="form-group">
                        <input type="email" id="setup_user_email_reg" name="setup_user_email_reg" class="form-control" placeholder="Email"/>
                    </div>
                    <div class="form-group">
                        <input type="password" id="setup_user_password" name="password" class="form-control" placeholder="Password"/>
                    </div>
                    <div class="form-group">
                        <input type="password" id="setup_user_password2" name="password2" class="form-control" placeholder="Retype password"/>
                    </div>
                    <div class="form-group">
                        <div id="responseReg"></div>
                    </div>

                </div>
                <div class="footer">

                    <button type="submit" id="setup_reg_admin_user" class="btn bg-olive btn-block">Start NetWrap</button>

                </div>
            </form>

            <div class="margin text-center">
            </div>
        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="js/ajax/nw-ajax.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js" type="text/javascript"></script>

    </body>
</html>
