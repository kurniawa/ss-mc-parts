<div id="containerBeginSPK" class="m-0_5em">

    <div class="b-1px-solid-grey">
        <div class="text-center">
            <h2>Surat Perintah Kerja</h2>
        </div>
        <div class="grid-3-25_10_auto m-0_5em grid-row-gap-1em">
            <div>No.</div>
            <div>:</div>
            <div class="divSPKNumber font-weight-bold">8888</div>
            <div>Tanggal</div>
            <div>:</div>
            <div class="divSPKDate font-weight-bold">15-10-2020</div>
            <div>Untuk</div>
            <div>:</div>
            <div class="divSPKCustomer font-weight-bold">Akong - Pluit</div>
        </div>
        <div class="grid-1-auto justify-items-right m-0_5em">
            <div>
                <img class="w-1em" src="img/icons/edit-grey.svg" alt="">
            </div>
        </div>
    </div>

    <div class="divTitleDesc grid-1-auto justify-items-center mt-0_5em">Kirim Ke Biran Bangka</div>

    <div id="divItemList" class="bt-1px-solid-grey font-weight-bold"></div>

    <div id="divAddItems" class="h-9em position-relative mt-1em">
        <div class="productType position-absolute top-0 left-50 transform-translate--50_0 circle-L bg-color-orange-1 grid-1-auto justify-items-center" onclick="toggleSJVaria();">
            <span class="font-size-0_8em text-center font-weight-bold">SJ<br>Varia</span>
        </div>
        <div class="productType position-absolute top-1em left-35 transform-translate--50_0 circle-L bg-color-orange-1 grid-1-auto justify-items-center">
            <span class="font-size-0_8em text-center font-weight-bold">SJ<br>Kombi</span>
        </div>
        <div class="productType position-absolute top-1em left-65 transform-translate--50_0 circle-L bg-color-orange-1 grid-1-auto justify-items-center">
            <span class="font-size-0_8em text-center font-weight-bold">SJ<br>Std</span>
        </div>
        <div class="productType position-absolute top-5em left-30 transform-translate--50_0 circle-L bg-color-soft-red grid-1-auto justify-items-center">
            <span class="font-size-0_8em text-center font-weight-bold">Tank<br>Pad</span>
        </div>
        <div class="productType position-absolute top-5em left-70 transform-translate--50_0 circle-L bg-color-grey grid-1-auto justify-items-center">
            <span class="font-size-0_8em text-center font-weight-bold">Busa<br>Stang</span>
        </div>
        <div class="position-absolute top-5em left-50 transform-translate--50_0 grid-1-auto justify-items-center" onclick="toggleProductType();">
            <div class="circle-medium bg-color-orange-2 grid-1-auto justify-items-center">
                <span class="color-white font-weight-bold font-size-1_5em">+</span>
            </div>
        </div>

    </div>

    <div id="btnProsesSPK" class="position-absolute bottom-0_5em w-calc-100-1em h-4em bg-color-orange-2 grid-1-auto" onclick="proceedSPK();">
        <span class="justify-self-center font-weight-900">PROSES SPK</span>
    </div>

</div>

<script>
    $('#btnProsesSPK').hide();
    let SPKItems = localStorage.getItem('SPKItems');
    getSPKItems();

    function getSPKItems() {
        if (SPKItems === '') {
            return false;
        }
        SPKItems = JSON.parse(SPKItems);
        console.log(SPKItems);
        let htmlItemList = '';
        for (const item of SPKItems) {
            htmlItemList = htmlItemList +
                `<div class='grid-2-auto p-0_5em bb-1px-solid-grey'>
                <div class=''>${item.bahan} ${item.varia} ${item.jht}</div>
                <div class='grid-1-auto'>
                <div class='color-green justify-self-right font-size-1_2em'>${item.jumlah}</div>
                <div class='color-grey justify-self-right'>Jumlah</div>
                </div>
                <div class='pl-0_5em color-blue-purple'>${item.desc}</div>
                </div>`;
        }
        $('#divItemList').html(htmlItemList);
        $('#btnProsesSPK').show();
    }
    history.pushState({
        page: 'SPKBegin'
    }, null);
    $(document).ready(function() {
        $(".productType").css("display", "none");
        $("#containerSJVaria").css("display", "none");
    });

    function toggleProductType() {
        $(".productType").toggle(500);
    }

    function toggleSJVaria() {
        history.pushState({
            page: 'SJVaria'
        }, 'test title');
        $(".productType").hide();
        $("#containerSJVaria").toggle();
        $("#containerBeginSPK").toggle();
    }

    window.addEventListener('popstate', (event) => {
        // console.log(event.state.page);
        // console.log(event)
        $('#SPKBaru').hide();
        $("#containerBeginSPK").hide();
        $('#containerSJVaria').hide();
        if (event.state == null) {
            history.go(-1);
        } else if (event.state.page == 'SJVaria') {
            $("#containerSJVaria").show();
        } else if (event.state.page == 'newSPK') {
            $('#SPKBaru').show();
        } else if (event.state.page == 'SPKBegin') {
            $('#containerBeginSPK').show();
        }
    });

    function proceedSPK() {
        for (const item of SPKItems) {
            $.ajax({
                type: 'POST',
                url: '01-crud.php',
                async: false,
                data: {
                    type: 'cek',
                    table: 'produk',
                    column: ['bahan', 'varia', 'ukuran', 'jahit'],
                    value: [item.bahan, item.varia, item.ukuran, item.jht, item.jumlah, item.desc]
                },
                success: function(res) {
                    console.log(res);
                }
            });
        }
    }
</script>

<?php
include_once "03-03-02-sj-varia.php";
?>