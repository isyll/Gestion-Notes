$(".delete-btn").click(function (e) {
    e.preventDefault();
    const form = $(this).closest("form");

    $("#modal-btn-yes").click(function () {
        form.submit();
    });
});

