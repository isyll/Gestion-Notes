$(function () {
    let dbNotes = getNotes(),
        notDoThisSubject = "Ne fait pas cette discipline",
        faireDisc;

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

    function enableSubjectStudentStates() {
        $(".hasThisSubject")
            .toArray()
            .some(function (e) {
                $(e).prop("disabled", false);
            });
    }

    function disableSubjectStudentStates() {
        $(".hasThisSubject")
            .toArray()
            .some(function (e) {
                $(e).prop("disabled", true);
            });
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
            classAverage();
            enableSubjectStudentStates();

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
                        $('.studentNote[data-student-id="' + r.e_id + '"]').val(
                            r.note
                        );
                    }

                    faireDisc = response.datas.cde;

                    for (const r of faireDisc) {
                        $(
                            '.hasThisSubject[data-student-id="' + r.e_id + '"]'
                        ).prop("checked", r.faire_disc ? true : false);

                        $('.studentNote[data-student-id="' + r.e_id + '"]')
                            .prop("disabled", r.faire_disc ? false : true)
                            .addClass(r.faire_disc ? "" : "do-not-subject");

                        $(
                            '.notDoThisSubject[data-student-id="' +
                                r.e_id +
                                '"]'
                        ).text(r.faire_disc ? "" : notDoThisSubject);
                    }

                    if (response.datas.notes.length) {
                        dbNotes = getNotes();
                        classAverage();

                        let maxNote = response.datas.notes[0]["max_note"];

                        clearMaxNote();
                        clearMaxNoteSep();

                        if (maxNote == 0) disableStudentNotes();
                        else {
                            fillMaxNote(maxNote);
                        }
                    } else {
                        clearMaxNote();
                        clearMaxNoteSep();

                        if (typeof response.datas.max_note !== "undefined") {
                            enableStudentNotes();

                            if (response.datas.max_note.max_note == 0)
                                disableStudentNotes();
                            else fillMaxNote(response.datas.max_note.max_note);
                        }
                    }

                    studentNoteColorHandler();
                } else {
                    $("#resultMsg").text(response.msg);
                }
            });
        } else {
            disableStudentNotes();
            disableSubjectStudentStates();
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

    function success(msg) {
        $("#resultMsg").removeClass("alert-danger p-0");
        $("#resultMsg").addClass("alert-success");
        $("#resultMsg").text(msg);
    }

    function error(msg) {
        $("#resultMsg").removeClass("alert-success p-0");
        $("#resultMsg").addClass("alert-danger");
        $("#resultMsg").text(msg);
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
                    success(response.datas.msg);
                })
                .fail(function () {
                    error("Une erreur s'est produite veuillez réessayez");
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
                if (!$(element).hasClass("do-not-subject"))
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
                    sum += parseFloat(val);
                }
            });

        avg = total !== 0 ? Math.floor((sum / total) * 100) / 100 : "";
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

                    if (val > max) $(e).val(String(val).slice(0, -1));
                    else if (val < 0) $(e).val(0);

                    if (process($(e).val()) != "") {
                        if (parseInt($(e).val()) < max / 2) color(e, "danger");
                        else color(e, "success");
                    }
                }
            });
        });

    $(".hasThisSubject")
        .toArray()
        .some(function (e) {
            $(e).on("click", function () {
                const currentCheck = this;

                if ($(this).is(":checked")) {
                    $(
                        '.studentNote[data-student-id="' +
                            $(currentCheck).attr("data-student-id") +
                            '"]'
                    ).prop("disabled", false);

                    $(
                        '.notDoThisSubject[data-student-id="' +
                            $(currentCheck).attr("data-student-id") +
                            '"]'
                    ).text("");

                    let datas = {
                        e_id: $(currentCheck).attr("data-student-id"),
                        subjectId: $("#chooseSubject").val(),
                        classeId: getClasseDatas().id,
                    };

                    $.ajax({
                        method: "post",
                        url: baseURL + data["restore-subject-to-student"],
                        data: JSON.stringify(datas),
                        dataType: "json",
                    }).done(function (response) {
                        // console.log(response["datas"]);
                    });
                } else {
                    $(
                        '.studentNote[data-student-id="' +
                            $(currentCheck).attr("data-student-id") +
                            '"]'
                    )
                        .val("")
                        .prop("disabled", true);

                    classAverage();
                    removeColor(
                        document.querySelector(
                            '.studentNote[data-student-id="' +
                                $(currentCheck).attr("data-student-id") +
                                '"]'
                        )
                    );

                    $(
                        '.notDoThisSubject[data-student-id="' +
                            $(currentCheck).attr("data-student-id") +
                            '"]'
                    ).text(notDoThisSubject);

                    let datas = {
                        e_id: $(currentCheck).attr("data-student-id"),
                        subjectId: $("#chooseSubject").val(),
                        classeId: getClasseDatas().id,
                    };

                    $.ajax({
                        method: "post",
                        url: baseURL + data["remove-subject-to-student"],
                        data: JSON.stringify(datas),
                        dataType: "json",
                    }).done(function (response) {
                        // console.log(response["datas"]);
                    });
                }
            });
        });
});

function modal() {
    $("#modalSpinner").modal("show");
    setTimeout(function () {
        $("#modalSpinner").modal("hide");
    }, 600);
}
