$(function () {
    const data = JSON.parse(document.getElementById("datas").textContent);

    $("#niveau").change(function (e) {
        let val = $("#niveau").val();
        const getClasses = data["get-classe-by-niveau"];

        if (val !== "") {
            $.ajax({
                method: "GET",
                url: baseURL + getClasses + val,
                dataType: "json",
            })
                .done(function (response) {
                    let classes = response["datas"];
                    let html = "";

                    classes.forEach((element) => {
                        html += `<option value="${element["id"]}">${element["libelle"]}</option>`;
                    });

                    $("#classe").html(html);
                })
                .fail(function (error) {
                    $("#classe").html("");
                });
        } else {
            $("#classe").html("");
        }
    });
});
