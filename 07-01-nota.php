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

        for (const spk of daftarSPK) {
            if (spk.tglNota != null) {
                daftarNota.push(spk);
            }
        }

        for (let i = 0; i < daftarNota.length; i++) {
            console.log(daftarNota[i]);
            console.log(daftarNota[i].itemSPK);
            console.log(daftarNota[i].tglNota);
            let arrayDate = daftarNota[i].tglNota.split('-');
            let getYear = arrayDate[0];
            let getMonth = arrayDate[1];
            let getDay = arrayDate[2];
            let subGetYear = getYear.substr(2);

            // html item-item yang ada di nota

            let htmlItemNota = `
            <div id='divNotaItems-${i}' class='pb-0_5em' style='display:none'>
            <div class='grid-4-12_50_18_20 pb-0_5em'>
                <div class='font-weight-bold'>Jml</div>
                <div class='font-weight-bold'>Nama Item</div>
                <div class='font-weight-bold'>Hrg./pcs</div>
                <div class='font-weight-bold'>Harga</div>
            `;

            let idNotaItems = [{
                id: `#divNotaItems-${i}`,
                time: 300
            }];
            idNotaItems = JSON.stringify(idNotaItems);
            // html nota yang menampung item2 diatas
            for (let j = 0; j < daftarNota[i].itemSPK.length; j++) {
                let hargaItem = formatHarga(daftarNota[i].hargaItemSPK[j]);
                console.log(hargaItem);

                htmlItemNota = htmlItemNota +
                    `
                    <div>${daftarNota[i].itemSPK[j].jumlah}</div>
                    <div>${daftarNota[i].itemSPK[j].nama}</div>
                    <div>${formatHarga(daftarNota[i].itemSPK[j].harga)}</div>
                    <div>${hargaItem}</div>
                `
            }
            htmlItemNota = htmlItemNota +
                `</div>
                <div class='text-right'>
                    <div class='d-inline-block btn-tipis bg-color-orange-1' onclick='goToDetailNota(${i})'>Detail Nota >></div>
                </div>
            </div>`;

            htmlDaftarNota = htmlDaftarNota +
                `
            <div class=' bb-1px-solid-grey'>
            <div class='pt-0_5em pb-0_5em grid-4-13_auto_auto_5'>
                <div>
                    <div class='grid-1-auto justify-items-center color-white b-radius-5px w-3_5em' style='background-color: ${randomColor()}'>
                        <div class='font-size-2_5em'>${getDay}</div><div>${getMonth}-${subGetYear}</div>
                    </div>
                </div>
                <div class='grid-1-auto'>
                    <div class='font-weight-bold'>${daftarNota[i].noNota}</div>
                    <div>${daftarNota[i].namaCust}-${daftarNota[i].daerah}</div>
                </div>
                <div class='justify-self-right grid-1-auto justify-items-right'>
                    <div class='font-weight-bold color-green'>${formatHarga(daftarNota[i].hargaTotalSPK)}</div>
                    <div class='font-weight-bold'>Rp.</div>
                </div>
                <div>
                    <div class='justify-self-center'><img class='w-0_7em' src='img/icons/dropdown.svg' onclick='elementToToggle(${idNotaItems})'></div>
                </div>
            </div>
            ${htmlItemNota}
            </div>
            `;
        }

        // let i = 0;
        // for (const nota of daftarNota) {
        //     console.log(nota);
        //     console.log(nota.tglNota);
        //     let arrayDate = nota.tglNota.split('-');
        //     let getYear = arrayDate[0];
        //     let getMonth = arrayDate[1];
        //     let getDay = arrayDate[2];
        //     let subGetYear = getYear.substr(2);

        //     $arrayBgColors = ["#FFB08E", "#DEDEDE", "#D1FFCA", "#FFB800", '#706DFF'];
        //     $randomIndex = Math.floor(Math.random() * 5);

        //     // html item-item yang ada di nota

        //     let htmlItemNota = `
        //     <div id='divNotaItems-${i}' class='pb-0_5em' style='display:none'>
        //     <div class='grid-4-12_50_18_20 pb-0_5em'>
        //         <div class='font-weight-bold'>Jml</div>
        //         <div class='font-weight-bold'>Nama Item</div>
        //         <div class='font-weight-bold'>Hrg./pcs</div>
        //         <div class='font-weight-bold'>Harga</div>
        //     `;

        //     let idNotaItems = [{
        //         id: `#divNotaItems-${i}`,
        //         time: 300
        //     }];
        //     idNotaItems = JSON.stringify(idNotaItems);
        //     // html nota yang menampung item2 diatas
        //     for (let j = 0; j < nota.itemSPK.length; j++) {

        //         htmlItemNota = htmlItemNota +
        //             `
        //             <div>${nota.itemSPK[j].jumlah}</div>
        //             <div>${nota.itemSPK[j].nama}</div>
        //             <div>${nota.itemSPK[j].harga}</div>
        //             <div>${nota.hargaItemSPK[j]}</div>
        //         `
        //     }
        //     htmlItemNota = htmlItemNota +
        //         `</div>
        //         <div class='text-right'>
        //             <div class='d-inline-block btn-tipis bg-color-orange-1' onclick='goToDetailNota()'>Detail Nota >></div>
        //         </div>
        //     </div>`;

        //     htmlDaftarNota = htmlDaftarNota +
        //         `
        //     <div class=' bb-1px-solid-grey'>
        //     <div class='pt-0_5em pb-0_5em grid-4-13_auto_auto_5'>
        //         <div>
        //             <div class='grid-1-auto justify-items-center color-white b-radius-5px w-3_5em' style='background-color: ${$arrayBgColors[$randomIndex]}'>
        //                 <div class='font-size-2_5em'>${getDay}</div><div>${getMonth}-${subGetYear}</div>
        //             </div>
        //         </div>
        //         <div class='grid-1-auto'>
        //             <div class='font-weight-bold'>${nota.noNota}</div>
        //             <div>${nota.namaCust}-${nota.daerah}</div>
        //         </div>
        //         <div class='justify-self-right grid-1-auto justify-items-right'>
        //             <div class='font-weight-bold color-green'>${nota.hargaTotalSPK}</div>
        //             <div class='font-weight-bold'>Rp.</div>
        //         </div>
        //         <div>
        //             <div class='justify-self-center'><img class='w-0_7em' src='img/icons/dropdown.svg' onclick='elementToToggle(${idNotaItems})'></div>
        //         </div>
        //     </div>
        //     ${htmlItemNota}
        //     </div>
        //     `;
        //     i++;
        // }

        $('#divDaftarNota').html(htmlDaftarNota);
    }

    function goToDetailNota(i) {
        console.log(i);
        let SPKItems = new Array();

        for (let k = 0; k < daftarNota[i].itemSPK.length; k++) {
            SPKItems.push({
                nama: daftarNota[i].itemSPK[k].nama,
                desc: daftarNota[i].itemSPK[k].desc,
                jumlah: daftarNota[i].itemSPK[k].jumlah,
                hargaPcs: daftarNota[i].itemSPK[k].harga,
                harga: daftarNota[i].hargaItemSPK[k]
            });
        }
        let ekspedisiUtama;
        // console.log(srjl.ekspedisi.id);
        // console.log(srjl.ekspedisi.ketUtama);
        // console.log(srjl.ekspedisi.nama);
        for (let j = 0; j < daftarNota[i].ekspedisi.id.length; j++) {
            if (daftarNota[i].ekspedisi.ketUtama[j] === 'y') {
                ekspedisiUtama = {
                    nama: daftarNota[i].ekspedisi.nama[j],
                    alamat: daftarNota[i].ekspedisi.alamat[j],
                    kontak: daftarNota[i].ekspedisi.kontak[j]
                };
            }
        }

        // for (const item of daftarNota[i].itemSPK) {
        //     SPKItems.push({
        //         nama: item.nama,
        //         desc: item.desc,
        //         jumlah: item.jumlah,
        //         hargaPcs: item.harga,
        //         harga: daftarNota[i].hargaItemSPK[i]
        //     });
        // }

        let notaToPrint = {
            alamatCust: daftarNota[i].alamatCust,
            daerah: daftarNota[i].daerah,
            ekspedisi: daftarNota[i].ekspedisi,
            ekspedisiUtama: ekspedisiUtama,
            hargaTotalSPK: daftarNota[i].hargaTotalSPK,
            id: daftarNota[i].id,
            idCust: daftarNota[i].idCust,
            itemSPK: SPKItems,
            jumlahTotal: daftarNota[i].jumlahTotal,
            ketSPK: daftarNota[i].ketSPK,
            koli: daftarNota[i].koli,
            namaCust: daftarNota[i].namaCust,
            noNota: daftarNota[i].noNota,
            noSrjalan: daftarNota[i].noSrjalan,
            singkatanCust: daftarNota[i].singkatanCust,
            tglNota: daftarNota[i].tglNota,
            tglPembuatan: daftarNota[i].tglPembuatan,
            tglSelesai: daftarNota[i].tglSelesai,
            tglSrjalan: daftarNota[i].tglSrjalan
        }

        localStorage.setItem('notaToPrint', JSON.stringify(notaToPrint));
        location.href = '07-02-detail-nota.php';
    }
</script>
<?php
include_once "01-footer.php";
?>