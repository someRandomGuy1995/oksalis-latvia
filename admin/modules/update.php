<?php

class update
{
    private $CRSFToken;

    public function __construct()
    {
        $this->CRSFToken = new CreateCrsfToken;
    }

    public function upd($sql){

        ///////////////////////////////////////////////////resource

        if($_POST['ptype']=='resource')
        {
            if ($this->CRSFToken->validateCrsfToken($_POST['CSRFName'], $_POST['CSRFValue'])) {
                $sql->update('resource');
                $sql->set(array('title' => $_POST['title'], 'date' => $_POST['date']));
                $sql->where(array('id' => $_POST['id']) ,"=");
                $res = $sql->runQuery();

                $sql->update('resourcemeta');
                $sql->set(array('value' => $_POST['data']['text']));
                $sql->where(array('resource_id' => $_POST['id']) ,"=");
                $res2 = $sql->runQuery();



                if ($res && $res2)
                {
                    echo "<p id='message'>Saglabāts</p>";
                }
                else  echo "<p id='messageWarn'>Kļūda</p>";
            } else echo"<p id='messageWarn'>XSS</p>";
        }

        ////////////////////////////////////////////////////user

        else if($_POST['ptype']=='user')
        {
            if ($_SESSION['account_type'] != 1) {
                echo "<p id='messageWarn'>Nav pieejas!</p>";
            } else {
                if ($this->CRSFToken->validateCrsfToken($_POST['CSRFName'], $_POST['CSRFValue'])) {
                    $pass = md5($_POST['password']);

                    $sql->update('user');
                    $sql->set(array(
                        'username' => $_POST['username'],
                        'password' => $pass,
                        'sait' => $_POST['sait'], 'name' => $_POST['name'], 'surname' => $_POST['surname'],
                        'date' => $_POST['date'],
                        'is_admin' => $_POST['is_admin']
                    ));
                    $sql->where(array('id' => $_POST['id']) ,"=");
                    $res = $sql->runQuery();

                    if ($res)
                    {
                        echo "<p id='message'>Saglabāts</p>";
                    }
                } else echo"<p id='messageWarn'>XSS</p>";
            }
        }

        else if($_POST['ptype']=='file')
        {
            if ($_SESSION['account_type'] != 1) {
                echo "<p id='messageWarn'>Nav pieejas!</p>";
            } else {
                if ($this->CRSFToken->validateCrsfToken($_POST['CSRFName'], $_POST['CSRFValue'])) {
                    $sql->update('file');
                    $sql->set(array('title' => $_POST['title'], 'type' => $_POST['type']));
                    $sql->where(array('id' => $_POST['id']) ,"=");
                    $res = $sql->runQuery();

                    if ($res)
                    {
                        echo "<p id='message'>Saglabāts</p>";
                    }
                }  else echo"<p id='messageWarn'>XSS</p>";
            }
        }

        else if($_POST['ptype']=='products') {
            if ($this->CRSFToken->validateCrsfToken($_POST['CSRFName'], $_POST['CSRFValue'])) {
                if ($_FILES['file']['size'] != 0) {
                    $pic = md5(time()) . '.' .  pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
                }
                else $pic = $_POST['picture'];

                $sql->update('products');
                $sql->set(array('name' => $_POST['name'],
                    'price' => $_POST['price'],
                    'quantity' => $_POST['quantity'],
                    'description' => $_POST['productDescription'] ,
                    'typeKind' => $_POST['typeKind'],
                    'picture' => $pic,
                    'weight' => $_POST['weight'],
                    'date'   => date("Y-m-d")
                ));

                $sql->where(array('id' => $_POST['id']) ,"=");
                $res = $sql->runQuery();

                if(is_uploaded_file($_FILES["file"]["tmp_name"])) {
                    move_uploaded_file($_FILES["file"]["tmp_name"], "../style/img/".$pic);
                }

                if ($res) {
                    echo "<p id='message'>Saglabāts!</p>";
                }
            }  else echo"<p id='messageWarn'>XSS</p>";
        }

        else if($_POST['ptype']=='courses') {
            if ($_SESSION['account_type'] != 1) {
                echo "<p id='messageWarn'>Nav pieejas!</p>";
            } else {
                if ($this->CRSFToken->validateCrsfToken($_POST['CSRFName'], $_POST['CSRFValue'])) {
                    $sql->update('courses');
                    $sql->set(array('date' => $_POST['date']));
                    $sql->where(array('id' => $_POST['id']) ,"=");
                    $res = $sql->runQuery();

                    if ($res) {
                        echo "<p id='message'>Saglabāts</p>";
                    }
                }  else echo"<p id='messageWarn'>XSS</p>";
            }
        }
    }
}