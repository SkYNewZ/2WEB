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

$(".form_quantity").on('click', function () {
    var id = $(this).data('id');
    var current_value = parseInt($('#quantity_edit-' + id).html());
    var sign = parseInt($(this).data('value'));
    if (!(current_value + sign) <= 0){
        $.ajax({
            url: $(this).data('url'),
            data: "id_article=" + $(this).data('id') + '&id_receipt=' + $(this).data('receipt') + '&sign=' + sign,
            type: 'get',
            success: function (e) {
                $('#quantity_edit-' + id).text(parseInt($('#quantity_edit-' + id).html()) + sign);
                $('#edit_total').text($('#edit_total').data('text') + e + '€');
            }
        })
    }
});

// delete from cart
$('.dete_form_cart').on('click', function () {
    var id = $(this).data('id');
    var url = $(this).data('url');
    var div = $('.rem_' + id);
    $.ajax({
        url: url,
        success: function (e) {
            div.fadeOut(function () {
                $(this).remove();
                if($('#tbody-history').children().length <= 0){
                    window.location.reload();
                }
            });
        }
    })
});

$('.history-quantity').on('click', function () {
    var url = $(this).data('url');
    var id = $(this).data('id');
    $.ajax({
        url: url,
        success: function (e) {
            if (e['new_quantity'] == 0){
                window.location.reload();
            }
            $('#quantity_edit-' + id).text(e['new_quantity']);
        }
    })
});

$('.valid_receipt').on('click', function (e) {
    e.preventDefault();
    var id = $(this).data('id');
    var url = $(this).data('url');
    var txt = $(this).data('txt');
    $.ajax({
        url: url,
        success: function (html) {
            $('#validation_' + id).html(' - ');
            $('#eta_' + id).html(txt + "<span class='glyphicon glyphicon-ok' style='color: green'></span>");
            $('#receipts_valid').text(parseInt($('#receipts_valid').html()) + 1);
            $('#receipts_pending').text(parseInt($('#receipts_pending').html()) - 1);
        }
    })
});