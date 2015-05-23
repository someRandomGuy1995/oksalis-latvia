<?php

require_once('../require.php');

require_once('protection/CreateCrsfToken.php');
require_once('protection/Session.php');

//header("Content-Security-Policy: default-src 'self'; script-src 'self';");

if((isset($_SESSION['account_type']))&&($_SESSION['account_type'] == 1 || $_SESSION['account_type'] == 0)) {

    ?>

    <html>
    <head onclick="real()">
        <link rel="stylesheet" href="style/cmsstyle.css" type="text/css">
        <link rel="stylesheet" href="style/pagination.css" type="text/css">
        <meta charset="UTF-8">
    </head>
    <body>
    <script src="js/jquery-1.11.2.js"></script>
    <script type="text/javascript" src="js/ajax.js"></script>
    <div class="exitWrapper">
        <div class="exitDIv"><?php echo $_SESSION['user']; ?></div>
        <form class="exit" method="post"> <input type="hidden" name="exit" value="1"><button type="submit" class="exitButton">Iziet</button></form>
    </div>

    <span id="head"><a href="index.php">Oksalis</a></span><br><br>
    <ul>
        <li>
            Preces
            <ul>
                <?php
                ///////////////////////////////////////////////////////////////////////////////////////////MAIN MENU
                $sql->select();
                $sql->from(array('product_type'));
                $obj = $sql->runQuery();

                foreach ($obj as $dump) {
                    echo "<li>";
                    echo "<a href=index.php?page=products&type=" . $dump->id . "&p=0>" . $dump->type . "</a>";
                    echo "</li>";
                }
                ?>
            </ul>
        </li>
        <li>Lietotāji
            <ul>
                <li><a href="index.php?page=user&type=1&p=0">Administrātori</a></li>
                <li><a href="index.php?page=user&type=0&p=0">Lietotāji</a></li>
                <li><a href="index.php?page=student&type=students&p=0">Studenti</a></li>
            </ul>
        </li>
        <li> Bildes
            <ul>
                <li><a href="index.php?page=file&type=pic&p=0">Visas bildes</a></li>
            </ul>
        </li>
        <li> Kursi
            <ul>
                <li><a href="index.php?page=courses&p=0">Visi kursi</a></li>
            </ul>
        </li>
    </ul>

    <?php
    if (isset($_POST['exit']) && $_POST['exit'] == 1) {
        $_SESSION = [];
        header('Location: ../login.php');
    }

    if (isset($_GET['page'])) {
        $table = new table();
        $table->createTable($sql);
    }
    if ((isset($_GET['new'])) && ($_SERVER['REQUEST_METHOD'] == 'GET')) {
        $form = new create_form();
        $form->form();
    }
    if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['new'])) {
        $new = new create();
        $new->create_new($sql);
    }
    if (($_SERVER['REQUEST_METHOD'] == 'GET') && (isset($_GET['adr'])) && (isset($_GET['edit']) || isset($_GET['send']))) {
        $edit = new change();
        $edit->edit($sql);
    }
    if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['ptype'])) {
        $upd = new update();
        $upd->upd($sql);
    }
    if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['delete'])) {
        $del = new DEL();
        $del->delete($sql);
    }
    if (($_SERVER['REQUEST_METHOD'] == 'GET') && (!(isset($_GET['page']))) && (!(isset($_GET['adr']))) && (!(isset($_GET['new'])))) {
        $logo = new start();
        echo $logo->logo();
    }
    if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['recipients']) && isset($_POST['date'])) {
        $CRSFToken = new CreateCrsfToken();
        if ($CRSFToken->validateCrsfToken($_POST['CSRFName'], $_POST['CSRFValue'])) {
            $email = new email;
            $recipients = json_decode(base64_decode($_POST['recipients']));
            foreach ($recipients as $recipient) {
                $email->sendEmail($recipient->email, $recipient->name, $_POST['date']);
            }
            echo "<p id='message'>Vēstules nosūtītas!</p>";
        }  else echo"<p id='message'>XSS</p>";
    }
    ?>

    </body>
    </html>

<?php
}
else header('Location: ../login.php');
