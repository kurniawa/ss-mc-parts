<div id="inputSJBasic" class="inputNewProduct m-0_5em">

    <div>
        <h2>Tipe: Sarung Jok Basic</h2>
    </div>

    <div class="ml-0_5em mr-0_5em mt-2em">

        <input id="namaBahan" class="input-1 mt-1em pb-1em" type="text" placeholder="Nama/Tipe Bahan">

        <!-- <input id="variasi2" class="input-1 mt-1em pb-1em" type="text" placeholder="Variasi"> -->

        <select name="variasi" id="variasi" class="mt-1em mb-0_5em pt-0_5em pb-0_5em w-100" onchange="showNextVarian(this.value);">
            <option value="" disable selected>Pilih Variasi</option>
        </select>

        <select name="variasiLG" id="variasiLG" class="mt-1em pt-0_5em pb-0_5em w-100">
            <option value="" disable selected>Pilih Variasi LOGO</option>
        </select>

        <select name="variasiTATO" id="variasiTATO" class="mt-1em pt-0_5em pb-0_5em w-100">
            <option value="" disable selected>Pilih Variasi TATO</option>
        </select>

        <br><br>

        <div id="warning" class="d-none"></div>

        <div>
            <div class="mt-4em h-4em bg-color-orange-2 grid-1-auto" onclick="insertNewProduct();">
                <span class="justify-self-center font-weight-bold">TAMBAH PRODUK BARU</span>
            </div>
        </div>

    </div>

</div>

<script>
    let arrayBahan = new Array();
    let arrayVariasi = new Array();
    // let testArray = ["test1", "test1", "test1", "test1", "test1", "test1", "test1", "test1"];

    // console.log(testArray);
    $(document).ready(function() {
        $("#variasiLG").css("display", "none");
        $("#variasiTATO").css("display", "none");

        fetch('json/products.json').then(response => response.json()).then(data => {
            console.log(data);
            for (const bahan of data[0].bahan) {
                console.log(bahan.nama_bahan);
                arrayBahan.push(bahan.nama_bahan);
            }

            for (const variasi of data[0].variasi[0].jenis_variasi) {
                console.log(variasi.nama);
                arrayVariasi.push(variasi.nama);
                $("#variasi").append('<option value="' + variasi.nama + '">' + variasi.nama + '</option>');
            }
            for (const variasiLG of data[0].variasi[0].jenis_variasi[1].jenis_logo) {
                console.log(variasiLG);
                $("#variasiLG").append('<option value="' + variasiLG + '">' + variasiLG + '</option>');
            }
        });

        console.log(arrayBahan);

        $("#namaBahan").autocomplete({
            source: arrayBahan
        });

        // $("#variasi2").autocomplete({
        //     source: arrayVariasi
        // });

        // $('#variasi').selectmenu();

    });

    function showNextVarian(value) {
        console.log(value);

        if (value === "LG") {
            $("#variasiLG").toggle()
            $("#variasiTATO").css("display", "none");
        } else if (value === "TATO") {
            $("#variasiTATO").toggle()
            $("#variasiLG").css("display", "none");
        }
    }

    function insertNewProduct() {

    }
</script>

<style>

</style>