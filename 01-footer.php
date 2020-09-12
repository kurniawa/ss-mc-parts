<script>
    function showDropDown(id) {
        $selectedDiv = $("#divDetailDropDown-" + id);
        $selectedDiv.toggle(400);

        setTimeout(() => {
            if ($selectedDiv.css("display") === "block") {
                $("#divDropdown-" + id + " img").attr("src", "img/icons/dropup.svg");
            } else {
                $("#divDropdown-" + id + " img").attr("src", "img/icons/dropdown.svg");
            }
        }, 450);
    }
</script>

<script src="js/functions.js"></script>

</body>

</html>