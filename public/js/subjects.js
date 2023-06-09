$(function () {
    var activity = {
        addeds: [],
        removeds: [],

        set add(sbj) {
            this.addeds.push(sbj);
            this.updateBtnActivity();
        },
        set del(sbj) {
            this.removeds.push(sbj);
            this.updateBtnActivity();
        },
        restore: function (sbj) {
            let tmp = [];

            for (const e of this.removeds) {
                if (e != sbj) tmp.push(e);
            }

            this.removeds = tmp;
            this.updateBtnActivity();
        },
        cancelAdd: function (sbj) {
            let tmp = [];

            for (const e of this.addeds) {
                if (e != sbj) tmp.push(e);
            }

            this.addeds = tmp;
            this.updateBtnActivity();
        },
        updateBtnActivity: function () {
            if (this.addeds.length > 0 || this.removeds.length > 0)
                $("#updateSubjectsBtn").removeClass("disabled");
            else $("#updateSubjectsBtn").addClass("disabled");
        },
        update: function (classe) {
            let datas = {
                classeId: classe,
                add: this.addeds,
                del: this.removeds,
            };

            $.ajax({
                url: baseURL + data["update-subjects"],
                method: "post",
                contentType: "application/json",
                dataType: "json",
                data: JSON.stringify(datas),
            }).done(function (response) {
                let datas = response["datas"];

                if (datas.status === "done") {
                    $("#updateMsg").addClass("text-success").text(datas.msg);
                } else {
                    $("#updateMsg").addClass("text-danger").text(datas.msg);
                }
            });

            this.addeds = [];
            this.removeds = [];
            this.updateBtnActivity();
        },
    };

    function niveauxHander() {
        let current = $("#niveaux").find(":selected").val();

        if (current !== "") {
            $.ajax({
                url: baseURL + data["get-classes-by-niveau"] + current,
                method: "get",
                dataType: "json",
            }).done(function (response) {
                html = "";

                for (const r of response["datas"]) {
                    html += `<option value="${r["id"]}">${r["libelle"]}</option>`;
                }

                $("#classes").html(html);

                let event = new Event("change");
                document.getElementById("classes").dispatchEvent(event);
            });
        } else {
            $("#classes").html("");
            let event = new Event("change");
            document.getElementById("classes").dispatchEvent(event);
        }
    }

    function sbjGrpOptionsHandler() {
        if ($("#subjectGroup").find(":selected").val() === "") {
            $("#editGroupBtn").addClass("disabled");
            $("#deleteGrpBtn").addClass("disabled");
        } else {
            $("#editGroupBtn").removeClass("disabled");
            $("#deleteGrpBtn").removeClass("disabled");
        }
    }

    function sbjGrpHandler() {
        $("#deleteGroupId").val($("#subjectGroup").find(":selected").val());

        let id;

        if ((id = $("#subjectGroup").find(":selected").val()) !== "") {
            $("#groupId").val(id);
        } else $("#groupId").val("");

        sbjGrpOptionsHandler();
    }

    function classeHandler() {
        let title = "Les disciplines de la classe ",
            help =
                '<br/><small class="text-danger fw-normal" style="font-size: 0.5em;"> Décochez une discipline pour la supprimer';

        let current,
            linkText = "Gérer les coefficients de la classe ";

        if (
            (current = $("#classes").find(":selected").val()) !== "" &&
            $("#niveaux").find(":selected").val() !== ""
        ) {
            let content =
                "<code>" + $("#classes").find(":selected").text() + "</code>";
            $("#subjectsTitle").html(title + content + help);

            loadClasseSubjects(current);
            $("#handleClasseSbjBtn").css("display", "block");

            let a = $("#handleClasseSbjBtn").find("a");
            a.attr("href", getUrls['classe-coef'] + current);
            a.text(linkText + $("#classes").find(":selected").text());
        } else {
            $("#subjectsTitle").html("");
            $("#subjectsContainer").html("");

            $("#handleClasseSbjBtn").css("display", "none");
        }
    }

    function subjectsHandler() {
        let allConditionMet = true;

        if ($("#niveaux").val() === "") {
            $("#niveauxHelp").html("Sélectionner d'abord un niveau");
            allConditionMet = false;
        } else $("#niveauxHelp").html("");

        if ($("#classes").val() === "") {
            $("#classesHelp").html("Sélectionner une classe");
            allConditionMet = false;
        } else $("#classesHelp").html("");

        if ($("#subject").val() === "") {
            $("#subjectHelp").html("Saisissez une discipline");
            allConditionMet = false;
        } else $("#subjectHelp").html("");

        if (allConditionMet) {
            let current = $("#classes").find(":selected").val(),
                group = $("#subjectGroup").find(":selected").val(),
                subject = $("#subject").val();

            $.ajax({
                url:
                    baseURL +
                    data["has-subject"] +
                    current +
                    "/" +
                    process(subject),
                method: "get",
                dataType: "json",
            }).done(function (response) {
                if (response["datas"][0]) {
                    msg(
                        "Cette classe possède déjà la discipline " + subject,
                        "error"
                    );
                } else {
                    $.ajax({
                        url: baseURL + data["subject-exists"] + subject,
                        method: "get",
                        dataType: "json",
                    }).done(function (response) {
                        if (response["datas"][0]) {
                            insertSubject(subject);
                        } else {
                            if ($("#subjectGroup").val() !== "") {
                                const modal = new bootstrap.Modal(
                                    "#createSubjectConfirm"
                                );
                                modal.show();

                                $("#createSubjectConfirm")
                                    .find(".createSubjectBtn")
                                    .click(function () {
                                        let infos = {
                                            groupId: group,
                                            subjectName: subject,
                                        };

                                        $.ajax({
                                            url:
                                                baseURL +
                                                data["create-subject"],
                                            method: "post",
                                            contentType: "application/json",
                                            data: JSON.stringify(infos),
                                            dataType: "json",
                                        }).done(function (response) {
                                            if (
                                                response["datas"]["status"] ===
                                                "done"
                                            ) {
                                                msg(
                                                    response["datas"]["msg"],
                                                    "success"
                                                );

                                                insertSubject(subject);
                                            } else {
                                                msg(
                                                    response["datas"]["msg"],
                                                    "error"
                                                );
                                            }
                                        });
                                    });
                            } else {
                                const modal = new bootstrap.Modal(
                                    "#selectSbjGrpModal"
                                );
                                modal.show();
                            }
                        }
                    });
                }
            });
        }

        function msg(msgText, type) {
            $("#subjectHelp").removeClass(
                type === "error" ? "text-success" : "text-danger"
            );
            $("#subjectHelp").addClass(
                type === "success" ? "text-success" : "text-danger"
            );

            $("#subjectHelp").html(msgText);
        }

        function insertSubject(subject) {
            var exists = false;

            $("#subjectsContainer").find("#msbj").remove();

            $("#subjectsContainer")
                .find("label")
                .toArray()
                .some(function (label) {
                    let labelText = $(label)
                        .clone()
                        .children()
                        .remove()
                        .end()
                        .text();
                    if (process(subject) === process(labelText)) {
                        exists = true;
                        return;
                    }
                });

            if (exists) {
                msg("Vous avez déjà ajouté cette discipline", "error");
            } else {
                let sbj = `<input checked type="checkbox" class="new-added-subject me-1 form-check-input" name="${process(
                    subject
                )}" id="${process(
                    subject
                )}" /><label class="me-5 fst-italic" for="${process(
                    subject
                )}">${subject.toUpperCase()}<code style="font-size:88%;" class="ms-2">(nouveau)</code></label>`;

                $("#subjectsContainer").append(sbj);

                $(".new-added-subject").on("change", function () {
                    if (!$(this).is(":checked")) {
                        activity.cancelAdd($(this).attr("name"));
                        $('label[for="' + $(this).attr("id") + '"]').remove();
                        $(this).remove();

                        return;
                    }
                });

                activity.add = subject;
            }
        }
    }

    function loadClasseSubjects(classe) {
        $.ajax({
            url: baseURL + data["get-classe-subjects"] + classe,
            method: "get",
            dataType: "json",
        }).done(function (response) {
            let html =
                '<span class="text-danger" id="msbj">Pas encore de discipline pour cette classe </span>';

            if (response["datas"].length) {
                html = "";
                for (const d of response["datas"]) {
                    html += `<input checked type="checkbox" class=" me-1 subjectItem form-check-input" name="${d["code"]}" sbjName="${d["nom"]}" id="${d["code"]}" /><label class=" me-5" for="${d["code"]}">${d["nom"]} (${d["code"]})</label>`;
                }
            }

            $("#subjectsContainer").html(html);

            $('input[type="checkbox"].subjectItem').on("change", function () {
                let code = $(this).attr("id");
                let label = $('label[for="' + code + '"]');

                if ($(this).is(":checked")) {
                    label.removeClass("text-danger");
                    activity.restore(process($(this).attr("sbjName")));
                } else {
                    label.addClass("text-danger");
                    $(this).removeAttr("checked");
                    activity.del = process($(this).attr("sbjName"));
                }
            });
        });
    }

    function process(s) {
        return s.toLowerCase().trim().replace(/\s+/g, " ");
    }

    function updateHandler() {
        let classe;

        if ((classe = $("#classes").find(":selected").val()) != "") {
            activity.update(classe);
            loadClasseSubjects(classe);
        } else $("#updateSubjectsBtn").addClass("disabled");
    }

    sbjGrpOptionsHandler();

    $("#niveaux").on("change", niveauxHander);

    $("#subjectGroup").change(sbjGrpHandler);

    $("#classes").change(classeHandler);

    $("#addSubjectBtn").click(subjectsHandler);

    $("#updateSubjectsBtn").click(updateHandler);

    activity.updateBtnActivity();
    $("#handleClasseSbjBtn").css("display", "none");
});
