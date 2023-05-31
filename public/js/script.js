$(".delete-btn").click(function (e) {
    e.preventDefault();
    const form = $(this).closest("form");

    $("#modal-btn-yes").click(function () {
        form.submit();
    });
});

$(".modalBtnTransfer").click(function () {
    let data = $(this).attr("dataToTransfer");
    let id = $(this).attr("dataTargetId");
    $(id).val(data);
});
