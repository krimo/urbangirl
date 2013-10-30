$(document).foundation();

var searchClass = document.getElementById( 'sb-search' ),
    menuClass = document.getElementById( 'cbp-hsmenu-wrapper' ),
    slidesnumber = parseInt($('#slidesnumber').text(),10);

if (searchClass) {
    new UISearch(searchClass);
}

if (menuClass) {
    new cbpHorizontalSlideOutMenu(menuClass);
}

imagesLoaded( document.querySelector('body'), function() {

    var mySwiper = $('.swiper-container').swiper({
        mode:'horizontal',
        loop: true,
        calculateHeight: true,
        slidesPerView: slidesnumber
    });

    $('.swiper-nav').on('click', function(e) {
        e.preventDefault();

        if ($(this).is('.swiper-next')) {
            mySwiper.swipeNext();
        } else {
            mySwiper.swipePrev();
        }
    });

    $('img:not(.ug-logo)').addClass('img-loaded');

    if ($.cookie('ug_preferences') && $('#authentication').text() == '0' && !$.cookie('categoriesShown')) {
        $('html,body').animate({scrollTop:$('#custom-content-begin').offset().top}, 500);
        $.cookie("categoriesShown", 1);
    }

});

$('.ug-menu-toggle').on('click', function() {
    $('.cbp-hsmenu-wrapper').toggleClass('open');
});


var ugCheckbox = document.querySelectorAll('.ug-switch-btn'),
    i=0;

$.each(ugCheckbox, function() {
    i++;

    var mySwitch = new Switch(this),
        eventType = ( !mobilecheck() ) ? 'click' : 'touchstart';

    mySwitch.el.addEventListener(eventType, function(e){
        e.preventDefault();
        mySwitch.toggle();
    }, false);

    if (i === 1 && !$.cookie('ug_preferences') && $('#authentication').text() == '0') {
        mySwitch.toggle();
    }
});

$('.zero-out').on('click', function(e) {
    e.preventDefault();

    $.each(ugCheckbox, function() {
        if (this.checked) {
            $('input[name='+this.name+']').parent().find('.ios-switch').click();
        }
    });
});

$.fn.isOnScreen = function(){

    var win = $(window);

    var viewport = {
        top : win.scrollTop()
    };
    viewport.bottom = viewport.top + win.height();

    var bounds = this.offset();
    bounds.bottom = bounds.top + this.outerHeight();

    return (!(viewport.bottom < bounds.top || viewport.top > bounds.bottom));

};

var hasShareLoaded = false,
    hasHellocotonLoaded = false;
$(window).scroll(function() {
    if($('.ug-footer').isOnScreen()) {
        $('#ug-scroll-top-btn, .bottom-page-prompt').addClass('open');
    } else {
        $('.bottom-page-prompt, #ug-scroll-top-btn').removeClass('open');
    }

    if ($('.ug-share-article').length) {
        if (!hasShareLoaded && $('.ug-share-article').isOnScreen()) {
            loadTwitter();
            // loadFacebook();
            loadGooglePlus();
            hasShareLoaded = true;
        }
    }

    if ($('#hellocoton-script').isOnScreen()) {
        if (!hasHellocotonLoaded && $('#hellocoton-script').isOnScreen()) {
            var helloCotonScript = document.createElement('script');
            helloCotonScript.src = 'http://widget.hellocoton.fr/friends/urbangirl/250px';
            document.getElementById('hellocoton-script').appendChild(helloCotonScript);
            hasHellocotonLoaded = true;
        }
    }
});

$('#ug-scroll-top-btn').on('click', function(e) {
    e.preventDefault();
    $('html,body').animate({scrollTop:$(this.hash).offset().top}, 500);
});

$('.bottom-page-prompt .close-prompt').on('click', function() {
    $(this).parent().removeClass('open');
    return false;
});

$('.ug-category-read-more button').click(function() {

    $('.ug-category-description').addClass('open');

    $(this).parent().fadeOut();

    // prevent jump-down
    return false;

});

$('.social-link').on('click', function(e) {
    e.preventDefault();
    window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');
});

$(function() {

    // Find all YouTube videos
    var $allVideos = $("iframe[src^='//www.youtube.com']"),

        // The element that is fluid width
        $fluidEl = $allVideos.parent();

    // Figure out and save aspect ratio for each video
    $allVideos.each(function() {

        $(this)
            .data('aspectRatio', this.height / this.width)

            // and remove the hard coded width/height
            .removeAttr('height')
            .removeAttr('width');

    });

    // When the window is resized
    // (You'll probably want to debounce this)
    $(window).resize(function() {

        var newWidth = $fluidEl.width();

        // Resize all videos according to their own aspect ratio
        $allVideos.each(function() {

            var $el = $(this);
            $el
                .width(newWidth)
                .height(newWidth * $el.data('aspectRatio'));

        });

    // Kick off one resize to fix all videos on page load
    }).resize();

});

$('.ug-newsletter-form').on('submit', function(e) {
    e.preventDefault();
    var self = $(this),
        alertBox = self.siblings('.ug-form-alert');
    $.ajax({
        url: templateDirUri+"/mailjet-handler.php",
        method: "POST",
        data: self.serialize(),
        success: function(data) {
            if (parseInt(data, 10)) {
                alertBox.addClass('success');
                alertBox.find('span').text('E-mail enregistre.');
            } else {
                alertBox.addClass('error');
                alertBox.find('span').text('Oups. Merci de re-essayer.');
            }

            alertBox.addClass('open');
        }
    });
});

/**
 * Enregistrement du formulaire de personalisation
 */
$('#ug-modal-save-form').on('valid', function(e) {

    var theData = $('.ug-personalization-form').serialize();

    theData = theData.split('&');
    theData.pop();
    theData = theData.join('&');

    $("#ug-preferences-input").attr('value', theData);

});

$('#no-thanks, #save-email-modal .close-reveal-modal').on('click', function(e) {
    e.preventDefault();
    $('.ug-personalization-form').submit();
});

/**
 * Récupération des données du formulaire de perso
 */
if ($('.ug-personalization-data').html())  {
    var prefString = $('.ug-personalization-data').html().split('&amp;');

    $.each(prefString, function() {
        var i = this.split("=");

        $('input[name='+i[0]+']').parent().find('.ios-switch:not(.on)').click();
    });

}

function loadTwitter() {
    if (typeof (twttr) != 'undefined'){
        twttr.widgets.load();
    } else {
        $.getScript('http://platform.twitter.com/widgets.js');
    }
}

function loadFacebook() {
    if (typeof (FB) != 'undefined') {
        FB.init({ status: true, cookie: true, xfbml: true });
    } else {
        $.getScript("//connect.facebook.net/fr_FR/all.js", function () {
            FB.init({ status: true, cookie: true, xfbml: true });
        });
    }
}

function loadGooglePlus(){
    if (typeof (gapi) != 'undefined') {
        $(".g-plusone").each(function () {
            gapi.plusone.render($(this).get(0));
        });
    } else {
        $.getScript('https://apis.google.com/js/plusone.js');
    }
}
