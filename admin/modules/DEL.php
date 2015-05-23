<?php

class DEL
{
    private $CRSFToken;

    public function __construct()
    {
        $this->CRSFToken = new CreateCrsfToken;
    }

    public function delete($sql){

    ////////////////////////////////////////////////// If its a resource

        if($_POST['pTypeDel']=='resource')
        {
            if ($this->CRSFToken->validateCrsfToken($_POST['CSRFName'], $_POST['CSRFValue'])) {
                $sql->delete('resourcemeta');
                $sql->where(array('resource_id' => $_POST['id']) ,"=");
                $res1 = $sql->runQuery();

                $sql->delete('resource');
                $sql->where(array('id' => $_POST['id']) ,"=");
                $res2 = $sql->runQuery();

                if ($res1 && $res2)
                {
                    echo '<span id="message">Izdzēsts</span>';
                }
            }  else echo"<span id='message'>XSS</span>";
        }
        ///////////////////////////////////////////////// If its an user

        else if($_POST['pTypeDel']=='user')
        {
            if ($this->CRSFToken->validateCrsfToken($_POST['CSRFName'], $_POST['CSRFValue'])) {
                $sql->delete('user');
                $sql->where(array('id' => $_POST['id']) ,"=");
                $res = $sql->runQuery();

                if ($res)
                {
                    echo "<span id='message'>Izdzēsts</span>";
                }
            }  else echo"<span id='message'>XSS</span>";
        }

        ///////////////////////////////////////////////// If its a file

        else if($_POST['pTypeDel']=='file')
        {
            if ($this->CRSFToken->validateCrsfToken($_POST['CSRFName'], $_POST['CSRFValue'])) {
                $sql->delete('file');
                $sql->where(array('alias' => $_POST['alias']) ,"=");
                $res = $sql->runQuery();

                if ($res)
                {
                    echo "<span id='message'>Izdzēsts</span>";
                }

                $location2 = "../style/img/".$_POST['alias'];
                unlink($location2);
            }  else echo"<span id='message'>XSS</span>";
        }

        ///////////////////////////////////////////////// If its a student

        else if($_POST['pTypeDel']=='student')
        {
            if ($this->CRSFToken->validateCrsfToken($_POST['CSRFName'], $_POST['CSRFValue'])) {
                $sql->delete('student');
                $sql->where(array('id' => $_POST['id']) ,"=");
                $res = $sql->runQuery();


                if ($_POST['photo'] != "")
                {
                    $location = "../style/photos/".$_POST['photo'];
                    $res = unlink($location);
                }

                if ($res)
                {
                    echo "<span id='message'>Izdzēsts</span>";
                }
                else
                {
                    echo "<span id='message'>Kļūda</span>";
                }
            }  else echo"<span id='message'>XSS</span>";
        }

        else if($_POST['pTypeDel']=='products')
        {
            if ($this->CRSFToken->validateCrsfToken($_POST['CSRFName'], $_POST['CSRFValue'])) {
                $sql->delete('products');
                $sql->where(array('id' => $_POST['id']) ,"=");
                $res = $sql->runQuery();

                if ($res)
                {
                    echo "<span id='message'>Izdzēsts</span>";
                }
            }  else echo"<span id='message'>XSS</span>";
        }

        else if($_POST['pTypeDel']=='courses')
        {
            if ($this->CRSFToken->validateCrsfToken($_POST['CSRFName'], $_POST['CSRFValue'])) {
                $sql->delete('courses');
                $sql->where(array('id' => $_POST['id']) ,"=");
                $sql->runQuery();

                $sql->delete('student');
                $sql->where(array('courseID' => $_POST['id']) ,"=");
                $res = $sql->runQuery();

                if ($res)
                {
                    echo "<span id='message'>Izdzēsts</span>";
                }
            }  else echo"<span id='message'>XSS</span>";
        }

    }
}