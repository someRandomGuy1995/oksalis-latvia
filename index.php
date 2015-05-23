<?php

//header("Content-Security-Policy: default-src 'self'; script-src 'self';");

    if (file_exists("config.php"))
    {
        require_once "require.php";
        header("Location: site/core.php");
    }
    else
    {
        header("Location: install.php"); //redirect
    }
