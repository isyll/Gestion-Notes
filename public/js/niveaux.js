(function () {
    $("#insertNoteTypeBtn").click(function () {
        let clone = $(".add-note-type").clone();
        clone.appendTo($("#addNoteTypeEdit"));
    });
})();
