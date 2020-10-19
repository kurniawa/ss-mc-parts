<?php
include_once "01-header.php";
?>

<div class="header"></div>

<div class="grid-2-auto mt-1em ml-0_5em mr-0_5em pb-1em bb-0_5px-solid-grey">
    <div class="justify-self-left grid-2-auto b-1px-solid-grey b-radius-50px mr-1em pl-1em pr-0_4em w-11em">
        <input class="input-2 mt-0_4em mb-0_4em" type="text" placeholder="Cari...">
        <div class="justify-self-right grid-1-auto justify-items-center circle-small bg-color-orange-1">
            <img class="w-0_8em" src="img/icons/loupe.svg" alt="">
        </div>
    </div>
    <div class="justify-self-right">
        <div class="grid-1-auto justify-items-center  bg-color-orange-1 b-radius-100 w-2em h-2em">
            <img class="w-0_9em" src="img/icons/sort-by-attributes.svg" alt="sort-icon">
        </div>
    </div>
</div>

<div id="divDaftarNota" class="pl-0_5em pr-0_5em"></div>


<script>
    let daftarNota = new Array();
    showDaftarNota();

    async function showDaftarNota() {
        let htmlDaftarNota = '';
        let daftarSPK = localStorage.getItem('daftarSPK');
        daftarSPK = JSON.parse(daftarSPK);
        let daftarNota = new Array();

        for (const spk of daftarSPK) {
            if (spk.tglNota != null) {
                daftarNota.push(spk);
            }
        }

        for (const nota of daftarNota) {
            console.log(nota);
            console.log(nota.tglNota);
            let arrayDate = nota.tglNota.split('-');
            let getYear = arrayDate[0];
            let getMonth = arrayDate[1];
            let getDay = arrayDate[2];
            let subGetYear = getYear.substr(2);

            $arrayBgColors = ["#FFB08E", "#DEDEDE", "#D1FFCA", "#FFB800", '#706DFF'];
            $randomIndex = Math.floor(Math.random() * 5);

            htmlDaftarNota = htmlDaftarNota +
                `
            <div class='pt-0_5em pb-0_5em grid-4-13_auto_auto_5 bb-1px-solid-grey'>
                <div>
                    <div class='grid-1-auto justify-items-center color-white b-radius-5px w-3_5em' style='background-color: ${$arrayBgColors[$randomIndex]}'>
                        <div class='font-size-2_5em'>${getDay}</div><div>${getMonth}-${subGetYear}</div>
                    </div>
                </div>
                <div class='grid-1-auto'>
                    <div>${nota.noNota}</div>
                    <div>${nota.namaCust}-${nota.daerah}</div>
                </div>
                <div>
                    <div>Rp.</div>
                    <div>Total</div>
                </div>
                <div>
                    <div class='justify-self-center'><img class='w-0_7em' src='img/icons/dropdown.svg'></div>
                </div>
            </div>
            `;
        }

        $('#divDaftarNota').html(htmlDaftarNota);
    }
</script>
<?php
include_once "01-footer.php";
?>