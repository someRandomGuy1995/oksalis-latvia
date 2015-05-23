
<?php

if (!isset($_GET['item'])) {

    ?>
    <div class="shop">
        <div id="shopSlider">
            <div class="sliderText">OKSALIS</div>
            <ul class="slides">
                <li class="slide"><img      src="../style/img/w6.jpg"    width="1050px"></li>
                <li class="slide"><img      src="../style/img/w11.jpg"   width="1050px"></li>
                <li class="slide"><img      src="../style/img/w7.jpg"    width="1050px"></li>
                <li class="slide"><img      src="../style/img/w8.jpg"    width="1050px"></li>
                <li class="slide"><img      src="../style/img/w6.jpg"    width="1050px"></li>
            </ul>
        </div>
        <div class="filterContainer">
            <div class="filter">
                <div class="home"><a href="core.php?page=main">Uz galveno</a></div>
                <input type="radio" name="radio1" value="cenaMin"/> Cena: augoša
                <input type="radio" name="radio1" value="cenaMax"/> Cena: dilstoša
                <input type="radio" name="radio1" value="nosA"/> Nosaukums а - z
                <input type="radio" name="radio1" value="nosZ"/> Nosaukums z - a
            </div>
        </div>
        <div class="sideContainer">
            <div class="sidebarDIV">
                <ul class="sidebar">
                    <li class="weapons">
                        <a href="core.php?page=shop&type=3" id="first">Ieroči</a>
                        <a href="core.php?page=shop&product=carabine">Karabīnes</a>
                        <a href="core.php?page=shop&product=shotgun">Bises</a>
                        <a href="core.php?page=shop&product=pneumatic">Pneumatiskās</a>
                    </li>
                    <li class="ammunition">
                        <a href="core.php?page=shop&type=4">Munīcija</a>
                        <a href="core.php?page=shop&product=bCarabine">Karabīnēm</a>
                        <a href="core.php?page=shop&product=bShotgun">Bisēm</a>
                        <a href="core.php?page=shop&product=bPneumatic">Pneumatiskām</a>
                    </li>
                    <li class="clothes">
                        <a href="core.php?page=shop&type=5">Apģērbi</a>
                        <a href="core.php?page=shop&product=summer">Vasarai</a>
                        <a href="core.php?page=shop&product=winter">Ziemai</a>
                        <a href="core.php?page=shop&product=seasonal">Starpsezonas</a>
                    </li>
                    <li class="accessories">
                        <a href="core.php?page=shop&type=6">Aksesuāri</a>
                        <a href="core.php?page=shop&product=knife">Naži</a>
                        <a href="core.php?page=shop&product=flash">Lukturi</a>
                        <a href="core.php?page=shop&product=optics" id="last">Optika</a>
                    </li>
                </ul>
            </div>
        </div>

        <div style="float:left; width: 717px" id="sjuda">
            <?php

            if (!(isset($_GET['product'])) && !(isset($_GET['type'])) && !(isset($_GET['item']))) {
                ?>

                <div class="category" style="background-image: url('../style/img/w6.jpg')">
                    <a class="categoryLink" href="http://oksalis-latvia.esy.es/site/core.php?page=shop&type=3" >
                        Ieroči
                    </a>
                </div>

                <div class="category" style="background-image: url('../style/img/catBullet2.jpg')">
                    <a class="categoryLink" href="http://oksalis-latvia.esy.es/site/core.php?page=shop&type=4" >
                        Munīcija
                    </a>
                </div>

                <div class="category" style="background-image: url('../style/img/catClothes.jpg')">
                    <a class="categoryLink" href="http://oksalis-latvia.esy.es/site/core.php?page=shop&type=5" >
                        Apģērbi
                    </a>
                </div>

                <div class="category" style="background-image: url('../style/img/catAccessories.jpg')">
                    <a class="categoryLink" href="http://oksalis-latvia.esy.es/site/core.php?page=shop&type=6" >
                        Aksesuāri
                    </a>
                </div>
               <?php



            } else if ((isset($_GET['product'])) && !(isset($_GET['item']))) {

                if (!isset($_GET['p']) || ($_GET['p'] < 0) || !is_numeric($_GET['p'])) {
                    $page = 0;
                } else {
                    $page = $_GET['p'];
                }

                $sql->select();
                $sql->from(array('products'));
                $sql->where(array('typeKind' => $_GET['product']), '=');
                $sql->limit($page * 12, 12);
                $result = $sql->runQuery();

                foreach ($result as $value) {
                    $url = '../style/img/' . $value->picture;
                    ?>

                    <div class="viewport" data-price="<?php echo $value->price; ?>" data-name="<?php echo $value->name; ?>">
                        <a href="core.php?page=shop&item=<?php echo $value->id ?>" >
                            <span class="dark-background">Apskatīt</span>
                            <img src="<?php echo $url ?>" alt="Item image" />
                        </a>
                        <div class="itemDes">
                            <div class="itemNam"><?php echo $value->name; ?></div>
                            <div class="itemPric">€ <?php echo $value->price; ?></div>
                        </div>
                    </div>
                <?php
                }

                $sql->select();
                $sql->from(array('products'));
                $sql->where(array('typeKind' => $_GET['product']), '=');
                $result = $sql->runQuery();
                ?>

                <div class='pagination'>
                    <div class="paginate paginate-dark wrapper">
                        <ul>
                            <?php for ($i = 0; $i <= (count($result) / 12); $i++) { ?>
                                <li>
                                    <a href="http://oksalis-latvia.esy.es/site/core.php?
                                        page=shop&
                                        product=<?php echo $_GET['product']; ?>&
                                        p=<?php echo $i; ?>"
                                        <?php if ($i == $_GET['p']){ echo 'class="active"';} ?>>
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>

                <?php

            } else if ((isset($_GET['type'])) && !(isset($_GET['item']))) {
                $sql->select();
                $sql->from(array('productCategory'));
                $sql->where(array('typeID' => $_GET['type']), '=');
                $result = $sql->runQuery();

                foreach($result as $record) {
                    $categoryUrl = "../style/img/".$record->picture.".jpg";
                    ?>
                <div class="category" style="background-image: url(<?php echo $categoryUrl ?>)">
                    <a class="categoryLink" href="http://oksalis-latvia.esy.es/site/core.php?page=shop&product=<?php echo htmlentities($record->name); ?>" >
                        <?php echo $record->title ?>
                    </a>
                </div>
                <?php
                }
            }
            ?>
        </div>

        <div class="clear"></div>
    </div>

<?php
} else {
    $sql->select();
    $sql->from(array('products'));
    $sql->where(array('id' => $_GET['item']), '=');
    $result = $sql->runQuery();
    $bg = "url('../style/img/" . $result[0]->picture . "')";

    if (count($result)){
    ?>

    <div class='itemHeader'>
        <span class="itemHeaderText">Medību veikals</span>
    </div>
        <div class="homeFromItem"><a href="core.php?page=main">Uz galveno</a></div>

        <div class="sideContainer" style="margin-top: 20px;">
            <div class="sidebarDIV">
                <ul class="sidebar">
                    <li class="weapons">
                        <a href="core.php?page=shop&type=3" id="first">Ieroči</a>
                        <a href="core.php?page=shop&product=carabine">Karabīnes</a>
                        <a href="core.php?page=shop&product=shotgun">Bises</a>
                        <a href="core.php?page=shop&product=pneumatic">Pneumatiskās</a>
                    </li>
                    <li class="ammunition">
                        <a href="core.php?page=shop&type=4">Amunīcija</a>
                        <a href="core.php?page=shop&product=bCarabine">Karabīnēm</a>
                        <a href="core.php?page=shop&product=bShotgun">Bisēm</a>
                        <a href="core.php?page=shop&product=bPneumatic">Pneumatiskām</a>
                    </li>
                    <li class="clothes">
                        <a href="core.php?page=shop&type=5">Apģērbi</a>
                        <a href="core.php?page=shop&product=summer">Vasarai</a>
                        <a href="core.php?page=shop&product=winter">Ziemai</a>
                        <a href="core.php?page=shop&product=seasonal">Starpsezonas</a>
                    </li>
                    <li class="accessories">
                        <a href="core.php?page=shop&type=6">Aksesuāri</a>
                        <a href="core.php?page=shop&product=knife">Naži</a>
                        <a href="core.php?page=shop&product=flash">Lukturi</a>
                        <a href="core.php?page=shop&product=optics" id="last">Optika</a>
                    </li>
                </ul>
            </div>
        </div>

    <div class='itemPhoto'>
        <img id="zoom_01"
            src=<?php echo "../style/img/" . $result[0]->picture; ?>
            data-zoom-image=<?php echo "../style/img/" . $result[0]->picture; ?>
            height="240px" width="300px"
        />
    </div>
    <div class='itemDescription'>
        <div class=itemName>
            <b>Produkta nosaukums: </b><?php echo $result[0]->name; ?><br>
            <b>Cena: </b> <?php echo $result[0]->price; ?> €<br>
            <b>Svars: </b> <?php echo $result[0]->weight; ?> kg<br>
            <b>Pievienošanas datums: </b> <?php echo $date = ($result[0]->date > 0) ? $result[0]->date : '2015.02.01'; ?><br>
            <b>Noliktavā: </b> <?php echo $result[0]->quantity; ?> <br>
        </div>
    </div>

    <div class="productDescription">
        <b>Apraksts</b><br><br>
        <?php echo $result[0]->description; ?>
    </div>

    <div class="pridumayClass">
        <a href="core.php?page=courses">Medību kursi</a>
    </div>

    <div class='relatedItemsText'> Līdzīgas preces </div>
    <div class='relatedItems'>
        <?php
        $sql->select();
        $sql->from(array('products'));
        $sql->where(array('typeID' => $result[0]->typeID), '=');
        $resultSame = $sql->runQuery();
        shuffle($resultSame);

        if (count($resultSame)>1){
        $counter = 0;
        foreach($resultSame as $product) {
            $counter++;
            if ($counter > 15 ) {
                break;
            }
            if ($result[0]->id != $product->id) {

                $bg = "url('../style/img/" . $product->picture . "')";
                ?>
                <div class='productWrapper'>
                    <div class='relatedProduct' style="background-image: <?php echo $bg ?>"></div>
                    <div class='relatedText'>
                        <a href="core.php?page=shop&item=<?php echo $product->id ?>"><?php echo $product->name; ?></a>
                    </div>
                </div>
            <?php

            }
        }
            ?>

    </div>

<?php
        }
    }
}
