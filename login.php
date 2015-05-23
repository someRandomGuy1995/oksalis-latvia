<?php

require_once('require.php');
header("Content-Security-Policy: default-src 'self'; script-src 'self';");

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql->select();
    $sql->from(array('user'));
    $sql->where(array('username' => $username), "=");
    $a = $sql->runQuery();

    if (count($a))
    {
        if (!($a[0]->password == md5($password)))
        {
        ?>
            <div class="alert-warning">
                <a href="#" id="close" data-dismiss="alert">&times;</a>
                <strong>Kļūda!</strong> Nepareizs lietotāja vārds vai parole!
            </div>
        <?php
        }
        else
        {
            $_SESSION['id'] = $a[0]->id;
            $_SESSION['user'] = $username;
            $_SESSION['account_type'] = $a[0]->is_admin;
            header('Location: admin/index.php');
        }
    }
    else
    {
        ?>
        <div class="alert-warning">
            <a href="#" id="close" data-dismiss="alert">&times;</a>
            <strong>Kļūda!</strong> Nepareizs lietotāja vārds vai parole!
        </div>
        <?php
    }
}
?>






<html>
<head>

    <link rel="stylesheet" href="style/css/login.css" type="text/css">
    <meta charset="UTF-8">

</head>
<body>

<script  src="admin/js/jquery-1.11.2.js"></script>
<script  type="text/javascript" src="style/js/script.js"></script>

<form method="POST" id="formm" >
    <div id="dii2">
    <span id="head"><a href="index.php">cms</a></span><br><br>
    <b>Username</b><br>
    <input type="text" name="username"><br>
    <br>
    <b>Password</b><br>
    <input type="password" name="password"><br>
    <br>
    <input type="submit" name="submit" value="Pieslēgties">
    </div>

    <div id="dii">
    </div>
</form>


</body>
</html>




