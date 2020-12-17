<?php
include_once "01-header.php";

$htmlErrorReport = "<div id='divErrorReport'>";
$htmlSucceedReport = "<div id='divSuccedReport'>";
// Create connection
$conn = mysqli_connect("localhost", "root", "");
// Check connection
if (!$conn) {
    $htmlErrorReport = $htmlErrorReport . "Connection failed: " . mysqli_connect_error() . "<br><br>";
} else {
    $htmlSucceedReport = $htmlSucceedReport . "Connection established!<br><br>";
}

// Create database
$sql = "CREATE DATABASE mcparts";
if (mysqli_query($conn, $sql)) {
    $htmlSucceedReport = $htmlSucceedReport . "Database created successfully.<br><br>";
} else {
    if (mysqli_error($conn) === "Can't create database 'mcparts'; database exists") {
        $htmlSucceedReport = $htmlSucceedReport . mysqli_error($conn) . "<br><br>";
    } else {
        $htmlErrorReport = $htmlErrorReport . mysqli_error($conn) . "<br><br>";
    }
}

mysqli_close($conn);

include_once "01-config.php";
// TABEL EKSPEDISI

$query_cek_ekspedisi = "SELECT id FROM ekspedisi";
$res_cek_ekspedisi = mysqli_query($con, $query_cek_ekspedisi);

if (empty($res_cek_ekspedisi)) {
    $query_create_ekspedisi = "CREATE TABLE ekspedisi (
        id int(11) AUTO_INCREMENT PRIMARY KEY,
        nama varchar(100) NOT NULL,
        bentuk varchar(10) DEFAULT NULL,
        alamat varchar(200) NOT NULL,
        pulau_tujuan varchar(45) DEFAULT NULL,
        daerah_tujuan varchar(45) DEFAULT NULL,
        kontak varchar(45) DEFAULT NULL,
        keterangan varchar(200) DEFAULT NULL
      )ENGINE=InnoDB DEFAULT CHARSET=latin1";

    $res_create_ekspedisi = mysqli_query($con, $query_create_ekspedisi);

    if (!$res_create_ekspedisi) {
        $htmlErrorReport = $htmlErrorReport . $query_create_ekspedisi . " : FAILED! " . mysqli_error($con) . "<br><br>";
    } else {
        $htmlSucceedReport = $htmlSucceedReport .  "Create table ekspedisi SUCCEED!<br><br>";

        $file_ekspedisi = fopen("back-up/ekspedisi.sql", "r");
        if (!$file_ekspedisi) {
            $htmlErrorReport = $htmlErrorReport . "Open/read file ekspedisi.sql - FAILED!<br><br>";
        } else {
            $htmlSucceedReport = $htmlSucceedReport . "Open/read file ekspedisi.sql - SUCCEED!<br><br>";
            $query_retreive_backup_data_ekspedisi = fread($file_ekspedisi, filesize("back-up/ekspedisi.sql"));
            $htmlSucceedReport = $htmlSucceedReport . "INITIAL RETRIEVE BACK-UP EKSPEDISI:<br>" . $query_retreive_backup_data_ekspedisi . "<br><br>";
            $res_query_retrieve_backup_data_ekspedisi = mysqli_query($con, $query_retreive_backup_data_ekspedisi);
            if (!$res_query_retrieve_backup_data_ekspedisi) {
                $htmlErrorReport = $htmlErrorReport . $query_retreive_backup_data_ekspedisi . " - FAILED! " . mysqli_error($con) . "<br><br>";
            } else {
                $htmlSucceedReport = $htmlSucceedReport . "Retrieve back-up data ekspedisi - SUCCEED!<br><br>";
            }
        }
        fclose($file_ekspedisi);
    }
    // INSERT INTO ekspedisi
} else {
    $htmlSucceedReport = $htmlSucceedReport . "Table ekspedisi exist.<br><br>";
}

// ----- END -----

// TABLE PELANGGAN
$query_cek_pelanggan = "SELECT id FROM pelanggan";
$res_cek_pelanggan = mysqli_query($con, $query_cek_pelanggan);

if (empty($res_cek_pelanggan)) {
    $query_create_pelanggan = "CREATE TABLE pelanggan (
        id int(11) AUTO_INCREMENT PRIMARY KEY,
        nama varchar(100) NOT NULL,
        alamat varchar(200) DEFAULT NULL,
        pulau varchar(20) NOT NULL,
        daerah varchar(20) NOT NULL,
        kontak varchar(45) DEFAULT NULL,
        keterangan varchar(200) DEFAULT NULL,
        singkatan varchar(3) DEFAULT NULL,
        id_reseller int(11) DEFAULT NULL
      )ENGINE=InnoDB DEFAULT CHARSET=latin1";

    $res_create_pelanggan = mysqli_query($con, $query_create_pelanggan);
    if (!$res_create_pelanggan) {
        $htmlErrorReport = $htmlErrorReport . $query_create_pelanggan . " : FAILED! " . mysqli_error($con) . "<br><br>";
    } else {
        $htmlSucceedReport = $htmlSucceedReport .  "Create table pelanggan SUCCEED!<br><br>";

        $file_pelanggan = fopen("back-up/pelanggan.sql", "r");
        if (!$file_pelanggan) {
            $htmlErrorReport = $htmlErrorReport . "Open/read file pelanggan.sql - FAILED!<br><br>";
        } else {
            $htmlSucceedReport = $htmlSucceedReport . "Open/read file pelanggan.sql - SUCCEED!<br><br>";
            $query_retreive_backup_data_pelanggan = fread($file_pelanggan, filesize("back-up/pelanggan.sql"));
            $htmlSucceedReport = $htmlSucceedReport . "INITIAL RETRIEVE BACK-UP pelanggan:<br>" . $query_retreive_backup_data_pelanggan . "<br><br>";
            $res_query_retrieve_backup_data_pelanggan = mysqli_query($con, $query_retreive_backup_data_pelanggan);
            if (!$res_query_retrieve_backup_data_pelanggan) {
                $htmlErrorReport = $htmlErrorReport . $query_retreive_backup_data_pelanggan . " - FAILED! " . mysqli_error($con) . "<br><br>";
            } else {
                $htmlSucceedReport = $htmlSucceedReport . "Retrieve back-up data pelanggan - SUCCEED!<br><br>";
            }
        }
        fclose($file_pelanggan);
    }
    // INSERT INTO
} else {
    $htmlSucceedReport = $htmlSucceedReport . "Table pelanggan exist.<br><br>";
}

// ----- END -----

// TABEL pelanggan_use_ekspedisi

$query_cek_pelanggan_use_ekspedisi = "SELECT id FROM pelanggan_use_ekspedisi";
$res_cek_pelanggan_use_ekspedisi = mysqli_query($con, $query_cek_pelanggan_use_ekspedisi);

if (empty($res_cek_pelanggan_use_ekspedisi)) {
    $query_create_pelanggan_use_ekspedisi = "CREATE TABLE pelanggan_use_ekspedisi (
        id int(11) AUTO_INCREMENT PRIMARY KEY,
        id_ekspedisi int(11) NOT NULL,
        id_pelanggan int(11) NOT NULL,
        ekspedisi_transit char(1) NOT NULL DEFAULT 'n',
        ekspedisi_utama char(1) NOT NULL DEFAULT 'n'
      )ENGINE=InnoDB DEFAULT CHARSET=latin1;";

    $res_create_pelanggan_use_ekspedisi = mysqli_query($con, $query_create_pelanggan_use_ekspedisi);
    if (!$res_create_pelanggan_use_ekspedisi) {
        $htmlErrorReport = $htmlErrorReport . $query_create_pelanggan_use_ekspedisi . " : FAILED! " . mysqli_error($con) . "<br><br>";
    } else {
        $htmlSucceedReport = $htmlSucceedReport . "Create table pelanggan_use_ekspedisi SUCCEED!<br><br>";

        $query_fk_pelanggan_use_ekspedisi = "
        ALTER TABLE pelanggan_use_ekspedisi
        ADD CONSTRAINT pelanggan_use_ekspedisi_ibfk_1 FOREIGN KEY (id_ekspedisi) REFERENCES ekspedisi (id) ON DELETE CASCADE ON UPDATE CASCADE,
        ADD CONSTRAINT pelanggan_use_ekspedisi_ibfk_2 FOREIGN KEY (id_pelanggan) REFERENCES pelanggan (id) ON DELETE CASCADE ON UPDATE CASCADE;";

        $res_fk_pelanggan_use_ekspedisi = mysqli_query($con, $query_fk_pelanggan_use_ekspedisi);

        if (!$res_fk_pelanggan_use_ekspedisi) {
            $htmlErrorReport = $htmlErrorReport . $query_fk_pelanggan_use_ekspedisi . " : FAILED!" . mysqli_error($con) . "<br><br>";
        } else {
            $htmlSucceedReport = $htmlSucceedReport . $query_fk_pelanggan_use_ekspedisi . " : SUCCEED!<br><br>";

            // RETRIEVE BACK-UP DATA pelanggan_use_ekspedisi
            $file_pelanggan_use_ekspedisi = fopen("back-up/pelanggan_use_ekspedisi.sql", "r");
            if (!$file_pelanggan_use_ekspedisi) {
                $htmlErrorReport = $htmlErrorReport . "Open/read file pelanggan_use_ekspedisi.sql - FAILED!<br><br>";
            } else {
                $htmlSucceedReport = $htmlSucceedReport . "Open/read file pelanggan_use_ekspedisi.sql - SUCCEED!<br><br>";
                $query_retreive_backup_data_pelanggan_use_ekspedisi = fread($file_pelanggan_use_ekspedisi, filesize("back-up/pelanggan_use_ekspedisi.sql"));
                $htmlSucceedReport = $htmlSucceedReport . "INITIAL RETRIEVE BACK-UP pelanggan_use_ekspedisi:<br>" . $query_retreive_backup_data_pelanggan_use_ekspedisi . "<br><br>";
                $res_query_retrieve_backup_data_pelanggan_use_ekspedisi = mysqli_query($con, $query_retreive_backup_data_pelanggan_use_ekspedisi);
                if (!$res_query_retrieve_backup_data_pelanggan_use_ekspedisi) {
                    $htmlErrorReport = $htmlErrorReport . $query_retreive_backup_data_pelanggan_use_ekspedisi . " - FAILED! " . mysqli_error($con) . "<br><br>";
                } else {
                    $htmlSucceedReport = $htmlSucceedReport . "Retrieve back-up data pelanggan_use_ekspedisi - SUCCEED!<br><br>";
                }
            }
            fclose($file_pelanggan_use_ekspedisi);
        }
    }
    // INSERT INTO pelanggan_use_ekspedisi
} else {
    $htmlSucceedReport = $htmlSucceedReport . "Table pelanggan_use_ekspedisi exist.<br><br>";
}

// ----- END -----

// TABEL produk

$query_cek_produk = "SELECT id FROM produk";
$res_cek_produk = mysqli_query($con, $query_cek_produk);

if (empty($res_cek_produk)) {
    $query_create_produk = "CREATE TABLE produk (
        id int(11) AUTO_INCREMENT PRIMARY KEY,
        tipe varchar(20) NOT NULL,
        bahan varchar(20) DEFAULT NULL,
        varia varchar(20) DEFAULT NULL,
        ukuran varchar(20) DEFAULT NULL,
        logo varchar(20) DEFAULT NULL,
        tato varchar(20) DEFAULT NULL,
        jahit varchar(20) DEFAULT NULL,
        nama_lengkap varchar(100) DEFAULT NULL,
        japstyle int(11) DEFAULT NULL,
        harga_price_list int(11) DEFAULT NULL
      )ENGINE=InnoDB DEFAULT CHARSET=latin1";

    $res_create_produk = mysqli_query($con, $query_create_produk);
    if (!$res_create_produk) {
        $htmlErrorReport = $htmlErrorReport .  $query_create_produk . " : FAILED! " . mysqli_error($con) . "<br><br>";
    } else {
        $htmlSucceedReport = $htmlSucceedReport . "Create table produk SUCCEED!<br><br>";
    }
    // INSERT INTO produk
} else {
    $htmlSucceedReport = $htmlSucceedReport . "Table produk exist.<br><br>";
}

// ----- END -----

// TABEL SPK
$query_cek_spk = "SELECT id FROM spk";
$res_cek_spk = mysqli_query($con, $query_cek_spk);
if (empty($res_cek_spk)) {
    $query_create_spk = "CREATE TABLE spk (
        id int(11) AUTO_INCREMENT PRIMARY KEY,
        no_spk varchar(45) NOT NULL,
        tgl_pembuatan date NOT NULL,
        tgl_selesai date DEFAULT NULL,
        ket_judul varchar(200) DEFAULT NULL,
        catatan_kaki varchar(200) DEFAULT NULL,
        id_pelanggan int(11) DEFAULT NULL,
        no_nota varchar(45) DEFAULT NULL,
        tgl_nota date DEFAULT NULL,
        no_surat_jalan varchar(45) DEFAULT NULL,
        tgl_surat_jalan date DEFAULT NULL,
        koli int(11) DEFAULT NULL,
        harga int(11) DEFAULT NULL
      )ENGINE=InnoDB DEFAULT CHARSET=latin1";

    $res_create_spk = mysqli_query($con, $query_create_spk);
    if (!$res_create_spk) {
        $htmlErrorReport = $htmlErrorReport . $query_create_spk . " : FAILED! " . mysqli_error($con) . "<br><br>";
    } else {
        $htmlSucceedReport = $htmlSucceedReport . "Create table spk SUCCEED!<br><br>";
    }
} else {
    $htmlSucceedReport = $htmlSucceedReport . "Table spk exist.<br><br>";
}

// ----- END -----

// TABEL spk_contains_produk

$query_cek_spk_contains_produk = "SELECT id FROM spk_contains_produk";
$res_cek_spk_contains_produk = mysqli_query($con, $query_cek_spk_contains_produk);
if (empty($res_cek_spk_contains_produk)) {
    $query_create_spk_contains_produk = "CREATE TABLE spk_contains_produk (
        id int(11) AUTO_INCREMENT PRIMARY KEY,
        id_spk int(11) NOT NULL,
        id_produk int(11) NOT NULL,
        ktrg varchar(256) DEFAULT NULL,
        jumlah int(11) DEFAULT NULL,
        harga_item int(11) DEFAULT NULL,
        koreksi_harga int(11) DEFAULT NULL
      )ENGINE=InnoDB DEFAULT CHARSET=latin1;";

    $res_create_spk_contains_produk = mysqli_query($con, $query_create_spk_contains_produk);
    if (!$res_create_spk_contains_produk) {
        $htmlErrorReport = $htmlErrorReport . $query_create_spk_contains_produk . " : FAILED! " . mysqli_error($con) . "<br><br>";
    } else {
        $htmlSucceedReport = $htmlSucceedReport . "Create table spk_contains_produk SUCCEED!<br><br>";
        $query_fk_spk_contains_produk = "
        ALTER TABLE spk_contains_produk
        ADD CONSTRAINT spk_contains_produk_ibfk_1 FOREIGN KEY (id_spk) REFERENCES spk (id) ON DELETE CASCADE ON UPDATE CASCADE,
        ADD CONSTRAINT spk_contains_produk_ibfk_2 FOREIGN KEY (id_produk) REFERENCES produk (id) ON DELETE CASCADE ON UPDATE CASCADE;";

        $res_fk_spk_contains_produk = mysqli_query($con, $query_fk_spk_contains_produk);

        if (!$res_fk_spk_contains_produk) {
            $htmlErrorReport = $htmlErrorReport . $query_fk_spk_contains_produk . " : FAILED!<br>" . mysqli_error($con) . "<br><br>";
        } else {
            $htmlSucceedReport = $htmlSucceedReport . $query_fk_spk_contains_produk . " : SUCCEED!<br><br>";
        }
    }
} else {
    $htmlSucceedReport = $htmlSucceedReport . "Table spk_contains_produk exist.<br><br>";
}

// ----- END -----

// TABEL spk_item

$query_cek_spk_item = "SELECT id FROM spk_item";
$res_cek_spk_item = mysqli_query($con, $query_cek_spk_item);

if (empty($res_cek_spk_item)) {
    $query_create_spk_item = "CREATE TABLE spk_item (
        id int(11) AUTO_INCREMENT PRIMARY KEY,
        tipe varchar(20) NOT NULL,
        bahan varchar(20) DEFAULT NULL,
        varia varchar(20) DEFAULT NULL,
        ukuran varchar(20) DEFAULT NULL,
        logo varchar(20) DEFAULT NULL,
        tato varchar(20) DEFAULT NULL,
        jahit varchar(20) DEFAULT NULL,
        nama_lengkap varchar(100) DEFAULT NULL,
        japstyle int(11) DEFAULT NULL,
        harga_price_list int(11) DEFAULT NULL,
        ktrg varchar(256) DEFAULT NULL,
        jumlah int(11) DEFAULT NULL,
        harga_item int(11) DEFAULT NULL
      )ENGINE=InnoDB DEFAULT CHARSET=latin1";

    $res_create_spk_item = mysqli_query($con, $query_create_spk_item);
    if (!$res_create_spk_item) {
        $htmlErrorReport = $htmlErrorReport .  $query_create_spk_item . " : FAILED! " . mysqli_error($con) . "<br><br>";
    } else {
        $htmlSucceedReport = $htmlSucceedReport . "Create table spk_item SUCCEED!<br><br>";
    }
    // INSERT INTO spk_item
} else {
    $htmlSucceedReport = $htmlSucceedReport . "Table spk_item exist.<br><br>";
}

// ----- END -----

// TABEL temp_spk_contains_produk

// $query_cek_temp_spk_contains_produk = "SELECT id FROM temp_spk_contains_produk";
// $res_cek_temp_spk_contains_produk = mysqli_query($con, $query_cek_temp_spk_contains_produk);
// if (empty($res_cek_temp_spk_contains_produk)) {
//     $query_create_temp_spk_contains_produk = "CREATE TABLE temp_spk_contains_produk (
//         id int(11) AUTO_INCREMENT PRIMARY KEY,
//         id_spk int(11) NOT NULL,
//         id_produk int(11) NOT NULL,
//         ktrg varchar(256) DEFAULT NULL,
//         jumlah int(11) DEFAULT NULL,
//         harga_item int(11) DEFAULT NULL,
//         koreksi_harga int(11) DEFAULT NULL
//       )ENGINE=InnoDB DEFAULT CHARSET=latin1;";

//     $res_create_temp_spk_contains_produk = mysqli_query($con, $query_create_temp_spk_contains_produk);
//     if (!$res_create_temp_spk_contains_produk) {
//         $htmlErrorReport = $htmlErrorReport . $query_create_temp_spk_contains_produk . " : FAILED! " . mysqli_error($con) . "<br><br>";
//     } else {
//         $htmlSucceedReport = $htmlSucceedReport . "Create table temp_spk_contains_produk SUCCEED!<br><br>";
//     }
// } else {
//     $htmlSucceedReport = $htmlSucceedReport . "Table temp_spk_contains_produk exist.<br><br>";
// }

// ----- END -----

$htmlErrorReport = $htmlErrorReport . "</div>";
$htmlSucceedReport = $htmlSucceedReport . "</div>";

?>
<div id="homeScreen">
    <div id="gridMenu">
        <div class="gridMenuItem">
            <a href="03-01-spk-v3.php" class="menuIcons">
                <img src="img/icons/pencil.svg" alt="Icon SPK">
                <div>
                    SPK
                </div>
            </a>
        </div>


        <div class="gridMenuItem">
            <a class="menuIcons" href="07-01-nota.php">
                <img src="img/icons/checklist.svg" alt="Icon SPK">
                <div>
                    Nota
                </div>
            </a>
        </div>
        <div class="gridMenuItem">
            <a class="menuIcons" href="08-01-surat-jalan.php">
                <img src="img/icons/email.svg" alt="Icon SPK">
                <div>
                    Surat<br>Jalan
                </div>
            </a>
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
            <a href="06-01-produk.php" class="menuIcons">
                <img src="img/icons/products.svg" alt="Icon SPK">
                <div>Produk</div>
            </a>
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

<div id="containerErrorReport"></div>

<div id="containerSucceedReport"></div>
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

    #containerErrorReport {
        margin: 1em;
        padding: 1em;
        border: 2px solid red;
        background: rgba(255, 0, 0, 0.5);
    }

    #containerSucceedReport {
        margin: 1em;
        padding: 1em;
        border: 2px solid green;
        background: rgba(63, 191, 63, 0.5);
    }
</style>

<script>
    // setTimeout(() => {}, 1000);
    var htmlErrorReport = `<?= $htmlErrorReport; ?>`;
    var htmlSucceedReport = `<?= $htmlSucceedReport; ?>`;

    $('#containerErrorReport').html(htmlErrorReport);
    $('#containerSucceedReport').html(htmlSucceedReport);

    if ($('#divErrorReport').html() === '') {
        $('#containerErrorReport').hide();
    } else {
        $('#containerErrorReport').show();
    }

    if ($('#divSucceedReport').html() === '') {
        $('#containerSucceedReport').hide();
    } else {
        $('#containerSucceedReport').show();
    }
    // initSPK();
</script>
<?php

include_once "01-footer.php";
?>