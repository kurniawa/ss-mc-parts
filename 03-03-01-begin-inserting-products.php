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

    <div class="divProductList"></div>

    <div id="divAddItems" class="h-9em position-relative mt-1em">
        <div class="productType position-absolute top-0 left-50 transform-translate--50_0 circle-L bg-color-orange-1 grid-1-auto justify-items-center" onclick="toggleSJBasic();">
            <span class="font-size-0_8em text-center font-weight-bold">SJ<br>Basic</span>
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

</div>

<script>
    $(document).ready(function() {
        $(".productType").css("display", "none");
        $("#containerSJBasic").css("display", "none");
    });

    function toggleProductType() {
        $(".productType").toggle(500);
    }

    function toggleSJBasic() {
        $("#containerSJBasic").toggle();
        $("#containerBeginSPK").toggle();
    }
</script>

<?php
include_once "03-03-02-sj-basic-new.php";
?>