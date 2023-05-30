$(".delete-btn").click(function (e) {
    e.preventDefault();
    const form = $(this).closest("form");

    $("#modal-btn-yes").click(function () {
        form.submit();
    });
});

$(".editNiveauBtn").click(function () {
    let niveauId = $(this).attr("niveauId");
    $("#editNiveauForm").find('[name="niveauId"]').val(niveauId);
});

$(".editClasseBtn").click(function () {
    let classeId = $(this).attr("classeId");
    $("#editClasseForm").find('[name="classeId"]').val(classeId);
});
