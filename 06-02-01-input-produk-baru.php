<div id="inputSJBasic" class="inputNewProduct m-0_5em">

    <div>
        <h2>Tipe: Sarung Jok Basic</h2>
    </div>

    <div class="ml-0_5em mr-0_5em mt-2em">

        <input id="namaBahan" class="input-1 mt-1em pb-1em" type="text" placeholder="Nama/Tipe Bahan">

        <input id="variasi" class="input-1 mt-1em pb-1em" type="text" placeholder="Variasi">


        <br><br>

        <div id="warning" class="d-none"></div>

        <div>
            <div class="m-1em h-4em bg-color-orange-2 grid-1-auto" onclick="insertNewProduct();">
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
        fetch('json/products.json').then(response => response.json()).then(data => {
            console.log(data);
            for (const bahan of data[0].bahan) {
                console.log(bahan.nama_bahan);
                arrayBahan.push(bahan.nama_bahan);
            }

            for (const variasi of data[0].variasi[0].jenis_variasi) {
                console.log(variasi.nama);
                arrayVariasi.push(variasi.nama);
            }
        });

        console.log(arrayBahan);

        $("#namaBahan").autocomplete({
            source: arrayBahan
        });

        $("#variasi").autocomplete({
            source: arrayVariasi
        });
    });


    function insertNewProduct() {

    }
</script>

<style>

</style>