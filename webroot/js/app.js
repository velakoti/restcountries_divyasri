
$(document).ready(function () {

    $("#tableSearch").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $(".country-container").filter(function () {
            if (value.length > 0) {
                $('.page').addClass('searching');
                $('#cards-pagination').hide();
            } else {
                $('.page').removeClass('searching');
                $('#cards-pagination').show();
            }
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



    $('#pagination-demo').twbsPagination({
        totalPages: 5,
        startPage: 1,
        visiblePages: 5,
        initiateStartPageClick: true,
        hideOnlyOnePage: false,
        href: false,
        pageVariable: '{{page}}',
        totalPagesVariable: '{{total_pages}}',
        page: null,
        first: 'First',
        prev: 'Previous',
        next: 'Next',
        last: 'Last',
        loop: false,
        beforePageClick: null,
        onPageClick: function (event, page) {
            $('.page-active').removeClass('page-active');
            $('#page' + page).addClass('page-active');
        },
        paginationClass: 'pagination',
        nextClass: 'page-item next',
        prevClass: 'page-item prev',
        lastClass: 'page-item last',
        firstClass: 'page-item first',
        pageClass: 'page-item',
        activeClass: 'active',
        disabledClass: 'disabled',
        anchorClass: 'page-link'
    });
});


var mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function () { scrollFunction() };

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        mybutton.style.display = "block";
    } else {
        mybutton.style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}
