<?php

class change
{
    private $CRSFToken;

    public function __construct()
    {
        $this->CRSFToken = new CreateCrsfToken;
    }

    public function edit($sql)
    {
        if ((isset($_GET['edit'])) && ($_SERVER['REQUEST_METHOD'] == 'GET') && ($_GET['adr'] == 'resource')) {
            $id = $_REQUEST['edit'];

            $sql->select();
            $sql->from(array('resource'));
            $sql->where(array('id' => $id), "=");
            $object = $sql->runQuery();

            $sql->select();
            $sql->from(array('resourcemeta'));
            $sql->where(array('resource_id' => $id), "=");
            $objectmeta = $sql->runQuery();

            ?>

            <form action="" method="post" id="form">

                Nosaukums
                <input type="text" name="title" value="<?php echo htmlspecialchars($object[0]->title); ?>"/>
                Datums
                <input type="date" name="date" value="<?php echo htmlspecialchars($object[0]->date) ?>"/>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>"/>
                <input type="hidden" name="ptype" value="<?php echo htmlspecialchars($_GET['adr']); ?>"/>

                <?php
                require_once('../system/fields.php');
                require_once('field/' . $object[0]->type . '.php');

                $newobj = new fields;
                $post = new $object[0]->type;

                $post->setFields($objectmeta);
                echo implode($newobj->fieldToHTML($post->getFields()));
                ?>
                <br>
                <input type="submit" name="send" id="send"/>

            </form>
            <form action="" method="post" id="delete"
                  style="background-image: url('../style/img/triangular.png'); margin-top: 0; padding-bottom: 10px; ">
                <input type="submit" name="delete" value="Delete"/>
                <input type="hidden" name="id" value="<?php echo $id ?>"/>
                <input type="hidden" name="pTypeDel" value="<?php echo $_GET['adr'] ?>"/>
                <input type="hidden" name="CSRFName" value="<?php $CSRFName = md5(time() . '-DEL');
                echo $CSRFName; ?>"/>
                <input type="hidden" name="CSRFValue"
                       value="<?php echo $this->CRSFToken->createCrsfToken($CSRFName); ?>"/>
            </form>


        <?php
        } else if ((isset($_GET['edit'])) && ($_SERVER['REQUEST_METHOD'] == 'GET') && ($_GET['adr'] == 'user')) {
            if ($_SESSION['account_type'] != 1) {
                echo "<p id='messageWarn'>Nav pieejas!</p>";
            } else {
                $sql->select();
                $sql->from(array('user'));
                $sql->where(array('id' => $_GET['edit']), "=");
                $object = $sql->runQuery();
                $id = $_REQUEST['edit'];
                ?>


                <form action="" method="post" class="users">

                    Lietotāja vārds <br>
                    <input readonly type="text" name="username"
                           value="<?php echo htmlspecialchars($object[0]->username); ?>"/><br><br>
                    Parole <br>
                    <input type="text" name="password" placeholder="Enter new password"/> <br><br>
                    Saits <br>
                    <input type="text" name="sait"
                           value="<?php echo htmlspecialchars($object[0]->sait); ?>"/><br><br>
                    Vārds <br>
                    <input type="text" name="name"
                           value="<?php echo htmlspecialchars($object[0]->name); ?>"/><br><br>
                    Uzvārds <br>
                    <input type="text" name="surname" value="<?php echo htmlspecialchars($object[0]->surname); ?>"/><br><br>
                    Reģistrācijas datums <br>
                    <input  type="date" name="date" class="dateWidth"
                           value="<?php echo htmlspecialchars($object[0]->date); ?>"/><br><br>
                    Lietotāja tips<br>
                    <input type="text" name="is_admin"
                           value="<?php echo htmlspecialchars($object[0]->is_admin); ?>"/><br><br>
                    <input type="hidden" name="ptype" value="<?php echo $_GET['adr'] ?>"/>
                    <input type="hidden" name="id" value="<?php echo $id ?>"/>
                    <input type="submit" name="send" value="Saglabāt">
                    <input type="hidden" name="CSRFName" value="<?php $CSRFName = md5(time());
                    echo $CSRFName; ?>"/>
                    <input type="hidden" name="CSRFValue"
                           value="<?php echo $this->CRSFToken->createCrsfToken($CSRFName); ?>"/>
                </form>
                <form action="" method="post" id="delete">
                    <input type="submit" name="delete" value="Izdzēst"/>
                    <input type="hidden" name="id" value="<?php echo $id ?>"/>
                    <input type="hidden" name="pTypeDel" value="<?php echo $_GET['adr'] ?>"/>
                    <input type="hidden" name="CSRFName" value="<?php $CSRFName = md5(time() . '-DEL');
                    echo $CSRFName; ?>"/>
                    <input type="hidden" name="CSRFValue"
                           value="<?php echo $this->CRSFToken->createCrsfToken($CSRFName); ?>"/>
                </form>
            <?php
            }
        }

        if ((isset($_GET['edit'])) && ($_SERVER['REQUEST_METHOD'] == 'GET') && ($_GET['adr'] == 'file')) {
            if ($_SESSION['account_type'] != 1) {
                echo "<p id='messageWarn'>Nav pieejas!</p>";
            } else {
                $id = $_REQUEST['edit'];

                $sql->select();
                $sql->from(array('file'));
                $sql->where(array('id' => $id), '=');
                $object = $sql->runQuery();

                $location = "url(../style/img/" . $object[0]->alias . ")";

                ?>
                <div id="testing">
                    <div id="picture" style="background-image: <?php echo $location ?>; height: 250px; ">
                    </div>

                    <div id="pict2">
                        <form action="" method="post" class="img" id="postimage" enctype="multipart/form-data"
                              onsubmit="return block2()">
                            <br>Nosaukums <br>
                            <input type="text" name="title" id="title1"
                                   value="<?php echo htmlspecialchars($object[0]->title); ?>"/><br><br>
                            Tips <br>
                            <input type="text" name="type" id="type"
                                   value="<?php echo htmlspecialchars($object[0]->type); ?>"/><br><br>
                            <input type="hidden" name="ptype" value="<?php echo $_GET['adr'] ?>"/>
                            <input type="hidden" name="id" value="<?php echo $id ?>"/>
                            <input type="submit" value="Saglabāt"><br>
                            <input type="hidden" name="CSRFName" value="<?php $CSRFName = md5(time());
                            echo $CSRFName; ?>"/>
                            <input type="hidden" name="CSRFValue"
                                   value="<?php echo $this->CRSFToken->createCrsfToken($CSRFName); ?>"/>
                        </form>
                        <form action="" method="post" style="background-image: none; background-color: #3a3a3a;">
                            <input type="submit" name="delete" value="Izdzēst"/>
                            <input type="hidden" name="alias" value="<?php echo $object[0]->alias ?>"/>
                            <input type="hidden" name="pTypeDel" value="<?php echo $_GET['adr'] ?>"/>
                            <input type="hidden" name="CSRFName" value="<?php $CSRFName = md5(time() . '-DEL');
                            echo $CSRFName; ?>"/>
                            <input type="hidden" name="CSRFValue"
                                   value="<?php echo $this->CRSFToken->createCrsfToken($CSRFName); ?>"/>
                        </form>
                    </div>
                </div>
            <?php
            }
        }

        if ((isset($_GET['edit'])) && ($_SERVER['REQUEST_METHOD'] == 'GET') && ($_GET['adr'] == 'student')) {
            if ($_SESSION['account_type'] != 1) {
                echo "<p id='messageWarn'>Nav pieejas!</p>";
            } else {
                $id = $_REQUEST['edit'];
                $sql->select();
                $sql->from(array('student'));
                $sql->where(array('id' => $id), '=');
                $object = $sql->runQuery();
                $location = "url('../style/photos/" . $object[0]->photo . "')";
                ?>
            <div id="divform">
                <span id="courseText">Students Nr. <?php echo htmlspecialchars($object[0]->id); ?></span>
                    <form method="post" enctype="multipart/form-data" action=''>
                        <div id="inputs">
                            <span>Vārds</span><input readonly type="text" name="name" value="<?php echo htmlspecialchars($object[0]->name); ?>"/><br><br><br>
                            <span>Uzvārds</span><input readonly type="text" name="surname" value="<?php echo htmlspecialchars($object[0]->surname) ?>"/><br><br><br>
                            <span>Dz. datums</span><input readonly type="date" name="date" value="<?php echo htmlspecialchars($object[0]->birthdate); ?>"/><br><br><br>
                            <span>Telefona numurs</span><input readonly type="tel" name="phone" value="<?php echo htmlspecialchars($object[0]->phone); ?>"/><br><br><br>
                            <span>E-pasts</span><input readonly type="email" name="email" value="<?php echo htmlspecialchars($object[0]->email); ?>"/><br><br><br>
                            <input type="hidden" name="pTypeDel" value="<?php echo $_GET['adr'] ?>"/>
                            <input type="hidden" name="photo" value="<?php echo $object[0]->photo ?>"/>
                            <input type="hidden" name="id" value="<?php echo $_GET['edit'] ?>"/>
                        </div>
                        <div id="photo" <?php
                if ($object[0]->photo != "") {
                    echo 'style="background-image:' . $location;
                }
                ?>"></div>
                        <div id="submits">
                            <input type="submit" name="delete" value="Izdzēst" id="pointer"/>
                            <input type="hidden" name="CSRFName" value="<?php $CSRFName = md5(time() . '-DEL');
                echo $CSRFName; ?>"/>
                            <input type="hidden" name="CSRFValue" value="<?php echo $this->CRSFToken->createCrsfToken($CSRFName); ?>"/>
                        </div>
                    </form>
                </div>
            <?php
            }
        }

        ////////////////////////////////////////////////////// Product

        if ((isset($_GET['edit'])) && ($_SERVER['REQUEST_METHOD'] == 'GET') && ($_GET['adr'] == 'products')) {
            $id = $_GET['edit'];

            $sql->select();
            $sql->from(array('products'));
            $sql->where(array('id' => $id), '=');
            $object = $sql->runQuery();

            $location = "url(../style/img/" . $object[0]->picture . ")";

            ?>
            <div id="testing2">
                <div id="picture2" style="background-image: <?php echo $location ?>; height: 350px; ">
                </div>
                <form action="" method="post" class="img" id="postimage" enctype="multipart/form-data"
                      onsubmit="return block3()">
                    <div id="pict4">
                        <br>
                        Nosaukums
                        <input type="text" name="name" id="title1"
                               value="<?php echo htmlspecialchars($object[0]->name); ?>"/><br><br><br>
                        Cena
                        <input type="text" name="price" id="type"
                               value="<?php echo htmlspecialchars($object[0]->price); ?>"/><br><br><br>
                        Daudzums
                        <input type="text" name="quantity" id="type"
                               value="<?php echo htmlspecialchars($object[0]->quantity); ?>"/><br><br><br>
                        Tips
                        <input type="text" name="typeKind" id="typeKind"
                               value="<?php echo htmlspecialchars($object[0]->typeKind); ?>"/><br><br><br>
                        Svars
                        <input type="text" name="weight" id="weight"
                               value="<?php echo htmlspecialchars($object[0]->weight); ?>"/><br><br>
                    </div>
                    <div class="productDescriptionAdminDiv">
                        Produkta apraksts<br>
                        <textarea class="productDescriptionAdmin ckeditor"
                                  name="productDescription"><?php echo $object[0]->description ?></textarea><br>
                        <input type="hidden" name="ptype" value="<?php echo htmlspecialchars($_GET['adr']); ?>"/>
                        <input type="hidden" name="picture" value="<?php echo $object[0]->picture ?>"/>
                        <input type="hidden" name="id" value="<?php echo $id ?>"/>
                        <input type="submit" value="Saglabāt" id="adminPanelButtonSubmit"><br>
                        <input type="hidden" name="CSRFName" value="<?php $CSRFName = md5(time());
                        echo $CSRFName; ?>"/>
                        <input type="hidden" name="CSRFValue"
                               value="<?php echo $this->CRSFToken->createCrsfToken($CSRFName); ?>"/>
                    </div>
                </form>
                <div class="productDescriptionAdminDivDel">
                    <form action="" method="post" id="delete" style="background-image: none; padding-bottom: 15px;">
                        <input type="submit" name="delete" value="Izdzēst" id="adminPanelButtonDelete"/>
                        <input type="hidden" name="alias" value="<?php echo $object[0]->picture ?>"/>
                        <input type="hidden" name="id" value="<?php echo $id ?>"/>
                        <input type="hidden" name="pTypeDel" value="<?php echo htmlspecialchars($_GET['adr']); ?>"/>
                        <input type="hidden" name="CSRFName" value="<?php $CSRFName = md5(time() . '-DEL');
                        echo $CSRFName; ?>"/>
                        <input type="hidden" name="CSRFValue"
                               value="<?php echo $this->CRSFToken->createCrsfToken($CSRFName); ?>"/>
                    </form>
                </div>
            </div>
        <?php
        }

        if (($_SERVER['REQUEST_METHOD'] == 'GET') && ($_GET['adr'] == 'courses') && isset($_GET['edit'])) {
            if ($_SESSION['account_type'] != 1) {
                echo "<p id='messageWarn'>Nav pieejas!</p>";
            } else {
                $id = $_GET['edit'];
                $sql->select();
                $sql->from(array('courses'));
                $sql->where(array('id' => $id), '=');
                $object = $sql->runQuery();
                ?>
                <div class="testingCourses">
                    <div class="divCourses">
                        <form method="post" class="img" id="coursesForm2">
                            Tekošais kursu sākuma datums: <?php echo $object[0]->date ?><br>
                            <br>Izvēlieties jaunu kursu sākuma datumu:
                            <input type="date" name="date" class="coursesInputDate" id="date"/>
                            <input type="hidden" name="ptype" value="<?php echo $_GET['adr'] ?>"/>
                            <input type="hidden" name="id" value="<?php echo $object[0]->id ?>"/>
                            <input type="submit" value="Saglabāt">
                            <input type="hidden" name="CSRFName" value="<?php $CSRFName = md5(time());
                            echo $CSRFName; ?>"/>
                            <input type="hidden" name="CSRFValue"
                                   value="<?php echo $this->CRSFToken->createCrsfToken($CSRFName); ?>"/>
                        </form>
                        <form method="post" id="coursesForm2" class="img">
                            Izdzēst kursus: <input type="submit" name="delete" value="Izdzēst">
                            <input type="hidden" name="id" value="<?php echo $id ?>"/>
                            <input type="hidden" name="pTypeDel" value="<?php echo $_GET['adr']; ?>"/>
                            <input type="hidden" name="CSRFName" value="<?php $CSRFName = md5(time() . '-DEL');
                            echo $CSRFName; ?>"/>
                            <input type="hidden" name="CSRFValue"
                                   value="<?php echo $this->CRSFToken->createCrsfToken($CSRFName); ?>"/>
                        </form>
                    </div>
                </div>
            <?php
            }
        }

        if (($_SERVER['REQUEST_METHOD'] == 'GET') && ($_GET['adr'] == 'courses') && isset($_GET['send'])) {
            if ($_SESSION['account_type'] != 1) {
                echo "<p id='messageWarn'>Nav pieejas!</p>";
            } else {
                $id = $_GET['send'];
                $sql->select();
                $sql->from(array('courses'));
                $sql->where(array('id' => $id), '=');
                $object = $sql->runQuery();

                $date = $object[0]->date;

                $sql->select();
                $sql->from(array('student'));
                $sql->where(array('courseID' => $id), '=');
                $count = $sql->runQuery();

                $stundetsWithPhoto = 0;
                $studentsOfAgeEighteen = 0;

                foreach ($count as $value) {
                    if ($value->photo != null) {
                        $stundetsWithPhoto++;
                    }
                    if (strtotime("-18 years") >= $value->birthdate) {
                        $studentsOfAgeEighteen++;
                    }
                }

                $sql->select(array('name', 'email'));
                $sql->from(array('student'));
                $sql->where(array('courseID' => $id), '=');
                $object = $sql->runQuery();

                $data = json_encode($object);

                ?>
                <div class="testingCourses">
                    <div class="divCourses">
                        <div class="courseMeta">
                            <b>Kursu sākuma datums: <?php echo $date; ?></b><br><br>
                            Studentu skaits: <?php echo count($count); ?><br>
                            Studentu skaits ar foto: <?php echo $stundetsWithPhoto; ?><br>
                            Pilngadīgo studentu skaits: <?php echo $studentsOfAgeEighteen; ?>
                        </div>
                        <div class="courseMetaButton">
                            <b>Aizsūtīt apstiprinājuma vēstules?</b><br><br>

                            <form method="post">
                                <input type="hidden" name="recipients" value="<?php echo base64_encode($data); ?>"/>
                                <input type="hidden" name="date" value="<?php echo $date ?>"/>
                                <input type="submit" value="Aizsūtīt">
                                <input type="hidden" name="CSRFName" value="<?php $CSRFName = md5(time());
                                echo $CSRFName; ?>"/>
                                <input type="hidden" name="CSRFValue"
                                       value="<?php echo $this->CRSFToken->createCrsfToken($CSRFName); ?>"/>
                            </form>
                        </div>
                    </div>
                </div>
            <?php
            }
        }
    }
}