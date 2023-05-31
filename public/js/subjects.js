$(function () {
    $("#niveaux").on("change", function () {
        let current = $("#niveaux").find(":selected").val();

        if (current !== "") {
            $.ajax({
                url: baseURL + data["get-classes-by-niveau"] + current,
                method: "get",
                dataType: "json",
            })
                .done(function (response) {
                    html = "";

                    for (const r of response["datas"]) {
                        html += `<option value="${r["id"]}">${r["libelle"]}</option>`;
                    }

                    $("#classes").html(html);
                })
                .fail(function () {
                    console.log("erreur recupération classes");
                });
        }
    });
});
