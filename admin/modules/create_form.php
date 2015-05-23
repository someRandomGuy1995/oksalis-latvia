<?php

class create_form
{
    private $CRSFToken;

    public function __construct()
    {
        $this->CRSFToken = new CreateCrsfToken;
    }

    public function form()
    {
        $type = $_GET['type'];

        ///////////////////////////////////////////////////// Resource form

        if ($_GET['new']=='resource')
        {
            ?>
            <form action="" method="post" id="form">
                Nosaukums
                <input type="text" name="title" placeholder="Title"/>
                <input type='hidden' name='type' value= <?php echo $type ?> />
                Datums
                <input type="datetime-local" name="date" placeholder="Date"/>
                <input type='hidden' name='new' value='resource'/>

                <?php
                require_once('../system/fields.php');
                require_once('field/' . $_GET['type'] . '.php');
                $html = file_get_contents('../system/tpl/' . $_GET['type'] . '.tpl');
                echo $html;
                ?>
                <br>
                <input type="hidden" name="CSRFName" value="<?php $CSRFName = md5(time()); echo $CSRFName; ?>"/>
                <input type="hidden" name="CSRFValue" value="<?php echo $this->CRSFToken->createCrsfToken($CSRFName); ?>"/>
                <input type="submit" name="send" id="send" value="Saglabāt"/>
                <input type="hidden" name="CSRFName" value="<?php $CSRFName = md5(time()); echo $CSRFName; ?>"/>
                <input type="hidden" name="CSRFValue" value="<?php echo $this->CRSFToken->createCrsfToken($CSRFName); ?>"/>
            </form>

        <?php
        }

        ///////////////////////////////////////////////////// User form

        else if($_GET['new']=='user')
        {
            ?>

            <form action="" method="post" class="users">
                Lietotāja vārds <br>
                <input type="text" name="username" placeholder="Username" /><br><br>
                Parole <br>
                <input type="text" name="password" placeholder="Enter  password" /> <br><br>
                Saits <br>
                <input type="text" name="sait" placeholder="Site name"  /><br><br>
                Vārds <br>
                <input type="text" name="name" placeholder="Name"  /><br><br>
                Uzvārds <br>
                <input type="text" name="surname" placeholder="Surname"   />
                <input type="hidden" name="is_admin" value="<?php echo $_GET['type'] ?>" /><br><br>
                <input type="hidden" name="new" value="<?php echo $_GET['new'] ?>"/>
                <input type="submit" name="send" value="Saglabāt">
                <input type="hidden" name="CSRFName" value="<?php $CSRFName = md5(time()); echo $CSRFName; ?>"/>
                <input type="hidden" name="CSRFValue" value="<?php echo $this->CRSFToken->createCrsfToken($CSRFName); ?>"/>
            </form>

        <?php
        }

        //////////////////////////////////////////////////////////////////////////////////////////// NEW FILE
        else if($_GET['new']=='file')
        {
            ?>
            <div id="testing">
                <div id="picture">
                </div>
                <div id="pict">
                    <form  action="" method="post" class="img" id="postimage" enctype="multipart/form-data" onsubmit="return block()">
                        <br>Nosaukums<br>
                        <input type="text" name="title" id="title1"  /><br><br>
                        Tips<br>
                        <input type="text" name="type" id="type" /><br><br><br>
                        Fails<br><br>
                        <input type="file" name="file" onchange="image2();" id="cipocka"/>
                        <input type="hidden" name="new" value="<?php echo $_GET['new'] ?>"/>
                        <input type="submit" value="Saglabāt"><br>
                        <input type="hidden" name="CSRFName" value="<?php $CSRFName = md5(time()); echo $CSRFName; ?>"/>
                        <input type="hidden" name="CSRFValue" value="<?php echo $this->CRSFToken->createCrsfToken($CSRFName); ?>"/>
                    </form>
                </div>
            </div>

        <?php

        }

        //////////////////////////////////////////////////////////////////////////////////////////// NEW PRODUCTS
        else if($_GET['new']=='products')
        {
            ?>
            <div id="testing2">
                <div id="picture2">

                </div>

                    <form  action="" method="post" class="img" id="postimage" enctype="multipart/form-data" onsubmit="return block3()">
                        <div id="pict3">
                            <br>
                            Nosaukums
                            <input type="text" name="name" id="title1"  /><br><br><br>
                            Cena
                            <input type="text" name="price" id="price"  /><br><br><br>
                            Skaits
                            <input type="text" name="quantity" id="type" /><br><br><br>
                            Tips
                            <input type="text" name="typeKind" id="typeKind" /><br><br><br>
                            Svars
                            <input type="text" name="weight" id="weight" /><br><br>
                        </div>
                        <div class="productDescriptionAdminDiv">
                            <br>
                            Produkta apraksts<br>
                            <textarea class="productDescriptionAdmin" name="productDescription">Apraksts</textarea><br>
                            <input type="file" name="file" onchange="image();" id="adminPanelButtonBrowse"/>
                            <input type="hidden" name="new" value="<?php echo $_GET['new'] ?>"/>
                            <input type="hidden" name="typeID" value="<?php echo $_GET['type'] ?>"/>
                            <input type="submit" value="Saglabāt"><br>
                            <input type="hidden" name="CSRFName" value="<?php $CSRFName = md5(time()); echo $CSRFName; ?>"/>
                            <input type="hidden" name="CSRFValue" value="<?php echo $this->CRSFToken->createCrsfToken($CSRFName); ?>"/>
                        </div>
                    </form>
            </div>

        <?php
        }
        else if($_GET['new']=='courses')
        {
            ?>
            <div class="testingCourses">
                <div class="divCourses">
                    <form  method="post" id="coursesForm">
                        <b>Jaunu kursu pievienošana</b><br><br>
                        Izvēlieties datumu:
                        <input type="date" name="date" class="coursesInputDate" id="date"/>
                        <input type="hidden" name="new" value="courses"/>
                        <input type="submit" value="Saglabāt"><br>
                        <input type="hidden" name="CSRFName" value="<?php $CSRFName = md5(time()); echo $CSRFName; ?>"/>
                        <input type="hidden" name="CSRFValue" value="<?php echo $this->CRSFToken->createCrsfToken($CSRFName); ?>"/>
                    </form>
                </div>
            </div>

        <?php
        }
    }
}