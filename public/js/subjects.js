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
        } else {
            $("#classes").html("");
        }
    });

    let subjGrpHandler = () => {
        if ($("#subjectGroup").find(":selected").val() === "") {
            $("#editGroupBtn").addClass("disabled");
            $("#deleteGrpBtn").addClass("disabled");
        } else {
            $("#editGroupBtn").removeClass("disabled");
            $("#deleteGrpBtn").removeClass("disabled");
        }

        $("#deleteGroupId").val($("#subjectGroup").find(":selected").val());

        let id;
        if ((id = $("#subjectGroup").find(":selected").val()) !== "") {
            $("#groupId").val(id);
        } else $("#groupId").val(id);
    };

    subjGrpHandler();

    $("#subjectGroup").change(function () {
        subjGrpHandler();
    });
});
