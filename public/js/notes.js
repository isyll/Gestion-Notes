$(function () {
    let dbNotes = getNotes();

    function getFilterData() {
        let datas = {};

        $(".filterNotesSelect")
            .toArray()
            .some(function (element) {
                datas[$(element).attr("name")] = $(element).val();
            });

        return datas;
    }

    function getClasseDatas() {
        let datas = JSON.parse($("#classeDatas").text().trim());
        return datas;
    }

    function clearNotes() {
        $("[data-student-id]")
            .toArray()
            .some(function (e) {
                $(e).val("");
            });
    }

    function clearMaxNote() {
        $(".max-note")
            .toArray()
            .some(function (e) {
                $(e).text("");
            });
    }

    function clearMaxNoteSep() {
        $(".max-note-sep")
            .toArray()
            .some(function (e) {
                $(e).text("");
            });
    }

    function fillMaxNoteSep() {
        $(".max-note-sep")
            .toArray()
            .some(function (e) {
                $(e).text(" / ");
            });
    }

    function fillMaxNote(maxNote) {
        $(".max-note")
            .toArray()
            .some(function (e) {
                $(e).text(maxNote);
            });

        fillMaxNoteSep();
        enableStudentNotes();
    }

    clearMaxNoteSep();

    function notesFilterHandler() {
        let given = true;

        $(".filterNotesSelect")
            .toArray()
            .some(function (element) {
                if ($(element).val() === "") {
                    given = false;
                }
            });

        let datas = getFilterData();
        datas.classeId = getClasseDatas().id;

        clearNotes();

        if (given) {
            $.ajax({
                method: "post",
                url: baseURL + data["get-student-notes"],
                data: JSON.stringify(datas),
                dataType: "json",
            }).done(function (response) {
                response = response.datas;

                studentNoteColorHandler();
                if (response.status === "done") {
                    for (const r of response.datas.notes) {
                        $('[data-student-id="' + r.e_id + '"]').val(r.note);
                    }

                    if (response.datas.notes.length) {
                        dbNotes = getNotes();
                        classAverage();

                        let maxNote =
                            response.datas.notes[0][
                                "max_" + $("#chooseType").val()
                            ];

                        clearMaxNote();
                        clearMaxNoteSep();

                        if (maxNote == 0) disableStudentNotes();
                        else {
                            fillMaxNote(maxNote);
                        }
                    } else {
                        clearMaxNote();
                        clearMaxNoteSep();

                        if (typeof response.datas.cd !== "undefined") {
                            enableStudentNotes();

                            if (response.status == "done") {
                                if (
                                    response.datas.cd[
                                        "max_" + $("#chooseType").val()
                                    ] == 0
                                )
                                    disableStudentNotes();
                                else {
                                    fillMaxNote(
                                        response.datas.cd[
                                            "max_" + $("#chooseType").val()
                                        ]
                                    );
                                }
                            }
                        }
                    }

                    studentNoteColorHandler();
                } else {
                    $("#resultMsg").text(response.msg);
                }
            });
        } else {
            disableStudentNotes();
        }
    }

    function getNotes() {
        let datas = {};

        $(".studentNote")
            .toArray()
            .some(function (e) {
                datas[$(e).attr("data-student-id")] = $(e).val();
            });

        return datas;
    }

    function compareNotesDatas(a1, a2) {
        return JSON.stringify(a1) === JSON.stringify(a2);
    }

    function saveNotesHandler() {
        let datas = [];

        $(".studentNote")
            .toArray()
            .some(function (element) {
                if (
                    process($(element).val()) !== "" &&
                    !isNaN($(element).val())
                ) {
                    datas.push({
                        e_id: $(element).attr("data-student-id"),
                        note: $(element).val(),
                        note_type: $("#chooseType").val(),
                        cycle: $("#chooseCycle").val(),
                        subjectId: $("#chooseSubject").val(),
                    });
                }
            });

        if (Object.keys(datas).length != 0)
            $.ajax({
                method: "post",
                url: baseURL + data["update-student-notes"],
                data: JSON.stringify(datas),
                dataType: "json",
            })
                .done(function (response) {
                    dbNotes = getNotes();
                    updateSaveBtnActivity();
                    classAverage();

                    $("#resultMsg").removeClass("text-danger");
                    $("#resultMsg").addClass("text-success");
                    $("#resultMsg").text(response.datas.msg);
                })
                .fail(function (response) {
                    $("#resultMsg").removeClass("text-success");
                    $("#resultMsg").addClass("text-danger");
                    $("#resultMsg").text(response.datas.msg);
                });
    }

    function disableStudentNotes() {
        $(".studentNote")
            .toArray()
            .some(function (element) {
                $(element).prop("disabled", true);
            });
    }

    function enableStudentNotes() {
        $(".studentNote")
            .toArray()
            .some(function (element) {
                $(element).prop("disabled", false);
            });
    }

    function removeColor(e) {
        let cl = [
            "text-success",
            "text-danger",
            "border",
            "border-success",
            "border-danger",
        ];

        cl.forEach(function (i) {
            $(e).removeClass(i);
            $(e).next().removeClass(i);
            $(e).next().next().removeClass(i);
        });
    }

    function color(e, cl) {
        cl = "text-" + cl;
        let op = cl == "text-success" ? "text-danger" : "text-success",
            border =
                cl == "text-success"
                    ? "border border-success"
                    : "border border-danger",
            borderOp =
                cl == "text-success"
                    ? "border border-danger"
                    : "border border-success";

        removeColor(e);

        $(e).removeClass(op);
        $(e).removeClass(borderOp);
        $(e).next().removeClass(op);
        $(e).next().next().removeClass(op);

        if (!$(e).hasClass(cl)) $(e).addClass(cl);
        if (!$(e).hasClass(border)) $(e).addClass(border);
        if (!$(e).next().hasClass(cl)) $(e).next().addClass(cl);
        if (!$(e).next().next().hasClass(cl)) $(e).next().next().addClass(cl);
    }

    function studentNoteColorHandler() {
        $(".studentNote")
            .toArray()
            .some(function (e) {
                let max = parseInt($(e).next().next().text().trim());

                removeColor(e);
                if (!isNaN(max)) {
                    if (process($(e).val()) != "") {
                        if (parseInt($(e).val()) < max / 2) color(e, "danger");
                        else color(e, "success");
                    }
                }
            });
    }

    function classAverage() {
        let avg = 0,
            sum = 0,
            total = 0;

        $(".studentNote")
            .toArray()
            .some(function (e) {
                let val = process($(e).val());

                if (val != "" && !isNaN(val)) {
                    total++;
                    sum += parseInt(val);
                }
            });

        avg = sum / total;
        $("#classAvg").text("Moyenne classe : " + avg);
    }

    function disableSaveBtn() {
        $("#updateNotesBtn").prop("disabled", true);
    }

    function enableSaveBtn() {
        $("#updateNotesBtn").prop("disabled", false);
    }

    function updateSaveBtnActivity() {
        if (!compareNotesDatas(getNotes(), dbNotes)) enableSaveBtn();
        else disableSaveBtn();
    }

    notesFilterHandler();

    $(".filterNotesSelect")
        .toArray()
        .some(function (element) {
            $(element).change(notesFilterHandler);
        });

    $("#updateNotesBtn").click(function () {
        saveNotesHandler();
        studentNoteColorHandler();
    });

    disableSaveBtn();

    $(".studentNote")
        .toArray()
        .some(function (e) {
            e.addEventListener("input", function () {
                let max = parseInt($(e).next().next().text().trim());

                updateSaveBtnActivity();
                removeColor(e);
                if (!isNaN(max)) {
                    let val = $(e).val();

                    if (val > max) $(e).val(max);
                    else if (val < 0) $(e).val(0);

                    if (process($(e).val()) != "") {
                        if (parseInt($(e).val()) < max / 2) color(e, "danger");
                        else color(e, "success");
                    }
                }
            });
        });
});
