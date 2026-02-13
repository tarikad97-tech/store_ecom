(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner(0);


    // Fixed Navbar
    $(window).scroll(function () {
        if ($(window).width() < 992) {
            if ($(this).scrollTop() > 55) {
                $('.fixed-top').addClass('shadow');
            } else {
                $('.fixed-top').removeClass('shadow');
            }
        } else {
            if ($(this).scrollTop() > 55) {
                $('.fixed-top').addClass('shadow').css('top', -55);
            } else {
                $('.fixed-top').removeClass('shadow').css('top', 0);
            }
        } 
    });
    
    
   // Back to top button
   $(window).scroll(function () {
    if ($(this).scrollTop() > 300) {
        $('.back-to-top').fadeIn('slow');
    } else {
        $('.back-to-top').fadeOut('slow');
    }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Testimonial carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 2000,
        center: false,
        dots: true,
        loop: true,
        margin: 25,
        nav : true,
        navText : [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ],
        responsiveClass: true,
        responsive: {
            0:{
                items:1
            },
            576:{
                items:1
            },
            768:{
                items:1
            },
            992:{
                items:2
            },
            1200:{
                items:2
            }
        }
    });


    // vegetable carousel
    $(".vegetable-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        center: false,
        dots: true,
        loop: true,
        margin: 25,
        nav : true,
        navText : [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ],
        responsiveClass: true,
        responsive: {
            0:{
                items:1
            },
            576:{
                items:1
            },
            768:{
                items:2
            },
            992:{
                items:3
            },
            1200:{
                items:4
            }
        }
    });


    // Modal Video, Quantity buttons handler, and Delete item handler
    $(document).ready(function () {
        var $videoSrc;
        
        // Modal Video
        $('.btn-play').click(function () {
            $videoSrc = $(this).data("src");
        });
        console.log($videoSrc);

        $('#videoModal').on('shown.bs.modal', function (e) {
            $("#video").attr('src', $videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0");
        })

        $('#videoModal').on('hide.bs.modal', function (e) {
            $("#video").attr('src', $videoSrc);
        })

        // Quantity buttons handler
        console.log('Quantity handler initialized');
        
        // Handle clicks on quantity buttons
        $(document).on('click', '.quantity .btn-plus, .quantity .btn-minus', function (e) {
            e.preventDefault();
            e.stopPropagation();
            
            
            var button = $(this);
            var row = button.closest('tr');
            
            if (row.length === 0) {
                console.log('Row not found');
                return;
            }
            
            var quantityInput = row.find('.quantity_input');
            if (quantityInput.length === 0) {
                console.log('Quantity input not found');
                return;
            }
            
            var oldValue = parseFloat(quantityInput.val()) || 1;
            console.log('Old value:', oldValue);
            
            var newVal;
            if (button.hasClass('btn-plus')) {
                newVal = oldValue + 1;
                console.log('Plus clicked, new value:', newVal);
            } else if (button.hasClass('btn-minus')) {
                if (oldValue > 1) {
                    newVal = oldValue - 1;
                } else {
                    newVal = 1;
                }
                console.log('Minus clicked, new value:', newVal);
            } else {
                return;
            }
            
            quantityInput.val(newVal);
            
            var prixpr = parseFloat(row.find('.price_pr').val());
            console.log('Price:', prixpr);
            
            if (isNaN(prixpr)) {
                console.log('Price is NaN');
                return;
            }
            
            var quantity = parseFloat(newVal); 
            var totalPrice = prixpr * quantity;
            console.log('Total price:', totalPrice);
            
            row.find('.total_price').text(totalPrice.toFixed(2) + "DH");
            // function update qty in database
             $.ajax({
                url: 'php/update_cart.php',
                type: 'POST',
                data: {
                    id_sdpa: row.find('.delete_item').data('id'),
                    qte: newVal
                },
                success: function (response) {
                    console.log('Quantity updated successfully:', response);
                },
                error: function (error) {
                    console.error('Error updating quantity:', error);
                }
             });
        });

        // Delete item handler
        console.log('Delete item handler initialized');
        $(document).on('click', '.delete_item', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var button = $(this);
            var itemId = button.data('id');
            console.log('Delete button clicked for item ID:', itemId);
            $.ajax({
                url: 'php/delete_item.php',
                type: 'POST',
                data: { id: itemId },
                success: function (response) {
                    console.log('Item deleted successfully:', response);
                    button.closest('tr').remove();
                },
                error: function (error) {
                    console.error('Error deleting item:', error);
                }
            });
        });
    });

})(jQuery);



