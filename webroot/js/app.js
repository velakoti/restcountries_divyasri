
$(document).ready(function () {

    $("#tableSearch").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $(".country-container").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            if ($(this).css("display") == "none") {
                $(this).removeClass("exists");
            }
            else {
                $(this).addClass("exists");
            }

        });

        if ($(".country-container.exists").length == 0) {
            $('#no-results-container').fadeIn("slow");
        } else {
            $('#no-results-container').hide();
        }

    });

});

$(document).ready(function () {
    $('#countrydatatable').DataTable();
});