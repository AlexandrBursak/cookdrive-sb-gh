// function up page show
function upPage() {
    if ($(window).scrollTop() > $(window).height() / 3) {
        $("#up_page").fadeIn(500);
    }
    else {
        $("#up_page").fadeOut(500);
    }
}

//quantity of products in order
function cart_quantity() {
    $('.catalog_product_quantity .plus').click(function () {
        var plus_input = $(this).closest(".catalog_product_quantity").find('input');
        $(plus_input).val(Number($(plus_input).val()) + 1);
    });

    $('.catalog_product_quantity .minus').click(function () {
        var minus_input = $(this).closest(".catalog_product_quantity").find('input');
        if (Number($(minus_input).val()) > 1) {
            $(minus_input).val(Number($(minus_input).val()) - 1);
        }
    });
}

function update_global_cart(cart_count) {
    $('.cart_navbar a').text(cart_count + ' шт.');

    if (Number($('.cart_navbar a').text().charAt(0)) > 0) {
        $('.cart_navbar a').addClass('active');
    }
    else {
        $('.cart_navbar a').removeClass('active');
    }
}

function update_cart(data) {
    $('#response').html(data.cart_html);
    update_global_cart(data.cart_count);
    cart_quantity();
    cart_res();
}

function cart_res() {

    $('.order_remove a').on("click", function (e) {
        e.preventDefault();
        $.ajax({
            url: '/cart/clear',
            type: 'GET',
            success: function (res) {
                if (res) {
                    res = JSON.parse(res);
                    update_cart(res)
                } else {
                    alert('Error! Error!');
                }
            },
            error: function (err) {
                alert('Error! ' + err);
            }
        });
    });

    $('.one_order_item_remove').on("click", function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        $.ajax({
            url: '/cart/del',
            data: {id: id},
            type: 'GET',
            success: function (res) {
                if (res) {
                    res = JSON.parse(res);
                    update_cart(res)
                } else {
                    alert('Error! Error!');
                }
            },
            error: function () {
                alert('Error!');
            }
        });
    });

    $('.one_order_item_info input').on("change", function (e) {
        e.preventDefault();
        var id = $(this).data('id'),
            qty = $(this).val();
        $.ajax({
            url: '/cart/change',
            data: {id: id, qty: qty},
            type: 'GET',
            success: function (res) {
                if (res) {
                    res = JSON.parse(res);
                    update_cart(res)
                } else {
                    alert('Error! Error!');
                }
            },
            error: function () {
                alert('Error!');
            }
        });
    });

    $('.one_order_item_info .plus').on("click", function (e) {
        e.preventDefault();
        var id = $(this).closest(".catalog_product_quantity").find('input').data('id'),
            qty = $(this).closest(".catalog_product_quantity").find('input').val();
        $.ajax({
            url: '/cart/change',
            data: {id: id, qty: qty},
            type: 'GET',
            success: function (res) {
                if (res) {
                    res = JSON.parse(res);
                    update_cart(res)
                } else {
                    alert('Error! Error!');
                }
            },
            error: function () {
                alert('Error!');
            }
        });
    });

    $('.one_order_item_info .minus').on("click", function (e) {
        e.preventDefault();
        var id = $(this).closest(".catalog_product_quantity").find('input').data('id'),
            qty = $(this).closest(".catalog_product_quantity").find('input').val();
        $.ajax({
            url: '/cart/change',
            data: {id: id, qty: qty},
            type: 'GET',
            success: function (res) {
                if (res) {
                    res = JSON.parse(res);
                    update_cart(res)
                } else {
                    alert('Error! Error!');
                }
            },
            error: function () {
                alert('Error!');
            }
        });
    });

    if (Number($('.cart_navbar a').text().charAt(0)) > 0) {
        $('.cart_navbar a').addClass('active');
    }

    confirm_order();
    colorBalance();

    $(".catalog_product_quantity input").keypress(function (e) {
        if (e.which < 48 || e.which > 57) {
            return false;
        }
    });
}


function confirm_order() {
    $('#to_order').on("click", function (e) {
        e.preventDefault();
        var arr_error = [];
        $(".one_order_item .catalog_product_quantity input").each(function(){
            var value = Number($(this).val());  
            if (value > 0 && value % 1 == 0) {
                $(this).removeClass('active');
            }
            else{
                arr_error.push(value);
                $(this).addClass('active');
            }
        });

        if (arr_error.length == 0) {
            $.ajax({
                url: '/cart/confirm',
                type: 'POST',
                success: function (res) {
                    if (res) {
                        res = JSON.parse(res);
                        if (res['balance']) {
                            $.fancybox({
                                content: '<div class="success active"><p>Ваше замовлення не прийнято.</p><span>Поповніть рахунок!</span></div>'
                            });
                        }
                        else{
                            update_global_cart(res.cart_count);
                            update_cart(res);
                            colorBalance();
                            $.fancybox({
                                content: '<div class="success"><p>Ваше замовлення успішно оформлено.</p><span>СМАЧНОГО!</span></div>'
                            });
                            setTimeout(function () {
                                $.fancybox.close();
                            }, 3000);
                        }
                    } else {
                        $('.google.auth-link').click();
                    }
                },
                error: function () {
                    alert('Error!');
                }
            });
        }
        else{
            $.fancybox({
                content: '<div class="success active"><p>Некоректні дані</p><span>Замовлення<br> не приянято!</span></div>'
            });
        }
    });
}

function colorBalance() {
    if (Number($('.balance_before span').text()) < 0) {
        $('.balance_before span').addClass('active');
    }
    else{
        $('.balance_before span').removeClass('active');
    }
}

var subscribeEvents = function() {
    $(".replace-confirm").on("click", function() {
        var orderID = $("#pModal").attr("data-order-id");
        var qty = 0;
        $("#pModal").trigger("replaceconfirm", {
            orderId: orderID, itemId: $(this).attr("data-id"), qty: $(this).closest(".setting").find(".qty").val()
        });
        $("#pModal").modal("hide");
    });
};

$("#search-form").on("pjax:end", function() {
    subscribeEvents();
});

subscribeEvents();



$(window).scroll(upPage);

$(document).ready(function () {

    $('.add_to_cart').on("click", function (e) {
        e.preventDefault();
        var id = $(this).data('id'),
            qty = $(this).closest(".catalog_product_footer").find(".qty").val();

            qty = Number(qty); 
        if (qty > 0 && qty % 1 == 0) {
            $(this).closest(".catalog_product_footer").find(".qty").removeClass('active');

            $.ajax({
                url: '/cart/add',
                data: {id: id, qty: qty},
                type: 'GET',
                success: function (res) {
                    if (res) {
                        res = JSON.parse(res);
                        update_global_cart(res.cart_count);
                    } else {
                        alert('Error! Error!');
                    }
                },
                error: function () {
                    alert('Error!');
                }
            });
        }
        else{
            $(this).closest(".catalog_product_footer").find(".qty").addClass('active');
            $.fancybox({
                content: '<div class="success active"><p>Некоректні дані</p><span>Замовлення<br> не приянято!</span></div>'
            });
        }
    });


    cart_quantity();

    cart_res();

// up page 
    $('#up_page').click(function () {
        $('html, body').animate({scrollTop: 0}, 500);
        return false;
    });

// only numbers 
    $(".catalog_product_quantity input").keypress(function (e) {
        if (e.which < 48 || e.which > 57) {
            return false;
        }
    });

    $('.subcategori_list a').click(function (e) {
        e.preventDefault();
        var id = $(this).text();

        var top = $('.subcategori_title h2').filter(function() {
            return $(this).text() === id;
        }).offset().top - $('.navbar').height() - 15; 

        $('html, body').animate({scrollTop: top}, 500);
    });


     $('.product_user .admin_order_one:first').addClass('active');

    $('.user_order_block_up').click(function(e){
        e.preventDefault();
        if($(this).closest('.admin_order_one').hasClass('active')){
            $(this).closest('.admin_order_one').removeClass('active');
            $(this).closest('.admin_order_one').find('.user_order_block_dn').slideUp();
        }else {
            $(this).closest('.admin_order_one').addClass('active');
            $(this).closest('.admin_order_one').find('.user_order_block_dn').slideDown();
        }
    });

    $('.all_user_order_block_slide').click(function(e){
        e.preventDefault();
        $(this).text($(this).hasClass('active') ? 'Розгорнути всі' : 'Згорнути всі')
        if($('.all_user_order_block_slide').hasClass('active')){
            $('.all_user_order_block_slide').removeClass('active');
            $('.admin_order_one').removeClass('active');
            $('.user_order_block_dn').slideUp();
        }else {
            $('.all_user_order_block_slide').addClass('active');
            $('.admin_order_one').addClass('active');
            $('.user_order_block_dn').slideDown();
        }
    });

    colorBalance();

});
