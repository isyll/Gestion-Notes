$(function () {
    $("#updateCoefsBtn").on("click", function () {
        let datas = {
            classeId: getClasseId,
            coefs: {},
        };

        $(".inputCoef")
            .toArray()
            .some(function (input) {
                input = $(input);
                let val = process(input.val()),
                    name = input.attr("name"),
                    typeCoef = input.attr("typeCoef");

                if (typeof datas.coefs[name] === "undefined")
                    datas.coefs[name] = {};

                datas.coefs[name][typeCoef] = val;
            });

        $.ajax({
            type: "post",
            url: baseURL + data["update-coefs"],
            data: JSON.stringify(datas),
            dataType: "json",
        }).done(function (response) {
            response = response["datas"];

            if (response.status === "done")
                $("#resultMsg").addClass("text-success");
            else $("#resultMsg").addClass("text-danger");

            $("#resultMsg").text(response.msg);
        });
    });
});
