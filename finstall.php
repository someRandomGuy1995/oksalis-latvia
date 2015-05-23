<html>
<title>form</title>
<head>
    <style>
    legend {font-size: 20px;}
    p {font-size: 30pt; font-weight: bold; text-align: center};
    </style>
</head>
<body>
    <p>Enter database connection parameters</p>
    <form style="text-align: center" method="POST" enctype="multipart/form-data">
        <fieldset>
        <legend>Database</legend>
         <b>Host name</b>   <br>
         <input type="text" name="host"><br>
            <b>Username</b>   <br>
         <input type="text" name="name"><br>
            <b>Password</b>   <br>
         <input type="text" name="pass"><br>
            <b>Database</b>   <br>
         <input type="text" name="data"><br>
         <br>
         <input type="submit" name="send" id="send" value="Submit">
        </fieldset>
       </form>

<?php

if ($_SERVER['REQUEST_METHOD']=='POST')
{
    $host = $_POST['host'];
    $name = $_POST['name'];
    $pass = $_POST['pass'];
    $data = $_POST['data'];

    if ($host == '') $error = 'Enter host name';
    else if ($name == '') $error = 'Enter username';
    else if ($data == '') $error = 'Enter database';

    if (isset($error))
        echo "$error";
    else
    {
        $conn = new mysqli($host, $name, $pass, $data);
        if ($conn->connect_error)
        {
            echo "Unable to connect"; die;
        }

        $file = fopen('config.php','w+');

        $text = file_get_contents('config-sample.php');
        $text = str_replace(
            array('{HOST}','{NAME}','{PASS}','{DATA}'),
            array($host,$name,$pass,$data),
            $text
        );

        fwrite($file,$text);

        fclose($file);
        require_once('config.php');
        require_once('system/sql.php');

        $sql = new sql;
        $sql->install();

    }

}
    ?>

</body>
</html>