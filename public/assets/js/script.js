/* Script */

//tooltips BS
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});

function dismiss(){
    $('.alert').alert('close');
}

$(document).ready(function(){
    /* Dismiss alert after 3200ms */
    setTimeout(dismiss, 2800);
})






