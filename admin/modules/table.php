<?php

class table {

    function createTable($sql)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET')
        $sql->select();
        $sql->from(array($_GET['page']));
        $where = null;

        if($_GET['page']=='products') {
            $where = array("typeID" => $_GET['type']);
            $sql->where(array("typeID" => $_GET['type']),"=");
        }
        else if($_GET['page']=='resource') {
            $where = array("type" => $_GET['type']);
            $sql->where(array("type" => $_GET['type']),"=");
        }
        else if($_GET['page']=='user') {
            $where = array("is_admin" => $_GET['type']);
            $sql->where(array("is_admin" => $_GET['type']),"=");
        }

        if ($_GET['page'] != 'products' && $_SESSION['account_type'] != 1) {
            echo "<p id='messageWarn'>Nav pieejas!</p>";
        } else {

            if (!isset($_GET['p']) || ($_GET['p'] < 0) || !is_numeric($_GET['p'])) {
                $page = 0;
            } else {
                $page = $_GET['p'];
            }

            $sql->limit($page * 10, 10);
            $object = $sql->runQuery();

            //////////////////////////////////////// Heading row
            echo "<table>";

            $page = $_GET['page'];
            $type = $_GET['type'];

            echo "<tr>";

            if (count($object)) {
                foreach ($object[0] as $key => $value) {
                    if (($key != 'password') && ($key != 'description') && ($key != 'photo') && ($key != 'format') && ($key != 'picture') && ($key != 'typeID')) {
                        echo "<td style='background-color: #555; color: #dedede;'><b>$key</b></td>";
                    }
                }
                if ($_GET['page'] == 'courses') {
                    echo "<td style='background-color: #555; color: #dedede;'><b>Aizsūtīt apstiprinājumu</b></td>";
                }
            }
            if ($_GET['page'] != 'student') {
                echo "<td class='ho2' ><a href=index.php?new=$page&type=$type>Jauns</a></td>";

                echo "</tr>";
            } else {
                echo "<td class='ho2' ></a></td>";
                echo "</tr>";
            }

            //////////////////////////////////////// Content row
            for ($i = 0; $i < count($object); $i++) {
                echo "<tr>";

                foreach ($object[$i] as $key => $value) {
                    if (($key != 'password')
                        && ($key != 'description')
                        && ($key != 'photo')
                        && ($key != 'format')
                        && ($key != 'picture')
                        && ($key != 'typeID')
                    ) {
                        echo "<td>" . htmlspecialchars($value) . "</td>";
                    }
                }

                if ($_GET['page'] == 'resource') {
                    echo "<td class='ho'><a href=index.php?adr=resource&edit=" . $object[$i]->id . "&type=" . $object[$i]->type . ">Labot</a></td>";
                } else if ($_GET['page'] == 'user') {
                    echo "<td class='ho'><a href=index.php?adr=user&edit=" . $object[$i]->id . "&username=" . $object[$i]->username . ">Labot</a></td>";
                } else if ($_GET['page'] == 'file') {
                    echo "<td class='ho'><a href=index.php?adr=file&edit=" . $object[$i]->id . "&title=" . $object[$i]->title . ">Labot</a></td>";
                } else if ($_GET['page'] == 'student') {
                    echo "<td class='ho'><a href=index.php?adr=student&edit=" . $object[$i]->id . ">Parādīt</a></td>";
                } else if ($_GET['page'] == 'products') {
                    echo "<td class='ho'><a href=index.php?adr=products&edit=" . $object[$i]->id . "&type=" . $object[$i]->typeID . ">Labot</a></td>";
                } else if ($_GET['page'] == 'courses') {
                    echo "<td class='ho'><a href=index.php?adr=courses&send=" . $object[$i]->id . ">Aizsūtīt</a></td>";
                    echo "<td class='ho'><a href=index.php?adr=courses&edit=" . $object[$i]->id . ">Labot</a></td>";
                }

                echo "</tr>";
            }
            echo "</table>";

            $sql->select();
            $sql->from(array($_GET['page']));
            if ($where != null) {
                $sql->where($where, '=');
            }
            $count = $sql->runQuery();
            $count = count($count);

            ?>

            <div class="paginate paginate-dark wrapper">
                <ul>
                    <?php for ($i = 0; $i <= ($count / 10); $i++) { ?>
                        <li><a href="http://oksalis-latvia.esy.es/admin/index.php?
                    <?php echo 'page=' . $_GET['page'] . '&type=' . $_GET['type'] . '&p=' . $i ?>"
                                <?php if ($i == $_GET['p']) {
                                    echo 'class="active"';
                                } ?>>
                                <?php echo $i; ?></a></li>
                    <?php } ?>
                </ul>
            </div>
        <?php
        }
    }
}