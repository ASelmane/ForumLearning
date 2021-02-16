/* Script */

//tooltips BS
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});

function dismiss(){
    $('.alert').alert('close');
}

$(document).ready(function(){
    /* Dismiss alert after 2800ms */
    setTimeout(dismiss, 2800);
})






