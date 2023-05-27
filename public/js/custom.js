$(function () {
    const data = JSON.parse(document.getElementById("datas").textContent);

    $("#niveauId").change(function (e) {
        let val = $("#niveauId").val();
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

                    $("#classeId").html(html);
                })
                .fail(function (error) {
                    $("#classeId").html("");
                });
        } else {
            $("#classeId").html("");
        }
    });
});
