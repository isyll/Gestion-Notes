$(function () {
    let dbMaxNoteDatas = getMaxNoteDatas();

    function getMaxNoteDatas() {
        let datas = {};

        $(".inputCoef")
            .toArray()
            .some(function (input) {
                input = $(input);
                let val = process(input.val()),
                    name = input.attr("name"),
                    type = input.attr("data-noteType");

                if (val != "") {
                    if (typeof datas[name] === "undefined") datas[name] = {};

                    datas[name][type] = val;
                    input.removeClass("is-invalid");
                }
            });

        return datas;
    }

    function compareMaxNotes(a1, a2) {
        return JSON.stringify(a1) === JSON.stringify(a2);
    }

    function updateBtnActivity() {
        if (!compareMaxNotes(getMaxNoteDatas(), dbMaxNoteDatas))
            $("#updateCoefsBtn").prop("disabled", false);
        else $("#updateCoefsBtn").prop("disabled", true);
    }

    $(".inputCoef")
        .toArray()
        .some(function (e) {
            e.addEventListener("input", function () {
                let val = $(e).val();

                updateBtnActivity();

                if (parseInt(val) < 10)
                    $("#updateCoefsBtn").prop("disabled", true);
                else if (!compareMaxNotes(getMaxNoteDatas(), dbMaxNoteDatas))
                    $("#updateCoefsBtn").prop("disabled", false);
            });
        });

    $("#updateCoefsBtn").on("click", function () {
        let datas = {
            classeId: getClasseId,
            coefs: {},
        };

        $("#resultMsg")
            .removeClass("alert-success alert-danger")
            .addClass("p-0")
            .text("");

        datas.coefs = getMaxNoteDatas();

        if (Object.keys(datas.coefs) != 0) {
            $("#updateCoefsBtn").prop("disabled", false);

            $.ajax({
                type: "post",
                url: baseURL + data["update-coefs"],
                data: JSON.stringify(datas),
                dataType: "json",
            }).done(function (response) {
                response = response.datas;
                console.log(response);

                if (response.status === "done") {
                    $("#resultMsg")
                        .addClass("alert-success")
                        .removeClass("p-0");
                    dbMaxNoteDatas = getMaxNoteDatas();
                    updateBtnActivity();
                } else $("#resultMsg").addClass("alert-danger").removeClass("p-0");

                if (typeof response.errors !== "undefined") {
                    for (const e in response.errors) {
                        for (const i of response.errors[e]) {
                            let elem = $("*")
                                .filter(`[name="${e}"][typeMax="${i.typeMax}"]`)
                                .addClass("is-invalid");

                            if (elem.next().hasClass("invalid-feedback"))
                                elem.next().text(i.msg);
                            else
                                $(
                                    `<div class="invalid-feedback">${i.msg}</div>`
                                ).insertAfter(elem);
                        }
                    }
                }

                $("#resultMsg").text(response.msg);
            });
        } else $("#updateCoefsBtn").prop("disabled", true);
    });

    $("#updateCoefsBtn").prop("disabled", true);
});
