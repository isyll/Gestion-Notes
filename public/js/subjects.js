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

                    let event = new Event("change");
                    document.getElementById("classes").dispatchEvent(event);
                })
                .fail(function () {
                    console.log("erreur recupération classes");
                });
        } else {
            $("#classes").html("");
            let event = new Event("change");
            document.getElementById("classes").dispatchEvent(event);
        }
    });

    function subjGrpHandler() {
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
        } else $("#groupId").val("");
    }

    function classeHandler() {
        let title = "Les disciplines de la classe ",
            help =
                '<br/><small class="text-danger fw-normal" style="font-size: 0.5em;"> Décochez une discipline pour la supprimer';

        if (
            $("#classes").find(":selected").val() !== "" &&
            $("#niveaux").find(":selected").val() !== ""
        ) {
            let content =
                "<code>" + $("#classes").find(":selected").text() + "</code>";
            $("#subjectsTitle").html(title + content + help);
        } else $("#subjectsTitle").html("");
    }

    classeHandler();
    subjGrpHandler();

    $("#subjectGroup").change(function () {
        subjGrpHandler();
    });

    $("#classes").change(function () {
        classeHandler();
    });
});
