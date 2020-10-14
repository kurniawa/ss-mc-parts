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

function elementToToggle (elements) {
    console.log(elements);
    for (const element of elements) {
        $(element.id).toggle(element.time);
    }
}

function getLastID (table) {
    let results;
    $.ajax({
        type: "POST",
        url: "01-crud.php",
        cache: false,
        async: false,
        data: {
            table: table,
            type: "last"
        },
        success: function (responseText) {
            console.log(responseText);
            results = responseText;
        }
    });
    return results;
}

function liveSearch (key, table, column) {
    let results;
    $.ajax({
        type: "POST",
        url: "01-crud.php",
        cache: false,
        async: false,
        data: {
            key: key,
            table: table,
            column: column,
            type: "live-search"
        },
        success: function (responseText) {
            console.log(responseText);
            results = responseText;
        }
    });
    return results;
}

function formatDate (date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;

    return [day, month, year].join('-');
}

// function insertToDB (table, column, value, data_length) {
//     let sqlPart1 = "INSERT INTO $table(";
//     let sqlPart2 = " VALUE(";

//     for (let i = 0; i < $data_length; i++) {
//         if (i === ($data_length - 1)) {
//             sqlPart1 = `${sqlPart1}${column[i]})`;
//             sqlPart2 = `${sqlPart2}'${value[i]}')`;
//         } else {
//             sqlPart1 = `${sqlPart1}${column[i]}, `;
//             sqlPart2 = `${sqlPart2}'${value[$i]}', `;
//         }
//     }
//     let sql = sqlPart1 + sqlPart2;
//     console.log(sql)

    // $msg = "Query: ".$sql. " SUCCESSFULLY EXECUTED.";
    // $res = mysqli_query($con, $sql);

    // if (!$res) {
    //     echo json_encode(array("error", "Error: ".$sql. "<br>".mysqli_error($con)));
    //     die;
    // } else {
    //     echo json_encode(array("insert", $msg));
    // }
// }