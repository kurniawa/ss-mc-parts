function deleteItems (id, table, column) {
    let results;
    $.ajax({
        type: "POST",
        url: "01-crud.php",
        cache: false,
        async: false,
        data: {
            id: id,
            table: table,
            column: column,
            type: "delete"
        },
        success: function (responseText) {
            console.log(responseText);
            results = responseText;
        }
    });

    return results;
}