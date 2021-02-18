/* Script */

/* Animated icon hamburger with lottie */
const hamburger = document.getElementById('hamburger');
let state = 'play';

var animation = bodymovin.loadAnimation({
    container: hamburger, // Required
    path: 'https://assets5.lottiefiles.com/temp/lf20_Qi3v7b.json', // Required
    renderer: 'svg', // Required
    loop: false, // Optional
    autoplay: false, // Optional
    name: "menu", // Name for future reference. Optional.
    speed: 2
  })

$(document).ready(function(){
    /* Dismiss alert after 2800ms */
    setTimeout(dismiss, 2800);

    /* Menu mobile */
    $('#navbarSupportedContent').on('show.bs.collapse', function(e){
        e.preventDefault();
        $('.overlay').addClass('display');
        if(state === 'play'){
            animation.setSpeed(2);
            animation.playSegments([3, 80], true);
            state = 'pause';
            $('.overlay').addClass('display');
            $('.overlay').removeClass('disappear');
        } else {
            animation.playSegments([80, 0], true);
            state = 'play';
            $('.overlay').addClass('disappear');
            $('.overlay').removeClass('display');
            
        }
        
    })
        

    //tooltips BS
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    function dismiss(){
        $('.alert').alert('close');
    }
    
})








