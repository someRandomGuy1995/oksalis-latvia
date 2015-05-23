<?php

class CreateCrsfToken
{
    public $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    public function createCrsfToken($CRSFName)
    {
        $CRSFValue=' ';
        for ($i=0; $i<128;$i++)
        {
            $r = mt_rand(0,35);
            if ($r < 26)
            {
                $c = chr(ord('a') + $r);
            }
            else
            {
                $c = chr(ord('0') + $r -26);
            }
            $CRSFValue .= $c;
        }

        $this->session->storeInSession($CRSFName,$CRSFValue);
        return $CRSFValue;
    }

    public function validateCrsfToken($CRSFName, $CRSFValue)
    {
        $token = $this->session->getFromSession($CRSFName);
        if ($token === false) {
            $response = false;
        } elseif ($token === $CRSFValue) {
            $response = true;
        } else {
            $response = false;
        }
        $this->session->delFromSession($CRSFName);
        return $response;
    }
}