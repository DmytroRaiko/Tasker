// open modal function

$(document).ready( function () {
    $('body').on('click', '.modal-open', function (e) {  
        e.preventDefault();

        let modal = $(this).data("modal");
        
        $('#'+ modal + "-modal").toggleClass('modal-of-show');
    })

    $('body').on('click', '.modal-of', function (e) {
        e.preventDefault();

        const target = e.target;

        if (target.closest('.x-close')) {
            $(this).parent('.modal-of');
            modal = $(this).attr('id');
            $('#' + modal).removeClass('modal-of-show');
        }
        
        if (target === target.closest('.modal-of')) {
            modal = $(this).attr('id');
            $('#' + modal).removeClass('modal-of-show');
        }
    });  
})

