<?php
include_once "01-header.php";
?>
<div id="homeScreen">
    <div id="gridMenu">
        <div class="gridMenuItem">
            <a href="03-01-spk.php" class="menuIcons">
                <img src="img/icons/pencil.svg" alt="Icon SPK">
                <div>
                    SPK
                </div>
            </a>
        </div>


        <div class="gridMenuItem">
            <a class="menuIcons" href="#">
                <img src="img/icons/checklist.svg" alt="Icon SPK">
                <div>
                    Nota
                </div>
            </a>
        </div>
        <div class="gridMenuItem">
            <div class="menuIcons">
                <img src="img/icons/email.svg" alt="Icon SPK">
            </div>
            Surat<br>
            Jalan
        </div>
        <div class="gridMenuItem">
            <a href="05-01-ekspedisi.php" class="menuIcons">
                <img src="img/icons/shipment.svg" alt="Icon SPK">
                <div>
                    Ekspedisi
                </div>
            </a>
        </div>
        <div class="gridMenuItem">
            <a href="04-01-pelanggan.php" class="menuIcons">
                <img src="img/icons/boy.svg" alt="Icon SPK">
                <div>
                    Pelanggan
                </div>
            </a>
        </div>
        <div class="gridMenuItem">
            <div class="menuIcons">
                <img src="img/icons/pencil.svg" alt="Icon SPK">
            </div>
            Database<br>
            Stok
        </div>
        <div class="gridMenuItem">
            <div class="menuIcons">
                <img src="img/icons/pencil.svg" alt="Icon SPK">
            </div>
            Produk
        </div>
        <div class="gridMenuItem">
            <div class="menuIcons">
                <img src="img/icons/pencil.svg" alt="Icon SPK">
            </div>
            Bahan<br>
            Baku
        </div>
    </div>
</div>
<style>
    body {
        background-color: #ffb800;
    }

    #homeScreen {
        margin: 1em;
        padding: 1em;
        background-color: white;
    }

    #gridMenu {
        display: grid;
        grid-template-columns: auto auto auto;
        grid-row-gap: 2em;
    }

    .gridMenuItem {
        text-align: center;
    }

    .menuIcons>img {
        object-fit: cover;
        width: 3em;
    }
</style>
<?php
include_once "01-footer.php";
?>