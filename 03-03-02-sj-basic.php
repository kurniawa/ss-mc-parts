<div id="containerSJBasic">

    <div class="ml-0_5em mr-0_5em mt-2em">
        <div>
            <h2>Tipe: Sarung Jok Basic</h2>
        </div>

        <input id="namaBahan" class="input-1 mt-1em pb-1em" type="text" placeholder="Nama/Tipe Bahan">

        <!-- <input id="variasi2" class="input-1 mt-1em pb-1em" type="text" placeholder="Variasi"> -->

        <div class="grid-1-auto mt-1em mb-0_5em">
            <select name="variasi" id="variasi" class="pt-0_5em pb-0_5em" onchange="showNextVarian(this.value);">
                <option value="" disabled selected>Pilih Variasi</option>
            </select>
        </div>

        <div id="divVariasiLG" class="grid-2-auto_10 mt-1em">
            <select name="variasiLG" id="variasiLG" class="pt-0_5em pb-0_5em" onchange="showVariasiLG(this.value);">
                <option value="" disabled selected>Pilih Variasi LOGO</option>
            </select>
            <span class="ui-icon ui-icon-closethick justify-self-center" onclick="closeVariasiLG();"></span>
        </div>

        <div id="divSelectVariasiBludru" class="grid-2-auto_10 mt-1em">
            <select name="selectVariasiBludru" id="selectVariasiBludru" class="pt-0_5em pb-0_5em">
                <option value="" disabled selected>Pilih Gambar Bludru</option>
            </select>
            <span class="ui-icon ui-icon-closethick justify-self-center" onclick="collapseAndReset(['#divSelectVariasiBludru', '#choseVariasiBludru'],['#selectVariasiBludru', '#variasiLG'])"></span>
        </div>

        <div id="divJumlah">
            <input type="number" name="jumlah" id="inputJumlah" min="0" step="1" placeholder="Jumlah" class="pt-0_5em pb-0_5em">
        </div>

        <div id="divSelectVariasiTato" class="grid-2-auto_10 mt-1em">
            <select name="variasiTato" id="variasiTato" class="pt-0_5em pb-0_5em">
                <option value="" disable selected>Pilih Variasi TATO</option>
            </select>
            <span class="ui-icon ui-icon-closethick justify-self-center"></span>
        </div>

        <br><br>

        <div id="warning" class="d-none"></div>

        <div id="divAvailableOptions" class="position-absolute bottom-5em">
            Available options:
            <div id="availableOptions">
                <div id="choseVariasiBludru" class="pt-0_5em pb-0_5em pl-1em pr-1em b-radius-10px bg-color-soft-red d-none">
                    Variasi Bludru
                </div>
            </div>

        </div>
        <div id="bottomDiv" class="position-absolute bottom-0_5em w-calc-100-1em">
            <div class="h-4em bg-color-orange-2 grid-1-auto" onclick="insertNewProduct();">
                <span class="justify-self-center font-weight-bold">TAMBAH ITEM KE SPK</span>
            </div>
        </div>

    </div>

</div>

<script>
    let arrayBahan = new Array();
    let arrayVariasi = new Array();
    let arrayVariasiLGBludru = new Array();
    // let testArray = ["test1", "test1", "test1", "test1", "test1", "test1", "test1", "test1"];

    // console.log(testArray);
    $(document).ready(function() {
        $("#divVariasiLG").css("display", "none");
        $("#divSelectVariasiBludru").css("display", "none");
        $("#divSelectVariasiTato").css("display", "none");
        $("#choseVariasiBludru").css("display", "none");


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
                console.log(variasiLG.nama);
                $("#variasiLG").append('<option value="' + variasiLG.nama + '">' + variasiLG.nama + '</option>');
            }
            for (const variasiLGBludru of data[0].variasi[0].jenis_variasi[1].jenis_logo[0].gambar) {
                arrayVariasiLGBludru.push(variasiLGBludru);
                $("#selectVariasiBludru").append('<option value="' + variasiLGBludru + '">' + variasiLGBludru + '</option>');
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
            $("#divVariasiLG").toggle();
            $("#divVariasiTATO").css("display", "none");
        } else if (value === "TATO") {
            $("#divVariasiTATO").toggle()
            $("#divVariasiLG").css("display", "none");
        }
    }

    function showVariasiLG(value) {
        console.log(value);
        if (value === "Bludru") {
            $("#choseVariasiBludru").toggle();
        }
    }

    function showSelectVariasiBludru() {
        $("#selectVariasiBludru").toggle();
    }

    function closeVariasiLG() {
        $("#variasi").prop("selectedIndex", 0);
        document.getElementById("variasiLG").selectedIndex = 0;
        $("#divVariasiLG").css("display", "none");
    }

    document.getElementById("choseVariasiBludru").addEventListener('click', () => {
        toggleShowElement(['#divSelectVariasiBludru']);
        $("#choseVariasiBludru").css("display", "none");
    });

    document.getElementById('selectVariasiBludru').addEventListener('change', () => {

    });

    function toggleShowElement(idAll, time) {
        idAll.forEach(id => {
            if ($(id).css("display") === "none") {
                $(id).toggle(time);
            }
        });
    }

    function collapseAndReset(idToCollapse, idToReset) {
        idToReset.forEach(idElement => {
            $(idElement).prop("selectedIndex", 0);
            // document.getElementById(idElement).selectedIndex = 0;
        });
        idToCollapse.forEach(idElement => {
            $(idElement).css("display", "none");
        });
    }

    function insertNewProduct() {

    }
</script>

<style>

</style>