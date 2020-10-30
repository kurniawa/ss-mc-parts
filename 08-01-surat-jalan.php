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
    let daftarSrjalan = new Array();
    showDaftarSrjalan();

    async function showDaftarSrjalan() {
        let htmlDaftarSrjalan = '';
        let daftarSPK = localStorage.getItem('daftarSPK');
        daftarSPK = JSON.parse(daftarSPK);

        for (const spk of daftarSPK) {
            if (spk.tglSrjalan != null) {
                daftarSrjalan.push(spk);
            }
        }
        console.log('daftarSrjalan');
        console.log(daftarSrjalan);
        let i = 0;
        for (const srjl of daftarSrjalan) {
            console.log(srjl);
            console.log(srjl.tglSrjalan);
            let arrayDate = srjl.tglSrjalan.split('-');
            let getYear = arrayDate[0];
            let getMonth = arrayDate[1];
            let getDay = arrayDate[2];
            let subGetYear = getYear.substr(2);

            $arrayBgColors = ["#FFB08E", "#DEDEDE", "#D1FFCA", "#FFB800", '#706DFF'];
            $randomIndex = Math.floor(Math.random() * 5);

            // menentukan ekspedisi utama dari daftar ekspedisi yang ada
            let ekspedisiUtama;
            console.log(srjl.ekspedisi.id);
            console.log(srjl.ekspedisi.ketUtama);
            console.log(srjl.ekspedisi.nama);
            for (let j = 0; j < srjl.ekspedisi.id.length; j++) {
                if (srjl.ekspedisi.ketUtama[j] === 'y') {
                    ekspedisiUtama = {
                        nama: srjl.ekspedisi.nama[j],
                        alamat: srjl.ekspedisi.alamat[j],
                        kontak: srjl.ekspedisi.kontak[j]
                    };
                }
            }
            console.log(ekspedisiUtama);
            // END

            // menentukan id dropdown yang mau di toggle
            let idDropdownSrjalan = [{
                id: `#divDropdownSrjalan-${i}`,
                time: 300
            }];
            idDropdownSrjalan = JSON.stringify(idDropdownSrjalan);

            htmlDaftarSrjalan = htmlDaftarSrjalan +
                `
            <div class=' bb-1px-solid-grey pb-0_5em'>
            <div class='pt-0_5em pb-0_5em grid-4-13_auto_auto_5'>
                <div>
                    <div class='grid-1-auto justify-items-center color-white b-radius-5px w-3_5em' style='background-color: ${$arrayBgColors[$randomIndex]}'>
                        <div class='font-size-2_5em'>${getDay}</div><div>${getMonth}-${subGetYear}</div>
                    </div>
                </div>
                <div class='grid-1-auto'>
                    <div class='font-weight-bold'>${srjl.noSrjalan}</div>
                    <div>${srjl.namaCust}-${srjl.daerah}</div>
                </div>
                <div class='justify-self-right grid-1-auto justify-items-right'>
                    <div class='font-weight-bold color-green font-size-1_5em'>${srjl.koli}</div>
                    <div class='font-weight-bold color-grey'>Koli</div>
                </div>
                <div>
                    <div class='justify-self-center'><img class='w-0_7em' src='img/icons/dropdown.svg' onclick='elementToToggle(${idDropdownSrjalan})'></div>
                </div>
            </div>
            ` +
                // DROPDOWN
                `
            <div id='divDropdownSrjalan-${i}' style='display:none'>
            <div class='grid-3-13_62_25 grid-row-gap-0_2em'>

            <img class='w-3em' src='img/icons/boy.svg'>
            <div>${srjl.alamatCust}</div>
            <div class='justify-self-right font-weight-bold'>Pelanggan >></div>

            <img class='w-3em' src='img/icons/shipment.svg'>
            <div>${ekspedisiUtama.nama}<br>${ekspedisiUtama.alamat}</div>
            <div class='justify-self-right font-weight-bold'>Ekspedisi >></div>

            <img class='w-3em' src='img/icons/checklist.svg'>
            <div>${srjl.noNota}</div>
            <div class='justify-self-right font-weight-bold'>Nota >></div>

            </div>

            <div class='text-center'>
                <div class='d-inline-block btn-stipis bg-color-orange-1' onclick='goToDetailSuratJalan(${i});'>Detail Surat Jalan >></div>
            </div>

            </div>
            </div>
            `;
            i++;
        }

        $('#divDaftarNota').html(htmlDaftarSrjalan);
        console.log('daftarSrjalan');
        console.log(daftarSrjalan);
    }

    function goToDetailSuratJalan(i) {
        console.log(i);
        console.log(daftarSrjalan);
        console.log(daftarSrjalan[i]);
        let SPKItems = new Array();

        for (let k = 0; k < daftarSrjalan[i].itemSPK.length; k++) {
            SPKItems.push({
                nama: daftarSrjalan[i].itemSPK[k].nama,
                desc: daftarSrjalan[i].itemSPK[k].desc,
                jumlah: daftarSrjalan[i].itemSPK[k].jumlah,
                hargaPcs: daftarSrjalan[i].itemSPK[k].harga,
                harga: daftarSrjalan[i].hargaItemSPK[k]
            });
        }
        let ekspedisiUtama;

        for (let j = 0; j < daftarSrjalan[i].ekspedisi.id.length; j++) {
            if (daftarSrjalan[i].ekspedisi.ketUtama[j] === 'y') {
                ekspedisiUtama = {
                    nama: daftarSrjalan[i].ekspedisi.nama[j],
                    alamat: daftarSrjalan[i].ekspedisi.alamat[j],
                    kontak: daftarSrjalan[i].ekspedisi.kontak[j]
                };
            }
        }

        let srjlnToPrint = {
            alamatCust: daftarSrjalan[i].alamatCust,
            daerah: daftarSrjalan[i].daerah,
            ekspedisi: daftarSrjalan[i].ekspedisi,
            ekspedisiUtama: ekspedisiUtama,
            hargaTotalSPK: daftarSrjalan[i].hargaTotalSPK,
            id: daftarSrjalan[i].id,
            idCust: daftarSrjalan[i].idCust,
            itemSPK: SPKItems,
            jumlahTotal: daftarSrjalan[i].jumlahTotal,
            ketSPK: daftarSrjalan[i].ketSPK,
            koli: daftarSrjalan[i].koli,
            namaCust: daftarSrjalan[i].namaCust,
            noNota: daftarSrjalan[i].noNota,
            noSrjalan: daftarSrjalan[i].noSrjalan,
            singkatanCust: daftarSrjalan[i].singkatanCust,
            tglNota: daftarSrjalan[i].tglNota,
            tglPembuatan: daftarSrjalan[i].tglPembuatan,
            tglSelesai: daftarSrjalan[i].tglSelesai,
            tglSrjalan: daftarSrjalan[i].tglSrjalan
        }

        localStorage.setItem('notaToPrint', JSON.stringify(srjlnToPrint));
        location.href = '08-02-detail-surat-jalan.php';
    }
</script>
<?php
include_once "01-footer.php";
?>