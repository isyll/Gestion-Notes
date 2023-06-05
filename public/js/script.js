$(function () {
    $(".delete-btn").click(function (e) {
        e.preventDefault();
        const form = $(this).closest("form");

        $(".modal-btn-yes").click(function () {
            form.submit();
        });
    });

    $(".dataClickTransfer").click(function () {
        let data = $(this).attr("dataToTransfer");
        let id = $(this).attr("dataTargetId");
        $(id).val(data);
    });
});
