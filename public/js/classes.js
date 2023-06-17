$(function () {
    let clone = $(".addNoteTypeEdit").first().clone(),
        initialNoteTypes;

    $("#insertNoteTypeBtn").click(function () {
        let c = clone.clone();
        c.appendTo($("#addNoteTypeEditGroup"));

        $(".removeAddNoteField")
            .toArray()
            .some(function (e) {
                $(e).click(function () {
                    if ($(".addNoteTypeEdit").length > 1)
                        $(this).parent().remove();
                });
            });
    });

    $(".manageNiveauBtn")
        .toArray()
        .some(function (e) {
            $(e).click(function () {
                let nt = JSON.parse($(e).attr("data-noteTypes"));

                initialNoteTypes = nt;

                $("#addNoteTypeEditGroup").html("");
                for (const t of nt) {
                    let c = clone.clone();
                    c.find(".addNoteTypeInput")
                        .prop("readonly", true)
                        .val(t.nom_type);
                    c.find(".removeAddNoteField").replaceWith(
                        '<button type="button" class="removeNoteTypeBtn remove btn btn-link p-1"><i class="text-danger bi bi-trash-fill"></i></button>'
                    );
                    c.appendTo($("#addNoteTypeEditGroup"));
                }

                clone.clone().appendTo($("#addNoteTypeEditGroup"));

                $(".removeNoteTypeBtn")
                    .toArray()
                    .some(function (e) {
                        $(e).click(function () {
                            if ($(this).hasClass("remove")) {
                                $(this)
                                    .siblings(".addNoteTypeInput")
                                    .prop("disabled", true);

                                $(this).html(
                                    '<i class="bi bi-arrow-clockwise"></i>'
                                );

                                $(this).removeClass("remove");
                            } else {
                                $(this)
                                    .siblings(".addNoteTypeInput")
                                    .prop("disabled", false);

                                $(this).html(
                                    '<i class="text-danger bi bi-trash-fill"></i>'
                                );

                                $(this).addClass("remove");
                            }
                        });
                    });
            });
        });
});
