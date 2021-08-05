// open modal function

var upload_number = 1;
var upload_number_link = 1;

$(document).ready( function () {
    $('body').on('click', '.modal-open', function (e) {  
        e.preventDefault();

        let modal = $(this).data("modal");
        
        $('#'+ modal + "-modal").toggleClass('modal-of-show');
    });

    $('body').on('click', '.project-list-button', function (e) {  
        const target = e.target;


        if (target !== target.closest('.list-under') && 
                target !== target.closest('.header-project-search') && 
                target !== target.closest('svg')) {
                
            $(this).toggleClass('click-target');
        }

        if (target === target.closest('.header-project-search')) {
            if ($(this).hasClass('.click-target')) {
            } else {
                $(this).addClass('click-target');
            }
        }
    });

    $('body').on('click', '.modal-of', function (e) {

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

    $('body').on('click', '.click-input-delete', function (e) {
        e.preventDefault();
        $(this).remove();
    });

    $('body').on('change', '.input-file-first', function (e) {

        var fileName = $(this).val().split('/').pop().split('\\').pop();
        var id = $(this).attr("id");
        upload_number ++;
        var attachment = "attachment" + upload_number;

        var element = "." + id + "-block";
            
        $(element).attr('class', 'click-input-delete');

        $('label[for|="'+id+'"]').html("\<svg width=\"32\" height=\"32\" viewBox=\"0 0 32 32\" fill=\"none\" xmlns=\"http:\/\/www.w3.org\/2000\/svg\"\> \<rect width=\"32\" height=\"32\" rx=\"7\" fill=\"#FBFBFB\"\/\> \<rect x=\"0.25\" y=\"0.25\" width=\"31.5\" height=\"31.5\" rx=\"6.75\" stroke=\"#565252\" stroke-opacity=\"0.4\" stroke-width=\"0.5\"\/\> \<path d=\"M23.4719 11.6844L18.4406 6.65312C18.2969 6.50937 18.1531 6.4375 17.9375 6.4375H10.75C9.95937 6.4375 9.3125 7.08437 9.3125 7.875V25.125C9.3125 25.9156 9.95937 26.5625 10.75 26.5625H22.25C23.0406 26.5625 23.6875 25.9156 23.6875 25.125V12.1875C23.6875 11.9719 23.6156 11.8281 23.4719 11.6844ZM17.9375 8.1625L21.9625 12.1875H17.9375V8.1625ZM22.25 25.125H10.75V7.875H16.5V12.1875C16.5 12.9781 17.1469 13.625 17.9375 13.625H22.25V25.125Z\" fill=\"#565252\"\/\>  \<path d=\"M12.1875 20.8125H20.8125V22.25H12.1875V20.8125Z\" fill=\"#565252\"\/\> \<path d=\"M12.1875 16.5H20.8125V17.9375H12.1875V16.5Z\" fill=\"#565252\"\/\> \<\/svg\>");
        $('label[for|="'+id+'"]').append( fileName );
        console.log($('label[for|="'+id+'"]'));

        $("#moreUpload").append("\<div class=\""+ attachment +"-block\"\>\<label for=\""+ attachment +"\"\> \<svg width=\"32\" height=\"32\" viewBox=\"0 0 32 32\" fill=\"none\" xmlns=\"http:\/\/www.w3.org\/2000\/svg\"\> \<rect width=\"32\" height=\"32\" rx=\"7\" fill=\"#FBFBFB\"\/\> \<rect x=\"0.25\" y=\"0.25\" width=\"31.5\" height=\"31.5\" rx=\"6.75\" stroke=\"#565252\" stroke-opacity=\"0.4\" stroke-width=\"0.5\"\/\>\<path d=\"M8.88898 24.8889H19.5557V23.1111H8.88898V12.4444H7.11121V23.1111C7.11121 24.0916 7.90854 24.8889 8.88898 24.8889Z\" fill=\"#565252\"\/\>\<path d=\"M23.1112 7.1111H12.4445C11.4641 7.1111 10.6667 7.90843 10.6667 8.88888V19.5555C10.6667 20.536 11.4641 21.3333 12.4445 21.3333H23.1112C24.0916 21.3333 24.889 20.536 24.889 19.5555V8.88888C24.889 7.90843 24.0916 7.1111 23.1112 7.1111ZM21.3334 15.1111H18.6667V17.7778H16.889V15.1111H14.2223V13.3333H16.889V10.6667H18.6667V13.3333H21.3334V15.1111Z\" fill=\"#565252\"\/\>\<\/svg\>\<\/label\>\<input class=\"input-file-first\" style=\"display: none\" type=\"file\" name=\""+ attachment +"\" id=\""+ attachment +"\"\/\>");
    });

    $('body').on('change', '.input-link-first', function (e) {
        var id = $(this).attr("id");
        upload_number_link ++;
        var attachment = "lattachment" + upload_number_link;
        var element = "." + id + "-block";
        $("#" + id).attr('readonly', 'readonly');
        $("#" + id).attr('class', 'input-link-first input-readonly');
        
        $(element).attr('class', 'click-input-delete block-link-add');
        $('label[for|="'+id+'"]').html("\<svg width=\"19\" height=\"19\" viewBox=\"0 0 19 19\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\"\>\<path d=\"M15.8333 8.70833C15.6234 8.70833 15.422 8.79174 15.2735 8.94021C15.1251 9.08867 15.0417 9.29004 15.0417 9.5V14.25C15.0417 14.46 14.9583 14.6613 14.8098 14.8098C14.6613 14.9583 14.46 15.0417 14.25 15.0417H4.75C4.54004 15.0417 4.33867 14.9583 4.19021 14.8098C4.04174 14.6613 3.95833 14.46 3.95833 14.25V4.75C3.95833 4.54004 4.04174 4.33867 4.19021 4.19021C4.33867 4.04174 4.54004 3.95833 4.75 3.95833H9.5C9.70996 3.95833 9.91133 3.87493 10.0598 3.72646C10.2083 3.57799 10.2917 3.37663 10.2917 3.16667C10.2917 2.9567 10.2083 2.75534 10.0598 2.60687C9.91133 2.45841 9.70996 2.375 9.5 2.375H4.75C4.12011 2.375 3.51602 2.62522 3.07062 3.07062C2.62522 3.51602 2.375 4.12011 2.375 4.75V14.25C2.375 14.8799 2.62522 15.484 3.07062 15.9294C3.51602 16.3748 4.12011 16.625 4.75 16.625H14.25C14.8799 16.625 15.484 16.3748 15.9294 15.9294C16.3748 15.484 16.625 14.8799 16.625 14.25V9.5C16.625 9.29004 16.5416 9.08867 16.3931 8.94021C16.2447 8.79174 16.0433 8.70833 15.8333 8.70833Z\" fill=\"#565252\"/\>\<path d=\"M12.6667 3.95833H13.9175L8.93791 8.93C8.86371 9.0036 8.80481 9.09115 8.76462 9.18763C8.72443 9.2841 8.70374 9.38757 8.70374 9.49208C8.70374 9.59659 8.72443 9.70007 8.76462 9.79654C8.80481 9.89301 8.86371 9.98057 8.93791 10.0542C9.0115 10.1284 9.09906 10.1873 9.19554 10.2275C9.29201 10.2676 9.39548 10.2883 9.49999 10.2883C9.6045 10.2883 9.70798 10.2676 9.80445 10.2275C9.90092 10.1873 9.98848 10.1284 10.0621 10.0542L15.0417 5.0825V6.33333C15.0417 6.5433 15.1251 6.74466 15.2735 6.89313C15.422 7.04159 15.6234 7.125 15.8333 7.125C16.0433 7.125 16.2447 7.04159 16.3931 6.89313C16.5416 6.74466 16.625 6.5433 16.625 6.33333V3.16667C16.625 2.9567 16.5416 2.75534 16.3931 2.60687C16.2447 2.45841 16.0433 2.375 15.8333 2.375H12.6667C12.4567 2.375 12.2553 2.45841 12.1069 2.60687C11.9584 2.75534 11.875 2.9567 11.875 3.16667C11.875 3.37663 11.9584 3.57799 12.1069 3.72646C12.2553 3.87493 12.4567 3.95833 12.6667 3.95833Z\" fill=\"#565252\"/\>\</svg\>");
        $("#moreUpload-link").append("\<div class=\""+ attachment +"-link-block block-link-add\"\>\<label for=\""+ attachment +"-link\" href=\"javascript:;\"\>\<svg width=\"19\" height=\"19\" viewBox=\"0 0 19 19\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\"\>\<path d=\"M15.8333 8.70833C15.6234 8.70833 15.422 8.79174 15.2735 8.94021C15.1251 9.08867 15.0417 9.29004 15.0417 9.5V14.25C15.0417 14.46 14.9583 14.6613 14.8098 14.8098C14.6613 14.9583 14.46 15.0417 14.25 15.0417H4.75C4.54004 15.0417 4.33867 14.9583 4.19021 14.8098C4.04174 14.6613 3.95833 14.46 3.95833 14.25V4.75C3.95833 4.54004 4.04174 4.33867 4.19021 4.19021C4.33867 4.04174 4.54004 3.95833 4.75 3.95833H9.5C9.70996 3.95833 9.91133 3.87493 10.0598 3.72646C10.2083 3.57799 10.2917 3.37663 10.2917 3.16667C10.2917 2.9567 10.2083 2.75534 10.0598 2.60687C9.91133 2.45841 9.70996 2.375 9.5 2.375H4.75C4.12011 2.375 3.51602 2.62522 3.07062 3.07062C2.62522 3.51602 2.375 4.12011 2.375 4.75V14.25C2.375 14.8799 2.62522 15.484 3.07062 15.9294C3.51602 16.3748 4.12011 16.625 4.75 16.625H14.25C14.8799 16.625 15.484 16.3748 15.9294 15.9294C16.3748 15.484 16.625 14.8799 16.625 14.25V9.5C16.625 9.29004 16.5416 9.08867 16.3931 8.94021C16.2447 8.79174 16.0433 8.70833 15.8333 8.70833Z\" fill=\"#565252\"/\>\<path d=\"M12.6667 3.95833H13.9175L8.93791 8.93C8.86371 9.0036 8.80481 9.09115 8.76462 9.18763C8.72443 9.2841 8.70374 9.38757 8.70374 9.49208C8.70374 9.59659 8.72443 9.70007 8.76462 9.79654C8.80481 9.89301 8.86371 9.98057 8.93791 10.0542C9.0115 10.1284 9.09906 10.1873 9.19554 10.2275C9.29201 10.2676 9.39548 10.2883 9.49999 10.2883C9.6045 10.2883 9.70798 10.2676 9.80445 10.2275C9.90092 10.1873 9.98848 10.1284 10.0621 10.0542L15.0417 5.0825V6.33333C15.0417 6.5433 15.1251 6.74466 15.2735 6.89313C15.422 7.04159 15.6234 7.125 15.8333 7.125C16.0433 7.125 16.2447 7.04159 16.3931 6.89313C16.5416 6.74466 16.625 6.5433 16.625 6.33333V3.16667C16.625 2.9567 16.5416 2.75534 16.3931 2.60687C16.2447 2.45841 16.0433 2.375 15.8333 2.375H12.6667C12.4567 2.375 12.2553 2.45841 12.1069 2.60687C11.9584 2.75534 11.875 2.9567 11.875 3.16667C11.875 3.37663 11.9584 3.57799 12.1069 3.72646C12.2553 3.87493 12.4567 3.95833 12.6667 3.95833Z\" fill=\"#565252\"/\>\</svg\></label\>\<input class=\"input-link-first\" type=\"url\" name=\""+ attachment +"-link\" id=\""+ attachment +"-link\" placeholder=\"Add link...\"/\>\</div\>");
    });

})

function calendarRangeDays(selectedDates, instance) {
    var $parent = $(instance.element).parent('.calendar');
    var date1 = new Date(selectedDates[0]);
    var date2 = new Date(selectedDates[1]);
    var timeDiff = Math.abs(date2.getTime() - date1.getTime());
    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 

    console.log(date1 + " " + date2);
  }
  
  $('.calendar__input').flatpickr({
    inline: true,
    mode: 'range',
    onChange: function(selectedDates, dateStr, instance) {
      calendarRangeDays(selectedDates, instance);
    },
    onReady: function(selectedDates, dateStr, instance) {
      calendarRangeDays(selectedDates, instance);
    },
  });

  
  

