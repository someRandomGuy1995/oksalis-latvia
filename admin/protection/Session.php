<?php

class Session
{
    public function storeInSession($field, $value)
    {
        if (isset($_SESSION)) {
            $_SESSION[$field] = $value;
            return true;
        } else {
            return false;
        }
    }

    public function delFromSession($field) {
        if (isset($_SESSION)) {
            unset($_SESSION[$field]);
            return true;
        } else {
            return false;
        }
    }

    public function getFromSession($field) {
        if (isset($_SESSION)) {
            return $_SESSION[$field];
        } else {
            return false;
        }
    }
}