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
    /* Dismiss alert after 3520ms */
    setTimeout(dismiss, 3520);

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
    

    /* Icon success */
    var successIcon = document.getElementById('icon-success-container');

    var animationSuccess = bodymovin.loadAnimation({
    //animation data
    container: successIcon,
    path: 'https://maxst.icons8.com/vue-static/landings/animated-icons/icons/cool/cool.json',
    renderer: 'svg',
    loop: false,
    autoplay: true,
    name: "Success",
    
    });

    animationSuccess.setSpeed(0.45);

    /* Icon warning */
    var warningIcon = document.getElementById('icon-warning-container');

    var animationWarning = bodymovin.loadAnimation({
    //animation data
    container: warningIcon,
    path: 'https://maxst.icons8.com/vue-static/landings/animated-icons/icons/warning-1/warning-1.json',
    renderer: 'svg',
    loop: false,
    autoplay: true,
    name: "Warning",
    
    });

    animationWarning.setSpeed(0.45);

    /* Icon handshake */
    var handsIcon = document.getElementById('icon-handshake-container');

    var animationHandshake = bodymovin.loadAnimation({
    //animation data
    container: handsIcon,
    path: 'https://maxst.icons8.com/vue-static/landings/animated-icons/icons/handshake/handshake.json',
    renderer: 'svg',
    loop: false,
    autoplay: true,
    name: "Handshake",
    
    });

    animationHandshake.goToAndPlay(14, true);
    animationHandshake.setSpeed(0.23);
})








