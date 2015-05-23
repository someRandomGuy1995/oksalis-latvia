<?php

class create {

    private $CRSFToken;

    public function __construct()
    {
        $this->CRSFToken = new CreateCrsfToken;
    }

    public function create_new($sql)
    {
        ///////////////////////////////////////////////////// Add resource
        if ($_POST['new']=='resource')
        {
            if ($this->CRSFToken->validateCrsfToken($_POST['CSRFName'], $_POST['CSRFValue'])) {
                $title = $_POST['title'];
                $type = $_POST['type'];
                $author = $_SESSION['id'];
                $date = $_POST['date'];

                $sql->insert('resource');
                $sql->columns(array('title', 'type', 'author', 'date', 'slug', 'parent', 'order'));
                $sql->values(array($title, $type, $author, $date, 'ddd', '1', '1'));
                $res = $sql->runQuery();

                $a = $sql->cn->query("SELECT * FROM resource ORDER BY id DESC LIMIT 1;");
                while ($obj = $a->fetch_object()) {
                    $result[] = $obj;
                }

                $sql->insert('resourcemeta');
                $sql->columns(array('value', 'resource_id', 'key'));
                $sql->values(array($_POST[$type], $result[0]->id, 'hello'));
                $res = $sql->runQuery();

                if ($res) {
                    echo "<p id='message'>Jauns ieraksts tika pievienots!</p>";
                } else {
                    echo "<p id='messageWarn'>Kļūda!</p>";
                }
            } else echo "<p id='messageWarn'>XSS</p>";
        }

        ///////////////////////////////////////////////////// Add user

        else if($_POST['new']=='user')
        {
            if ($_SESSION['account_type'] != 1) {
                echo "<p id='messageWarn'>Nav pieejas!</p>";
            } else {
                if ($this->CRSFToken->validateCrsfToken($_POST['CSRFName'], $_POST['CSRFValue'])) {
                    $username = $_POST['username'];
                    $password = md5($_POST['password']);
                    $sait = $_POST['sait'];
                    $name = $_POST['name'];
                    $surname = $_POST['surname'];
                    $is_admin = $_POST['is_admin'];
                    $date = date("Y-m-d H:i:s");

                    $sql->select();
                    $sql->from(array('user'));
                    $sql->where(array('username' => $username), '=');
                    $res = $sql->runQuery();

                    if (!count($res)) {

                        $sql->insert('user');
                        $sql->columns(array('username', 'password', 'sait', 'name', 'surname', 'date', 'is_admin'));
                        $sql->values(array($username, $password, $sait, $name, $surname, $date, $is_admin));
                        $res = $sql->runQuery();

                        if ($res) {
                            echo "<p id='messageWarn'>Saglabāts</p>";
                        } else {
                            echo "<p id='messageWarn'>Kļūda!</p>";
                        }
                    } else echo "<p id='messageWarn'>Kļūda!</p>";

                } else echo "<p id='messageWarn'>XSS</p>";
            }
        }
        ///////////////////////////////////////////////////////////////////////////////add FIle
        else if($_POST['new']=='file')
        {
            if ($_SESSION['account_type'] != 1) {
                echo "<p id='messageWarn'>Nav pieejas!</p>";
            } else {
                if ($this->CRSFToken->validateCrsfToken($_POST['CSRFName'], $_POST['CSRFValue'])) {
                    $author = $_SESSION['id'];
                    $date = date("Y-m-d H:i:s");
                    $title = $_POST['title'];
                    $type = $_POST['type'];
                    $format = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
                    $alias = md5(time() . '-picture') . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);


                    $sql->insert('file');
                    $sql->columns(array('title', 'alias', 'type', 'format', 'date', 'author'));
                    $sql->values(array($title, $alias, $type, $format, $date, $author));
                    $res = $sql->runQuery();

                    if ($res) {
                        echo "<p id='message'>Saglabāts</p>";
                    } else echo "<p id='messageWarn'>Kļūda!</p>";

                    if (is_uploaded_file($_FILES["file"]["tmp_name"])) {
                        move_uploaded_file($_FILES["file"]["tmp_name"], "../style/img/" . $alias);
                    } else {
                        echo("Error loading file");
                    }
                } else echo "<p id='messageWarn'>XSS</p>";
            }
        }

        ///////////////////////////////////////////////////////////////////////////////add Product

        else if($_POST['new']=='products')
        {
            if ($this->CRSFToken->validateCrsfToken($_POST['CSRFName'], $_POST['CSRFValue'])) {
                $name = $_POST['name'];
                $quantity = $_POST['quantity'];
                $price = $_POST['price'];
                $typeID = $_POST['typeID'];
                $typeKind = $_POST['typeKind'];
                $description = $_POST['productDescription'];
                $weight = $_POST['weight'];
                $date = date("Y-m-d");
                $picture = md5(time()) . '.' . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

                $sql->insert('products');
                $sql->columns(array('name', 'quantity', 'price', 'picture', 'weight', 'typeID', 'description', 'typeKind' , 'date'));
                $sql->values(array($name, $quantity, $price, $picture, $weight, $typeID, $description, $typeKind, $date));
                $res = $sql->runQuery();

                $date = date("Y-m-d H:i:s");
                $author = $_SESSION['id'];

                $sql->insert('file');
                $sql->columns(array('title', 'alias', 'type', 'format', 'date', 'author'));
                $sql->values(array($name, $picture, 'picture', 'jpg', $date, $author));
                $sql->runQuery();

                if ($res) {
                    echo "<p id='message'>Saglabāts</p>";
                } else echo "<p id='messageWarn'>Kļūda</p>";

                if (is_uploaded_file($_FILES["file"]["tmp_name"])) {
                    move_uploaded_file($_FILES["file"]["tmp_name"], "../style/img/" . $picture);
                } else {
                    echo"<p id='message'>Saglabāts</p>";
                }
            } else echo"<p id='messageWarn'>XSS</p>";
        }

        else if($_POST['new']=='courses') {
            if ($_SESSION['account_type'] != 1) {
                echo "<p id='messageWarn'>Nav pieejas!</p>";
            } else {
                if ($this->CRSFToken->validateCrsfToken($_POST['CSRFName'], $_POST['CSRFValue'])) {
                    $date = $_POST['date'];
                    $sql->insert('courses');
                    $sql->columns(array('date'));
                    $sql->values(array($date));
                    $res = $sql->runQuery();

                    if ($res) {
                        echo "<p id='message'>Kursi pievienoti!</p>";
                    } else echo "<p id='messageWarn'>Kļūda!</p>";
                } else echo "<p id='messageWarn'>XSS</p>";
            }
        }
    }




}