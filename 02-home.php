<?php
include_once "01-header.php";

// Create connection
$conn = mysqli_connect("localhost", "root", "");
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database
$sql = "CREATE DATABASE mcparts";
if (mysqli_query($conn, $sql)) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . mysqli_error($conn);
}

mysqli_close($conn);

include_once "01-config.php";
// TABEL EKSPEDISI

$query_cek_ekspedisi = "SELECT id FROM ekspedisi";
$res_cek_ekspedisi = mysqli_query($con, $query_cek_ekspedisi);

if (empty($res_cek_ekspedisi)) {
    $query_create_ekspedisi = "CREATE TABLE `ekspedisi` (
        `id` int(11) AUTO_INCREMENT PRIMARY KEY,
        `nama` varchar(100) NOT NULL,
        `bentuk` varchar(10) DEFAULT NULL,
        `alamat` varchar(200) NOT NULL,
        `kontak` varchar(45) DEFAULT NULL,
        `keterangan` varchar(200) DEFAULT NULL
      )ENGINE=InnoDB DEFAULT CHARSET=latin1";

    $res_create_ekspedisi = mysqli_query($con, $query_create_ekspedisi);

    if (!$res_create_ekspedisi) {
        echo $query_create_ekspedisi . " : FAILED! " . mysqli_error($con);
    }
    // INSERT INTO ekspedisi
}

if (!$res_cek_ekspedisi) {
    echo $query_cek_ekspedisi . ": FAILED: " . mysqli_error($con);
    die;
}

// ----- END -----

// TABLE PELANGGAN
$query_cek_pelanggan = "SELECT id FROM pelanggan";
$res_cek_pelanggan = mysqli_query($con, $query_cek_pelanggan);

if (empty($res_cek_pelanggan)) {
    $query_create_pelanggan = "CREATE TABLE `pelanggan` (
        `id` int(11) AUTO_INCREMENT PRIMARY KEY,
        `nama` varchar(100) NOT NULL,
        `alamat` varchar(200) DEFAULT NULL,
        `pulau` varchar(20) NOT NULL,
        `daerah` varchar(20) NOT NULL,
        `kontak` varchar(45) DEFAULT NULL,
        `keterangan` varchar(200) DEFAULT NULL,
        `singkatan` varchar(3) DEFAULT NULL,
        `id_reseller` int(11) DEFAULT NULL
      )ENGINE=InnoDB DEFAULT CHARSET=latin1";

    // INSERT INTO
}

if (!$res_cek_pelanggan) {
    echo $query_cek_pelanggan . ": FAILED: " . mysqli_error($con);
    die;
}

if (mysqli_num_rows($res_cek_pelanggan) < 0) {
    echo "NOT FOUND!";
    die;
}

// ----- END -----

// TABEL pelanggan_use_ekspedisi

$query_cek_pelanggan_use_ekspedisi = "SELECT id FROM pelanggan_use_ekspedisi";
$res_cek_pelanggan_use_ekspedisi = mysqli_query($con, $query_cek_pelanggan_use_ekspedisi);

if (empty($res_cek_pelanggan_use_ekspedisi)) {
    $query_create_pelanggan = "CREATE TABLE `pelanggan_use_ekspedisi` (
        `id` int(11) AUTO_INCREMENT PRIMARY KEY,
        `id_ekspedisi` int(11) NOT NULL,
        `id_pelanggan` int(11) NOT NULL,
        `ekspedisi_transit` char(1) NOT NULL DEFAULT 'n',
        `ekspedisi_utama` char(1) NOT NULL DEFAULT 'n',
        ADD CONSTRAINT `pelanggan_use_ekspedisi_ibfk_1` FOREIGN KEY (`id_ekspedisi`) REFERENCES `ekspedisi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
        ADD CONSTRAINT `pelanggan_use_ekspedisi_ibfk_2` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
      )ENGINE=InnoDB DEFAULT CHARSET=latin1";

    // INSERT INTO pelanggan_use_ekspedisi
}

if (!$res_cek_pelanggan_use_ekspedisi) {
    echo $query_cek_pelanggan_use_ekspedisi . ": FAILED: " . mysqli_error($con);
    die;
}

// ----- END -----

// TABEL produk

$query_cek_produk = "SELECT id FROM produk";
$res_cek_produk = mysqli_query($con, $query_cek_produk);

if (empty($res_cek_produk)) {
    $query_create_pelanggan = "CREATE TABLE `produk` (
        `id` int(11) AUTO_INCREMENT PRIMARY KEY,
        `id_ekspedisi` int(11) NOT NULL,
        `id_pelanggan` int(11) NOT NULL,
        `ekspedisi_transit` char(1) NOT NULL DEFAULT 'n',
        `ekspedisi_utama` char(1) NOT NULL DEFAULT 'n'
      )ENGINE=InnoDB DEFAULT CHARSET=latin1";

    // INSERT INTO produk
}

if (!$res_cek_produk) {
    echo $query_cek_produk . ": FAILED: " . mysqli_error($con);
    die;
}

// ----- END -----

// TABEL SPK
$query_cek_spk = "SELECT id FROM spk";
$res_cek_spk = mysqli_query($con, $query_cek_spk);
if (empty($res)) {
    $query_create_spk = "CREATE TABLE `spk` (
        `id` int(11) AUTO_INCREMENT PRIMARY KEY,
        `no_spk` varchar(45) NOT NULL,
        `tgl_pembuatan` date NOT NULL,
        `tgl_selesai` date DEFAULT NULL,
        `ket_judul` varchar(200) DEFAULT NULL,
        `catatan_kaki` varchar(200) DEFAULT NULL,
        `id_pelanggan` int(11) DEFAULT NULL,
        `no_nota` varchar(45) DEFAULT NULL,
        `tgl_nota` date DEFAULT NULL,
        `no_surat_jalan` varchar(45) DEFAULT NULL,
        `tgl_surat_jalan` date DEFAULT NULL,
        `koli` int(11) DEFAULT NULL,
        `harga` int(11) DEFAULT NULL
      )ENGINE=InnoDB DEFAULT CHARSET=latin1";
    $res_create_spk = mysqli_query($con, $query_create_spk);
}

if (!$res_cek_spk) {
    echo $query_cek_spk . ": FAILED: " . mysqli_error($con);
    die;
}

if (mysqli_num_rows($res_cek_spk) < 0) {
    echo "NOT FOUND!";
    die;
}
// ----- END -----

// TABEL spk_contains_produk

$query_cek_spk_contains_produk = "SELECT id FROM spk_contains_produk";
$res_cek_spk_contains_produk = mysqli_query($con, $query_cek_spk_contains_produk);
if (empty($res_cek_spk_contains_produk)) {
    $query_create_spk_contains_produk = "CREATE TABLE `spk_contains_produk` (
        `id` int(11) NOT NULL,
        `id_spk` int(11) NOT NULL,
        `id_produk` int(11) NOT NULL,
        `ktrg` varchar(256) DEFAULT NULL,
        `jumlah` int(11) DEFAULT NULL,
        `harga_item` int(11) DEFAULT NULL,
        `koreksi_harga` int(11) DEFAULT NULL,
        ADD CONSTRAINT `spk_contains_produk_ibfk_1` FOREIGN KEY (`id_spk`) REFERENCES `spk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
        ADD CONSTRAINT `spk_contains_produk_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
      )ENGINE=InnoDB DEFAULT CHARSET=latin1";
    $res_create_spk_contains_produk = mysqli_query($con, $query_create_spk_contains_produk);
}

if (!$res_cek_spk_contains_produk) {
    echo $query_cek_spk_contains_produk . ": FAILED: " . mysqli_error($con);
    die;
}

// ----- END -----



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

<script>
    initSPK();
</script>
<?php
include_once "01-footer.php";
?>