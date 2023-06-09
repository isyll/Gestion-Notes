$(function () {
    $("#updateCoefsBtn").on("click", function () {
        let datas = {
            classeId: getClasseId,
            coefs: {},
        };

        $("#resultMsg").removeClass("text-success text-danger").text("");

        $(".inputCoef")
            .toArray()
            .some(function (input) {
                input = $(input);
                let val = process(input.val()),
                    name = input.attr("name"),
                    typeMax = input.attr("typeMax");

                if (typeof datas.coefs[name] === "undefined")
                    datas.coefs[name] = {};

                datas.coefs[name][typeMax] = val;
                input.removeClass("is-invalid");
            });

        $.ajax({
            type: "post",
            url: baseURL + data["update-coefs"],
            data: JSON.stringify(datas),
            dataType: "json",
        }).done(function (response) {
            response = response["datas"];
console.log(response);
            if (response.status === "done")
                $("#resultMsg").addClass("text-success");
            else $("#resultMsg").addClass("text-danger");

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
    });
});
