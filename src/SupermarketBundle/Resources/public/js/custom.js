/**
 * Created by quentin on 13/05/17.
 */
addEventListener("load", function () {
    setTimeout(hideURLbar, 0);
}, false);
function hideURLbar() {
    window.scrollTo(0, 1);
}

jQuery(document).ready(function ($) {
    $(".scroll").click(function (event) {
        event.preventDefault();
        $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1000);
    });
    jQuery('#demo1').skdslider({
        'delay': 5000,
        'animationSpeed': 2000,
        'showNextPrev': true,
        'showPlayButton': true,
        'autoSlide': true,
        'animationType': 'fading'
    });

    jQuery('#responsive').change(function () {
        $('#responsive_wrapper').width(jQuery(this).val());
    });
});


$(document).ready(function () {
    /*
     var defaults = {
     containerID: 'toTop', // fading element id
     containerHoverID: 'toTopHover', // fading element hover id
     scrollSpeed: 1200,
     easingType: 'linear'
     };
     */

    $().UItoTop({easingType: 'easeOutQuart'});
    // Mini Cart
    paypal.minicart.render({
        action: '#'
    });

    if (~window.location.search.indexOf('reset=true')) {
        paypal.minicart.reset();
    }

});

function changePageSize(url, size) {
    window.location = url + '?size=' + size;
}

function changePageTri(url, tri) {
    window.location = url + '?size=' + size;
}

$('#add-to-cart').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: $(this).attr('action'), // Le nom du fichier indiqué dans le formulaire
        type: $(this).attr('method'), // La méthode indiquée dans le formulaire (get ou post)
        data: $(this).serialize(),//, Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
        success: function(html) { // Je récupère la réponse du fichier PHP
            $.fancybox.open({
                src  : '#hidden-content'
            })
        }
    });
});