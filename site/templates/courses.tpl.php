<?php
if($_SERVER['REQUEST_METHOD']=='POST'
    && isset($_POST['name'])
    && isset($_POST['surname'])
    && isset($_POST['date'])
    && isset($_POST['email'])
    && isset($_POST['phone'])) {

    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $birthDate = $_POST['date'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $photo = $_FILES["file"]["name"];
    $thisDate = date("Y-m-d");

    $sql->select();
    $sql->from(array('student'));
    $sql->where(array('email' => $email), '=');
    $result = $sql->runQuery();
    if ($result == false) {

        ?>
        <div class="alert-success">
            <a href="#" id="close" data-dismiss="alert">&times;</a>
            <strong>Apstiprināts!</strong> Jūsu pieteikums tika veiksīgi aizsūtīts.
        </div>
        <?php

        $sql->select();
        $sql->from(array('courses'));
        $sql->where(array('date' => $thisDate), '>');
        $sql->orderBy('date', 'ASC');
        $result = $sql->runQuery();

        $courseID = $result[0]->id;
        $participants = $result[0]->participants + 1;

        $sql->update('courses');
        $sql->set(array('participants' => $participants));
        $sql->where(array('id' => $courseID) ,"=");
        $result = $sql->runQuery();


        $sql->insert('student');
        $sql->columns(array('name', 'surname', 'birthdate', 'phone', 'email', 'photo', 'thisdate', 'courseID'));
        $sql->values(array($name, $surname, $birthDate, $phone, $email, $photo, $thisDate, $courseID));
        $result = $sql->runQuery();

        if (is_uploaded_file($_FILES["file"]["tmp_name"])) {
            move_uploaded_file($_FILES["file"]["tmp_name"], "../style/photos/" . $_FILES["file"]["name"]);
        }
    } else {
        ?>
        <div class="alert-warning">
            <a href="#" id="close" data-dismiss="alert">&times;</a>
            <strong>Kļūda!</strong> Lietotājs ar tādu e-pastu jau eksistē.
        </div>
        <?php

    }
}
?>

<div class="courses">
    <div class="column1">
        <span class="courseText">Informācija</span>
        <div class="coursePlace1"></div>
        <p>
            <b>Vieta:</b><br>
            Medību kursi notiek 1. vidusskolas īrētā konferenču zālē.<br>
            Adrese: Dzirnavu iela 3a, Rēzekne, LV 4601.
        </p>
        <div class="coursePlace2"></div>
        <p>
            <b>Medību instruktors:</b><br>
            Medību kursu vadītājs ir Ivans Adejanovs.<br>
            Instruktors ar lielu medību pieredzi.
        </p>
        <div class="coursePlace3"></div>
        <p>
            <b>Šautuve:</b><br>
            Praktiskā apmācību daļa notiek šautuvē ārpus Rēzeknes,
            kas atrodas ~10 kilometru attālumā.
        </p>
    </div>
    <div class="column2">
        <span class="courseText">Medību kursi</span>
        <p class="courseP">
            Mednieki ir tie, kas vislabāk pārzina Latvijas mežus un faunu, viņi ir tie, kas rūpējas par meža dzīvniekiem ziemā,
            kā arī cīnās ar plēsējiem, kas apdraud Latvijas putnus un mazos zīdītājus.
            Mednieku intereses būtībā saskan ar dabas aizsardzības interesēm, jo ko tad mednieks darīs,
            ja mežā nebūs dzīvnieku, upēs un ezeros pīļu?
            Mednieki ir tie, kas vislabāk pārzina Latvijas mežus un faunu, viņi ir tie, kas rūpējas par meža dzīvniekiem ziemā,
            kā arī cīnās ar plēsējiem, kas apdraud Latvijas putnus un mazos zīdītājus.
            Mednieki ir tie, kas vislabāk pārzina Latvijas mežus un faunu, viņi ir tie, kas rūpējas par meža dzīvniekiem ziemā,
            kā arī cīnās ar plēsējiem, kas apdraud Latvijas putnus un mazos zīdītājus.
        </p>
    </div>
    <div class="column3">
        <span class="courseText">Cenas</span>
        <div class="coursePlace4"></div>
        <p>
            <b>Medību kursi:</b><br>
            Medību kursu cena ir 120 euro<br>
            Ieskaitot PVN.
        </p>
        <div class="coursePlace5"></div>
        <p>
            <b>Nodarbības šautuvē:</b><br>
            Nodarbības šautuvē izmaksā 20 euro par 1 nodarbību.<br>
        </p>
        <div class="coursePlace6"></div>
        <p>
            <b>Medību ekzāmens:</b><br>
            Maksa par medību ekzāmena praktisko daļu ir 16 euro.
            Par katru nākamo mēģinājumu cena ir 40 euro.
        </p>
    </div>
    <hr style="margin: 20px 0">
    <button id="showForm">Aizpildīt pieteikšanās formu</button>
    <div class="courseApply">
        <span class="courseText2">Pieteikšanās forma medību kursiem</span>
        <form method="post" enctype="multipart/form-data" id="courseForm">
            <div class="courseApplyInputs">
                <span class="courseSpace">Vārds</span><input type="text" name="name" id="inputField"/><br><br>
                <span class="courseSpace">Uzvārds</span><input type="text" name="surname" id="inputField"/><br><br>
                <span class="courseSpace">Dz. datums</span><input type="date" name="date" id="inputField"/><br><br>
                <span class="courseSpace">Telefona numurs</span><input type="tel" name="phone" id="inputField"/><br><br>
                <span class="courseSpace">E-pasts</span><input type="email" name="email" id="inputField"/><br><br>
            </div>
            <div class="coursePhotoPrev">
                <div class="coursePhoto"></div>
                <div class="coursePhotoInput">
                    <input type="file" name="file" id="file" onchange="image()"/>
                </div>
            </div>
            <br>
            <div class="courseSubmit">
                <input type="reset" value="Izdzēst" id="pointer"/>
                <input type="submit" value="Apstiprināt" id="submitCoursesForm" disabled='disabled'/>
            </div>
        </form>
    </div>
</div>
    