<?php
echo "<body>";
echo "<div id=page>";

    if (isset($_GET['page']) && $_SERVER['REQUEST_METHOD'] == 'GET'){
        require_once($_GET['page'].'tpl.php');
    }
    else require_once("main.tpl.php");

echo "</div>";
echo "</body>";