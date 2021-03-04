$(document).on("click",'#boton-agregar-item', function(e){
//    e.preventDefault();

    var color = $('#agregarform-color_id').val();
    var talla = $('#agregarform-talla_id').val();
    var producto = $('#agregarform-producto_id').val();
    var cantidad = $('#agregarform-cantidad').val();   
                
    $('#formulario-carrito').on('submit',function( event ){
        // event.preventDefault();
        // event.stopPropagation();
        $('#formulario-carrito button').attr('disabled');
        if(!color || !talla || !producto || !cantidad){
            $('#formulario-carrito button').removeAttr('disabled');
            $('.error-producto').removeClass('oculto');
            $('.error-producto').html("Please select color and size")
            return false;
        }
        $('.error-producto').addClass('oculto');
        $.ajax({
            url: $('#base_path').val()+'/producto/agregar-carrito',
            type: 'post',
            'data': {talla,color,producto,cantidad},
            dataType: 'json',
            beforeSend: function(){
                $('#formulario-carrito .spinner').show();
            },
            success: function(respuesta){
                $('#formulario-carrito button').removeAttr('disabled');
                $('#formulario-carrito .spinner').hide();
                // $('#mas-productos').slideDown(function(){
                //     resize();
                //     jQuery('body,html').animate({
                //         scrollTop: $('#formulario-carrito').offset().top
                //     }, 800);
                // });
                // $('#respuesta-carrit').text(respuesta.mensaje);
                if(respuesta.exito == '1'){
                    $('#boton-agregar-item').html('Item added to shopping bag');
                    $("#boton-agregar-item").prop('disabled',true);
                    var cantidad_bolsa = $('#bolsa span').text();
                    cantidad_bolsa++;
                    // console.log(cantidad_bolsa);
                    $('#bolsa span').text(cantidad_bolsa);
                    $('.botones-agregar-carrito').removeClass('oculto');
                }else{
                    $('.btn-taller').html("Error at adding to shopping bag");

                    // $('#respuesta-carrito').addClass('no-agregado').fadeIn();
                }
            }
        });
        event.stopImmediatePropagation();
        return false;
    });
});

$(document).on("change",'#agregarform-color_id', function(){
    var color = $('#agregarform-color_id').val();
    var talla = $('#agregarform-talla_id').val();
    var producto = $('#agregarform-producto_id').val();

    $('#soldemail-talla_id').val(talla);
    $('#soldemail-color_id').val(color);
    $('#soldemail-producto_id').val(producto);
        
    if (($('#agregarform-color_id').val()) && ($('#agregarform-talla_id').val())){
        $.ajax({
            url: $('#base_path').val()+'/producto/check-sold',
            type: 'post',
            data: {color:color, talla:talla, producto:producto},
            success: function(respuesta){
                respuesta = JSON.parse(respuesta);
                if(respuesta.agotado == '1'){
                    $('#boton-agregar-item').prop('disabled', true);
                    $('.sold-mail').show();
                } else {
                    $('#boton-agregar-item').prop('disabled', false);
                    $('.sold-mail').hide();
                }
            },
            error: function(){
                alert('Error. Algo ha salido mal.');
            }
        })
    }
})

$(document).on("change",'#agregarform-talla_id', function(){
    var color = $('#agregarform-color_id').val();
    var talla = $('#agregarform-talla_id').val();
    var producto = $('#agregarform-producto_id').val();

    $('#soldemail-talla_id').val(talla);
    $('#soldemail-color_id').val(color);
    $('#soldemail-producto_id').val(producto);
        
    if (($('#agregarform-color_id').val()) && ($('#agregarform-talla_id').val())){
        $.ajax({
            url: $('#base_path').val()+'/producto/check-sold',
            type: 'post',
            data: {color:color, talla:talla, producto:producto},
            success: function(respuesta){
                respuesta = JSON.parse(respuesta);
                if(respuesta.agotado == '1'){
                    $('#boton-agregar-item').prop('disabled', true);
                    $('.sold-mail').show();
                } else {
                    $('#boton-agregar-item').prop('disabled', false);
                    $('.sold-mail').hide();
                }
            },
            error: function(){
                alert('Error. Algo ha salido mal.');
            }
        })
    }
})

$(document).on("click",'.let-me-know', function(){
    var emailReg = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;  
    if(!emailReg.test($('#soldemail-email').val())) {  
        $('.error-sold').show();
    } else {
        $('.error-sold').hide();
        $('.let-me-know').prop('disabled', true);
        var data = $('#sold-email').serialize();
        $.ajax({
            url: $('#base_path').val()+'/colection/save-sold-email',
            type: 'POST',
            data: data,
            success: function () {
                $('.success-sold').show();
            },
            error: function(jqXHR, errMsg) {
                alert(errMsg);
            }
         });
       
   }
})

//    alert('entre');
//    var data = $('#sold-email').serialize();
//    $.ajax({
//        url: 'save-sold-email',
//        type: 'POST',
//        data: data,
//        success: function (data) {
//            alert('pase')
//        },
//        error: function(jqXHR, errMsg) {
//            alert(errMsg);
//        }
//     });
//     return false; // prevent default submit
//    
////    alert('pase');
////    event.stopImmediatePropagation();
////    event.preventDefault();
////    console.log(errors);
//})
    
    
    
$(document).on("click",'#cerrar-color', function(){
    $('.mfp-close').click();
})

function popupPrimeraVez(){
    if($('#home').length && $('#home').hasClass('first-time'))
    {
        $('#newsletter').click();
    }
}

function formatoNumero(numero){
    numero += '';
    x = numero.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function actualizaTotal(){
    var total = 0;
    $('.costo span').each(function(){
        total = total + parseFloat($(this).text().replace (/,/g, ""));
    });
    var total_formato = formatoNumero(total.toFixed(2));
    $('#subtotal-compra span').text(total_formato);
    $('#total-compra span').text(total_formato);
}

function resize(){
    if($('.full-screen').length){
        if(window.innerWidth <= 850){
            var altura = $('.full-screen').height();
            var altura_propuesta = $('.full-screen').height()-($('#main-header').innerHeight()+$('.footer').innerHeight());
            if(altura < altura_propuesta){
                $('.wrap > .container').height(window.innerHeight-($('#main-header').innerHeight()+$('.footer').innerHeight()));
            }else{
                $('.wrap > .container').height(
                    $('.full-screen').height()-($('#main-header').innerHeight()+$('.footer').innerHeight())
                );
            }
        }else{
            $('.wrap > .container').removeAttr('style');
        }
    }

    if($('.grid-productos').length && window.innerWidth > 1100){
        $('.pr1, .pr2, .pr5, .pr6').height($('.pr1').width()*1.2);
        $('.pr3, .pr4, .pr7, .pr8').height($('.pr3').width()*1.2);
    }

    if($('.grid-productos').length && window.innerWidth <= 1100)
    {
        $('.pr1, .pr2, .pr5, .pr6, .pr7, .pr8').height($('.pr1').width()*1.2);
        $('.pr3, .pr4').height($('.pr3').width()*1.2);
    }
    if($('.grid-productos2').length && window.innerWidth > 1100){
        $('.pro1, .pro4').height($('.pro1').width()*1.2);
        $('.pro2, .pro3').height($('.pro2').width()*0.6);
    }

    if($('.grid-productos2').length && window.innerWidth <= 1100)
    {
        $('.pro1, .pro4').height($('.pro1').width()*1.2);
        $('.pro2, .pro3').height($('.pro2').width()*0.6);
    }

    if(window.innerWidth <= 1100 && $('.contributors').length){
        $('.wrap > .container').height(
            $('#datos-contributors').innerHeight()+$('#main-header').innerHeight()+$('.footer').innerHeight()+100
        );
    }

    if(window.innerWidth > 850 && $('#taller').length){
        $('.wrap > .container').height( $('#texto-taller').innerHeight()- $('#main-header').innerHeight());
        // $('.full-screen').height($('.wrap > .container').height()+100);
    }else if(window.innerWidth <= 850 && $('#taller').length){
        $('.wrap > .container').height($('.full-screen').height())
    }

    if(window.innerWidth <= 850 && $('#taller-blanco').length){
        $('.wrap > .container').height('auto')
    }

    if(window.innerWidth <= 850 && $('.stockists').length){
        $('.wrap > .container').height($('#contenido-stockists').innerHeight() + 100 );
    }

    if(window.innerWidth <= 850 && $('.information').length){
        $('.wrap > .container').height($('#texto-information').innerHeight() - 60 );
    }
}

jQuery(document).ready(function($){
    
    $('#ver-descripcion-bed').click(function(){
        $('#descripcion-producto-bed').show();
        $('#guia-tallas-bed').hide()
        $('#ver-descripcion-bed').addClass('selected')
        $('#ver-guia-bed').removeClass('selected')
    })
    $('#ver-guia-bed').click(function(){
        $('#descripcion-producto-bed').hide();
        $('#guia-tallas-bed').show()
        $('#ver-guia-bed').addClass('selected')
        $('#ver-descripcion-bed').removeClass('selected')
    })
    
    $('#slider-fotos-bed').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
//        prevArrow: "<div class='contenedor-carr'><img src='" + $('#baseUrl').val() + "/images/next.png' /><img class='top' src='" + $('#baseUrl').val() + "/images/next_over.png' /></div><div class='contenedor-carr'></div>",
//        nextArrow: "<div class='contenedor2-carr'><img src='" + $('#baseUrl').val() + "/images/ControlDer.png' /><img class='top2' src='" + $('#baseUrl').val() + "/images/ControlDerA.png' /></div><div class='contenedor2-carr'></div>",
        fade: true,
        asNavFor: '#thumb-fotos-bed'
    });
    $('#thumb-fotos-bed').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        asNavFor: '#slider-fotos-bed',
        arrows: false,
        dots: false,
        centerMode: true,
        focusOnSelect: true
    });
    
    resize();
    $(window).resize(function(){
        resize();
    });

    $('#menu-inferior').on('click', function(){
        $(this).toggleClass('desplegado');
        $('body').toggleClass('scroll-hide');
        $('#menu-footer').toggleClass('visible');
    });

    $('#menu-superior').on('click', function(){
        $(this).toggleClass('desplegado');
        $('body').toggleClass('scroll-hide');
        $('#menu').toggleClass('visible');
    });

    $('.scroll-to').bind('click', function(e) {
        try {
            e.preventDefault();
            var target = $(this).attr('href');
            if(target.charAt(0) == "/"){
                target = target.substring(1);

            }
            $('body,html').animate({
                scrollTop: $(target).offset().top - ($('#encabezado-principal').height()+40)
            }, 800);
        } catch (error) {
            window.location.href = $(this).attr('href');
        }
    });

/////////////////////////////////////////////////////// Popups fuctions

    $('.popup-with-zoom-anim').magnificPopup({
        type: 'inline',
        fixedContentPos: true,
        fixedBgPos: true,
        overflowY: 'auto',
        closeBtnInside: true,
        preloader: false,
        midClick: true,
        removalDelay: 300,
        mainClass: 'my-mfp-zoom-in2',
        callbacks: {
          open: function() {
              $('#spinner-newsletter').height($('#formulario-newsletter').height());
              $('#confirmacion-newsletter').height($('#formulario-newsletter').height());
              $('#enviar-newsletter').on('click', function(){
                  
                $('#formulario-newsletter').submit(function(event){
                    event.preventDefault();
                })
                var data = $('#formulario-newsletter').serializeArray();
                var url = $('#base_path').val() + '/newsletter/agregar';
                $.ajax({
                    url: url,
                    type: 'post',
                    dataType: 'json',
                    data: data,
                    success: function(resp){
                        var mensaje = resp.mensaje;
                        var exito = resp.exito;
                        if (exito == 0){
                            alert(mensaje);
                        } else if ( exito == 1){
                            $('.cerrar-modal').trigger('click');
                            $('.btn-modal-2-'+clave).trigger('click');
                        }
                    },
                    error: function(){
                        alert('Error algo ha salido mal.');
                    },
                })
                  
                  $('#formulario-newsletter').addClass('oculto');
                  $('#spinner-newsletter').addClass('visible');
                  setTimeout(function(){
                    $('#spinner-newsletter').removeClass('visible');
                    $('#confirmacion-newsletter').addClass('visible');
                }, 2000);
              });
          },
        }
    });
    
    $('.popup-with-zoom-image').magnificPopup({
        type: 'image',
        fixedContentPos: true,
        fixedBgPos: true,
        overflowY: 'auto',
        closeBtnInside: true,
        preloader: false,
        midClick: true,
        removalDelay: 300,
        mainClass: 'my-mfp-zoom-in',
        callbacks: {
          open: function() {
              $('#spinner-newsletter').height($('#formulario-newsletter').height());
              $('#confirmacion-newsletter').height($('#formulario-newsletter').height());
              $('#enviar-newsletter').on('click', function(){
                  $('#formulario-newsletter').addClass('oculto');
                  $('#spinner-newsletter').addClass('visible');
                  setTimeout(function(){
                    $('#spinner-newsletter').removeClass('visible');
                    $('#confirmacion-newsletter').addClass('visible');
                }, 2000);
              });
          },
        }
    });
    $('.popup-with-zoom-image').trigger('click');
    
    
    $('.popup-with-zoom-image2').magnificPopup({
        type: 'image',
        fixedContentPos: true,
        fixedBgPos: true,
        overflowY: 'auto',
        closeBtnInside: true,
        preloader: false,
        midClick: true,
        removalDelay: 300,
        mainClass: 'my-mfp-zoom-in2',
        callbacks: {
          open: function() {
              $('#spinner-newsletter').height($('#formulario-newsletter').height());
              $('#confirmacion-newsletter').height($('#formulario-newsletter').height());
              $('#enviar-newsletter').on('click', function(){
                  $('#formulario-newsletter').addClass('oculto');
                  $('#spinner-newsletter').addClass('visible');
                  setTimeout(function(){
                    $('#spinner-newsletter').removeClass('visible');
                    $('#confirmacion-newsletter').addClass('visible');
                }, 2000);
              });
          },
        }
    });
    $('.popup-press').magnificPopup({
        type: 'image',
        closeBtnInside: false,
        fixedContentPos: false,
        closeOnBgClick: true,
        overflowY: 'hidden',
        overflowX: 'hidden',
        mainClass: 'my-mfp-zoom-in2',
        callbacks: {
          open: function() {
              $('#spinner-newsletter').height($('#formulario-newsletter').height());
              $('#confirmacion-newsletter').height($('#formulario-newsletter').height());
              $('#enviar-newsletter').on('click', function(){
                  $('#formulario-newsletter').addClass('oculto');
                  $('#spinner-newsletter').addClass('visible');
                  setTimeout(function(){
                    $('#spinner-newsletter').removeClass('visible');
                    $('#confirmacion-newsletter').addClass('visible');
                }, 2000);
              });
                $('.mfp-figure').on('click', function(event){
                    event.preventDefault();
                    zoom.to({
                        x: event.pageX,
                        y: event.pageY,
                        scale: 3
                    })
                })
              
          },
            close: function () {
                zoom.out();
            },
            elementParse: function (item) {
                if (item.el[0].className == 'popup-press') {
                    item.type = 'iframe';
                } else {
                    item.type = 'image';
                }
            }
        }
    });
    
//    $('#fotos-producto img, #fotos-producto .youtube-link').magnificPopup({
//        type: 'image',
//        closeBtnInside: true,
//        fixedContentPos: true,
//        mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
//        gallery: {
//            enabled: true,
//            navigateByImgClick: false,
//        },
//        callbacks: {
//            open: function(){
//                $('.mfp-figure').on('click', function(event){
//                    event.preventDefault();
//                    zoom.to({
//                        x: event.pageX,
//                        y: event.pageY,
//                        scale: 3
//                    })
//                })
//
//                $('.mfp-content').swipe({
//                    swipeLeft: function (event, direction, distance, duration, fingerCount) {
//                        $('#fotos-producto img, #fotos-producto .youtube-link').magnificPopup('next');
//                    },
//                    swipeRight: function (event, direction, distance, duration, fingerCount) {
//                        $('#fotos-producto img, #fotos-producto .youtube-link').magnificPopup('prev');
//                    }
//                });
//            },
//            close: function () {
//                zoom.out();
//            },
//            elementParse: function (item) {
//                if (item.el[0].className == 'youtube-link hidden') {
//                    item.type = 'iframe';
//                } else {
//                    item.type = 'image';
//                }
//            }
//        }
//    });
    
    $('.popup-with-zoom-anim-ajax').magnificPopup({
          type: 'ajax',
          // fixedContentPos: false,
          fixedBgPos: true,
          overflowY: 'auto',
          // preloader: false,
          midClick: true,
          removalDelay: 300,
          fixedContentPos: true,
          closeOnContentClick: false,
          closeOnBgClick: false,
          showCloseBtn: true,
          enableEscapeKey: true,
          mainClass: 'my-mfp-zoom-in',
          ajax: {
              settings: null,
              cursor: 'mfp-ajax-cur',
              tError:  'Content not found',
          },
          callbacks:{
              ajaxContentAdded: function(){
                  $(".carousel").swipe({
                      swipe: function(event, direction, distance, duration, fingerCount, fingerData) {
                          if (direction == 'left') $(this).carousel('next');
                          if (direction == 'right') $(this).carousel('prev');
                      },
                      allowPageScroll:"vertical"
                  });
                  $('#ver-descripcion').click(function(){
                      $('#descripcion-producto').show();
                      $('#guia-tallas').hide()
                      $('#ver-descripcion').addClass('selected')
                      $('#ver-guia').removeClass('selected')
                  })
                  $('#ver-guia').click(function(){
                      $('#descripcion-producto').hide();
                      $('#guia-tallas').show()
                      $('#ver-guia').addClass('selected')
                      $('#ver-descripcion').removeClass('selected')
                  })
              }
          }
    });

    if($('#information').length){
        $('.opcion-information').on('click', function(){
            if($(this).hasClass('desplegado')){
                $('.bloque-information').slideUp();
                $(this).removeClass('desplegado');
            }else{
                var bloque = $(this).data('bloque');
                $('.bloque-information').slideUp();
                $('.opcion-information').removeClass('desplegado');
                $(this).toggleClass('desplegado');
                $('#information-'+bloque).slideToggle(function(){
                    resize();
                });
            }
        });
    }

    if($('#press').length){
        $('.read-more').on('click', function(){
            var bloque = $(this).data('more');
            $(this).slideToggle();
            $('#more-'+bloque).slideToggle();
        });
    }

    if($('#view-more').length){
        $('#view-more a').on('click', function(){
            $('#mas-productos').slideToggle(function(){
                if($('#mas-productos').is(':visible'))
                    resize();
            });
        });
        $('#mas-productos').hide();
    }

    $('.mas, .menos').on('click', function(){
        var id = $(this).attr('id').split('-')[1];
        var cantidad = parseInt($('#cantidad-'+id).text());
        if($(this).hasClass('mas')){
            cantidad++;
        }else{
            if(cantidad > 1){
                cantidad--;
            }
        }
        $('#cantidad-'+id).text(cantidad);
        var precio = parseInt($('#precio-'+id).val());
        $('#costo-'+id+' span').text(formatoNumero((precio*cantidad).toFixed(2)));
        actualizaTotal();
    });

    $('.eliminar a').on('click', function(){
        var id = $(this).attr('id').split('-')[1];
        $('#producto-'+id).fadeOut(function(){
            var cantidad = parseInt($('#cantidad-bolsa').text());
            $('#cantidad-bolsa').text(cantidad-1);
            $('#producto-'+id).remove();
            actualizaTotal();
        });
    });

    $('#terms-bloque-bag summary').on('click', function(){
        if($('#carrito-bloque-bag.open')){
            $('#more-bag').toggleClass('oculto');
        }
    });

    $('#continuar-pago-bag').on('click', function(){
        var data = [];
        if($('.campos-producto').length < 1)
        {
            $('.error-carrito.bag').removeClass('oculto');
            $('.error-carrito.bag').html("No items in bag")
            return;
        }
        $('.campos-producto').each(function(index, value){
            var item = {};
            var id = $('.id-carrito',value).val();
            item["id"] = $('.id',value).val();
            item["precio"] = $('.precio',value).val();
            item["cantidad"] = $('#cantidad-' + id).text();
            item["talla"] = $('.talla',value).val();
            item["color"] = $('.color',value).val();

            data.push(item);
        });
        $.ajax({
            url: $('#base_path').val()+'/producto/actualizar-carrito',
            type: 'post',
            data: JSON.stringify(data),
            contentType: 'application/json',
            dataType:"json",
            beforeSend: function(){
                $('.totales-carrito .spinner').show();
            },
            success: function(respuesta){
                if(respuesta.exito)
                {
                    $('.totales-carrito .spinner').hide();
                    $('.address').removeClass('oculto');
                    $('.bloque-carrito').addClass('oculto');
                    $('#opcion-bag').removeClass('seleccionado');
                    $('#opcion-address').addClass('seleccionado');
                }
                else{
                    alert(respuesta.mensaje);
                }
            },
            error: function (xhr, status, error) {
                alert('Error actualizando el carrito');
            },
            completed: function(){
                $('.totales-carrito .spinner').hide();
            }
        });
        return false;
    });

    $('#continuar-pago-address').on('click', function(){
        if(validaFormulariosCliente())
        {
            var correo = $('#form-envio').find('#email_envio').val();
            $.ajax({
                url: $('#base_path').val()+'/cart/verificar-descuento',
                type: 'post',
                data: {correo:correo},
                success: function(resp){
                    if (resp.exito == 1){
                        $('.div-descuento').css('display', 'table');
                        var tipo_envio = $('input[name="envio"]:checked').val();
                        var subtotal = parseFloat($('input[name="subtotal"]').val());
                        var precio_envio = parseFloat($('input[name="' + tipo_envio + '_price"]').val());
                        var total = subtotal + precio_envio;
                        $('.discount-span').text(subtotal*0.1);
                        $('.total-compra-sp').text(precio_envio+(subtotal - (subtotal*0.1)));
                        $('#check-descuento').val(1);
                    } else {
                        $('#check-descuento').val(0);
                        $('.div-descuento').hide();
                        cambiaPrecios();
                    }
                },
            });
            
            $('.payment').removeClass('oculto');
            $('.address').addClass('oculto');
            $('#opcion-address').removeClass('seleccionado');
            $('#opcion-payment').addClass('seleccionado');
        }
    });

    $('#regresar-bag').on('click', function(){
        $('.address').addClass('oculto');
        $('.bloque-carrito').removeClass('oculto');
        $('#opcion-bag').addClass('seleccionado');
        $('#opcion-address').removeClass('seleccionado');
    });

    $("#continuar-pago-payment").on('click',function(event){
        $("#continuar-pago-payment").prop('disabled',true);
        var numero = $('#card-form').find("#numero").val();
        var codigo = $('#card-form').find("#codigo").val();
        var mes = $('#card-form').find("#exp-month").val();
        var anio = $('#card-form').find("#exp-year").val();
        if(!Conekta.card.validateNumber(numero)){
            $('.error-carrito.payment').removeClass('oculto');
            $('.error-carrito.payment').html("Invalid credit card number")
            $("#continuar-pago-payment").prop('disabled',false);
            return;
        }
        if(!Conekta.card.validateCVC(codigo)){
            $('.error-carrito.payment').removeClass('oculto');
            $('.error-carrito.payment').html("Invalid CVC")
            $("#continuar-pago-payment").prop('disabled',false);
            return;
        }
        if(!Conekta.card.validateExpirationDate(mes,anio)){
            $('.error-carrito.payment').removeClass('oculto');
            $('.error-carrito.payment').html("Invalid Expiration Date")
            $("#continuar-pago-payment").prop('disabled',false);
            return;
        }
        Conekta.Token.create($('#card-form'), function(token) {
        // Closure de respuesta exitosa
        var $form = $('#form-envio')
        var data = [];
        var envio = {};
        envio["nombre_envio"] = $form.find('#nombre_envio').val();
        envio["apellidos_envio"] = $form.find('#apellido_envio').val();
        envio["correo_envio"] = $form.find('#email_envio').val();
        envio["telefono_envio"] = $form.find('#telefono_envio').val();
        envio["calle_envio"] = $form.find('#calle_envio').val();
        envio["numero_exterior_envio"] = $form.find('#ext_envio').val();
        envio["numero_interior_envio"] = $form.find('#int_envio').val();
        envio["colonia_envio"] = $form.find('#colonia_envio').val();
        envio["municipio_envio"] = $form.find('#municipio_envio').val();
        envio["estado_envio"] = $form.find('#estado_envio').val();
        envio["cp_envio"] = $form.find('#cp_envio').val();
        envio["tipo_envio"] = $('input[name="envio"]:checked').val();
        data.push(envio);
        if( !$( '#same-info' ).is( ":checked" ) ){
            var fact = {};
            fact["nombre_fact"] = $form.find('#nombre_fact').val();
            fact["apellidos_fact"] = $form.find('#apellido_fact').val();
            fact["calle_envio"] = $form.find('#calle_fact').val();
            fact["numero_exterior_fact"] = $form.find('#ext_fact').val();
            fact["numero_interior_fact"] = $form.find('#int_fact').val();
            fact["colonia_fact"] = $form.find('#colonia_fact').val();
            fact["municipio_fact"] = $form.find('#municipio_fact').val();
            fact["estado_fact"] = $form.find('#estado_fact').val();
            fact["cp_fact"] = $form.find('#cp_fact').val();
            data.push(fact)
        }
        else{
            var fact = {};
            fact["nombre_fact"] = $form.find('#nombre_envio').val();
            fact["apellidos_fact"] = $form.find('#apellido_envio').val();
            fact["calle_envio"] = $form.find('#calle_envio').val();
            fact["numero_exterior_fact"] = $form.find('#ext_envio').val();
            fact["numero_interior_fact"] = $form.find('#int_envio').val();
            fact["colonia_fact"] = $form.find('#colonia_envio').val();
            fact["municipio_fact"] = $form.find('#municipio_envio').val();
            fact["estado_fact"] = $form.find('#estado_envio').val();
            fact["cp_fact"] = $form.find('#cp_envio').val();
            data.push(fact)
        }
        data.push(token);
        $.ajax({
            url: $('#base_path').val()+'/cart/finalizar-compra',
            type: 'post',
            data: JSON.stringify(data),
            contentType: 'application/json',
            dataType: "json",
            beforeSend: function(){
                $('.totales-carrito .spinner').show();
                $('.error-carrito.payment').hide();
            },
            success: function(respuesta){
                if(respuesta.exito)
                {
                    var pedido_id = respuesta.pedido;
                    $('.totales-carrito .spinner').hide();
                    $('.confirmation').removeClass('oculto');
                    $('.payment').addClass('oculto');
                    $('#opcion-payment').removeClass('seleccionado');
                    $('#opcion-confirmation').addClass('seleccionado');
                    //////////CORREO//////////
                    var correo=$('#email_envio').val();
                    var calle=$('#calle_envio').val();
                    var numero=$('#ext_envio').val();
                    var colonia=$('#colonia_envio').val();
                    var mun=$('#municipio_envio').val();
                    var cp=$('#cp_envio').val();
                    var edo=$('#estado_envio').val();
                    var tel=$('#telefono_envio').val();
                    var nom=$('#nombre_envio').val()+" "+$('#apellido_envio').val();

                    var products=[];
                    if($('#check-descuento').val() == 1){
                        $('.campos-producto').each(function(index, value){
                            var item = {};
                            var id = $('.id-carrito',value).val();
                            item[0] = $('.id',value).val();
                            item[1] = $('.color',value).val();
                            item[2] = $('.talla',value).val();
                            item[3] = $('.precio',value).val();
                            item[4] = $('.precio',value).val();
                            item[5] = $('#cantidad-' + id).text();
                            item[6] = item[3]*0.1;
                            products.push(item);
                        });
                    } else {
                        $('.campos-producto').each(function(index, value){
                            var item = {};
                            var id = $('.id-carrito',value).val();
                            item[0] = $('.id',value).val();
                            item[1] = $('.color',value).val();
                            item[2] = $('.talla',value).val();
                            item[3] = $('.precio',value).val();
                            item[4] = $('.precio',value).val();
                            item[5] = $('#cantidad-' + id).text();
                            products.push(item);
                        });
                    }
                    //    alert(products);
                    $.ajax({
                        url: $('#base_path').val()+'/cart/enviar-correo',
//                        url: $('#base_path').val()+'/cart/prueba',
                        type: 'post',
                        data: { correo:correo,calle:calle,numero:numero,colonia:colonia,cp:cp,edo:edo,tel:tel,nom:nom,mun:mun,
                            products:products, pedido_id:pedido_id},
                        dataType: "html",
                        success: function(){
                            $('.totales-carrito .spinner').hide();
                            $('.confirmation').removeClass('oculto');
                            $('.payment').addClass('oculto');
                            $('#opcion-payment').removeClass('seleccionado');
                            $('#opcion-confirmation').addClass('seleccionado');
                        },
                    });
                    /////////////
                }
                else{
                    $('.totales-carrito .spinner').hide();
                    $('.error-carrito.payment').show();
                    $('.error-carrito.payment').text('There was an error processing the payment. Please try again.');
                    $("#continuar-pago-payment").prop('disabled',false);
                }

            }
        });

    }, conektaErrorResponseHandler);
    event.stopImmediatePropagation();
    return false;
    });

    $('#opcion-bag').on('click', function(){
        regresarABag()
    });

    $('#opcion-address').on('click', function(){
        regresarAAddress()
    });

    $('#terms-bloque-address summary').on('click', function(){
        if($('#carrito-bloque-address.open')){
            $('#more-address').toggleClass('oculto');
        }
    });

    $('#same-info').change(function(){
        var checked = this.checked;
        if(checked){
            $('#dir-fac-carrito').addClass('oculto');
        }
        else{
            $('#dir-fac-carrito').removeClass('oculto');
        }
    });

    if($('#home').length && $('#home').hasClass('first-time'))
    {
        $('#newsletter').click();
    }

    if($('body.cart').length > 0){
        cambiaPrecios();

        Conekta.setPublicKey($('#publicKey').val());

        $('input[name="envio"]').on('change', cambiaPrecios)
    }

//    if($('#hemp-cotton').length){
//        $('#hemp-cotton').click();
//    }
});

function cambiaPrecios(){
    if ($('input[name="envio"]:checked').length > 0){
        var tipo_envio = $('input[name="envio"]:checked').val();
        var subtotal = parseFloat($('input[name="subtotal"]').val());
        var precio_envio = 0;
        var total = 0;
        precio_envio = parseFloat($('input[name="' + tipo_envio + '_price"]').val());
        total = subtotal + precio_envio;
        $('.shipping-price-sp').text(precio_envio);
        $('.total-compra-sp').text(total);
    }
}

var conektaErrorResponseHandler = function(response) {
    var $form = $("#card-form");
    $form.find(".card-errors").text(response.message_to_purchaser);
    $('#continuar-pago-payment').removeAttr('disabled','disabled');
};

$(document).keyup(function(e) {
     if (e.keyCode == 27) {
        if($('.desplegar-menu').hasClass('desplegado')){
            $('.desplegar-menu').click();
        }
    }
});

window.addEventListener("orientationchange", function() {
	resize();
}, false);

function regresarABag(){

    if($('#opcion-confirmation').hasClass('seleccionado'))
    {
        return
    }

    var address = $('.address');
    var payment = $('.payment');
    var confirmation = $('.confirmation');
    if(!address.hasClass('oculto')){
        address.addClass('oculto');
    }
    if(!payment.hasClass('oculto')){
        payment.addClass('oculto');
    }
    if(!confirmation.hasClass('oculto')){
        confirmation.addClass('oculto');
    }
    $('.bloque-carrito').removeClass('oculto');
    $('#opcion-bag').addClass('seleccionado');
    $('#opcion-address').removeClass('seleccionado');
    $('#opcion-payment').removeClass('seleccionado');
}

function regresarAAddress(){
    if($('#opcion-bag').hasClass('seleccionado'))
    {
        return
    }
    if($('#opcion-confirmation').hasClass('seleccionado'))
    {
        return
    }
    var payment = $('.payment');
    var confirmation = $('.confirmation');
    if(!payment.hasClass('oculto')){
        payment.addClass('oculto');
    }
    if(!confirmation.hasClass('oculto')){
        confirmation.addClass('oculto');
    }
    $('.address').removeClass('oculto');
    $('#opcion-address').addClass('seleccionado');
    $('#opcion-payment').removeClass('seleccionado');
}

function validaFormulariosCliente(){
    if(!$('#nombre_envio').val() || !$('#apellido_envio').val() || !$('#calle_envio').val() ||
     !$('#ext_envio').val() || !$('#colonia_envio').val() || !$('#municipio_envio').val() ||
     !$('#estado_envio').val() || !$('#email_envio').val() || !$('#cp_envio').val())
    {
        $('.error-carrito.address').removeClass('oculto');
        $('.error-carrito.address').html("All * fields are required")
        return false;
    }

    if( $( '#same-info' ).is( ":checked" ) ){
        return true;
    }else{
        if(!$('#nombre_fact').val() || !$('#apellido_fact').val() || !$('#calle_fact').val() ||
         !$('#ext_fact').val() || !$('#colonia_fact').val() || !$('#municipio_fact').val() ||
         !$('#estado_fact').val() || !$('#cp_fact').val())
         {
             $('.error-carrito.address').removeClass('oculto');
             $('.error-carrito.address').html("All * fields are required")
             return false;
         }
         else{
             return true;
         }
    }
}


/*!
 * zoom.js 0.3
 * http://lab.hakim.se/zoom-js
 * MIT licensed
 *
 * Copyright (C) 2011-2014 Hakim El Hattab, http://hakim.se
 */
var zoom = (function(){

	var TRANSITION_DURATION = 800;

	// The current zoom level (scale)
	var level = 1;

	// The current mouse position, used for panning
	var mouseX = 0,
		mouseY = 0;

	// Timeout before pan is activated
	var panEngageTimeout = -1,
		panUpdateInterval = -1;

	// Timeout for callback function
	var callbackTimeout = -1;

	// Check for transform support so that we can fallback otherwise
	var supportsTransforms = 	'WebkitTransform' in document.body.style ||
								'MozTransform' in document.body.style ||
								'msTransform' in document.body.style ||
								'OTransform' in document.body.style ||
								'transform' in document.body.style;

	if( supportsTransforms ) {
		// The easing that will be applied when we zoom in/out
		document.body.style.transition = 'transform '+ TRANSITION_DURATION +'ms ease';
		document.body.style.OTransition = '-o-transform '+ TRANSITION_DURATION +'ms ease';
		document.body.style.msTransition = '-ms-transform '+ TRANSITION_DURATION +'ms ease';
		document.body.style.MozTransition = '-moz-transform '+ TRANSITION_DURATION +'ms ease';
		document.body.style.WebkitTransition = '-webkit-transform '+ TRANSITION_DURATION +'ms ease';
	}

	// Zoom out if the user hits escape
	document.addEventListener( 'keyup', function( event ) {
		if( level !== 1 && event.keyCode === 27 ) {
			zoom.out();
		}
	} );

	// Monitor mouse movement for panning
	document.addEventListener( 'mousemove', function( event ) {
		if( level !== 1 ) {
			mouseX = event.clientX;
			mouseY = event.clientY;
		}
	} );

	/**
	 * Applies the CSS required to zoom in, prefers the use of CSS3
	 * transforms but falls back on zoom for IE.
	 *
	 * @param {Object} rect
	 * @param {Number} scale
	 */
	function magnify( rect, scale ) {

		var scrollOffset = getScrollOffset();

		// Ensure a width/height is set
		rect.width = rect.width || 1;
		rect.height = rect.height || 1;

		// Center the rect within the zoomed viewport
		rect.x -= ( window.innerWidth - ( rect.width * scale ) ) / 2;
		rect.y -= ( window.innerHeight - ( rect.height * scale ) ) / 2;

		if( supportsTransforms ) {
			// Reset
			if( scale === 1 ) {
				document.body.style.transform = '';
				document.body.style.OTransform = '';
				document.body.style.msTransform = '';
				document.body.style.MozTransform = '';
				document.body.style.WebkitTransform = '';
			}
			// Scale
			else {
				var origin = scrollOffset.x +'px '+'0px',
					transform = 'translate('+ -rect.x +'px,'+ -rect.y +'px) scale('+ scale +')';

				document.body.style.transformOrigin = origin;
				document.body.style.OTransformOrigin = origin;
				document.body.style.msTransformOrigin = origin;
				document.body.style.MozTransformOrigin = origin;
				document.body.style.WebkitTransformOrigin = origin;

				document.body.style.transform = transform;
				document.body.style.OTransform = transform;
				document.body.style.msTransform = transform;
				document.body.style.MozTransform = transform;
				document.body.style.WebkitTransform = transform;
			}
		}
		else {
			// Reset
			if( scale === 1 ) {
				document.body.style.position = '';
				document.body.style.left = '';
				document.body.style.top = '';
				document.body.style.width = '';
				document.body.style.height = '';
				document.body.style.zoom = '';
			}
			// Scale
			else {
				document.body.style.position = 'relative';
				document.body.style.left = ( - ( scrollOffset.x + rect.x ) / scale ) + 'px';
				document.body.style.top = ( - ( scrollOffset.y + rect.y ) / scale ) + 'px';
				document.body.style.width = ( scale * 100 ) + '%';
				document.body.style.height = ( scale * 100 ) + '%';
				document.body.style.zoom = scale;
			}
		}

		level = scale;
	}

	/**
	 * Pan the document when the mouse cursor approaches the edges
	 * of the window.
	 */
	function pan() {
		var range = 0.12,
			rangeX = window.innerWidth * range,
			rangeY = window.innerHeight * range,
			scrollOffset = getScrollOffset();

		// Up
		if( mouseY < rangeY ) {
			window.scroll( scrollOffset.x, scrollOffset.y - ( 1 - ( mouseY / rangeY ) ) * ( 14 / level ) );
		}
		// Down
		else if( mouseY > window.innerHeight - rangeY ) {
			window.scroll( scrollOffset.x, scrollOffset.y + ( 1 - ( window.innerHeight - mouseY ) / rangeY ) * ( 14 / level ) );
		}

		// Left
		if( mouseX < rangeX ) {
			window.scroll( scrollOffset.x - ( 1 - ( mouseX / rangeX ) ) * ( 14 / level ), scrollOffset.y );
		}
		// Right
		else if( mouseX > window.innerWidth - rangeX ) {
			window.scroll( scrollOffset.x + ( 1 - ( window.innerWidth - mouseX ) / rangeX ) * ( 14 / level ), scrollOffset.y );
		}
	}

	function getScrollOffset() {
		return {
			x: window.scrollX !== undefined ? window.scrollX : window.pageXOffset,
			y: window.scrollY !== undefined ? window.scrollY : window.pageYOffset
		}
	}

	return {
		/**
		 * Zooms in on either a rectangle or HTML element.
		 *
		 * @param {Object} options
		 *
		 *   (required)
		 *   - element: HTML element to zoom in on
		 *   OR
		 *   - x/y: coordinates in non-transformed space to zoom in on
		 *   - width/height: the portion of the screen to zoom in on
		 *   - scale: can be used instead of width/height to explicitly set scale
		 *
		 *   (optional)
		 *   - callback: call back when zooming in ends
		 *   - padding: spacing around the zoomed in element
		 */
		to: function( options ) {

			// Due to an implementation limitation we can't zoom in
			// to another element without zooming out first
			if( level !== 1 ) {
				zoom.out();
			}
			else {
				options.x = options.x || 0;
				options.y = options.y || 0;

				// If an element is set, that takes precedence
				if( !!options.element ) {
					// Space around the zoomed in element to leave on screen
					var padding = typeof options.padding === 'number' ? options.padding : 20;
					var bounds = options.element.getBoundingClientRect();

					options.x = bounds.left - padding;
					options.y = bounds.top - padding;
					options.width = bounds.width + ( padding * 2 );
					options.height = bounds.height + ( padding * 2 );
				}

				// If width/height values are set, calculate scale from those values
				if( options.width !== undefined && options.height !== undefined ) {
					options.scale = Math.max( Math.min( window.innerWidth / options.width, window.innerHeight / options.height ), 1 );
				}

				if( options.scale > 1 ) {
					options.x *= options.scale;
					options.y *= options.scale;

					options.x = Math.max( options.x, 0 );
					options.y = Math.max( options.y, 0 );

					magnify( options, options.scale );

					if( options.pan !== false ) {

						// Wait with engaging panning as it may conflict with the
						// zoom transition
						panEngageTimeout = setTimeout( function() {
							panUpdateInterval = setInterval( pan, 1000 / 60 );
						}, TRANSITION_DURATION );

					}

					if( typeof options.callback === 'function' ) {
						callbackTimeout = setTimeout( options.callback, TRANSITION_DURATION );
					}
				}
			}
		},

		/**
		 * Resets the document zoom state to its default.
		 *
		 * @param {Object} options
		 *   - callback: call back when zooming out ends
		 */
		out: function( options ) {
			clearTimeout( panEngageTimeout );
			clearInterval( panUpdateInterval );
			clearTimeout( callbackTimeout );

			magnify( { x: 0, y: 0 }, 1 );

			if( options && typeof options.callback === 'function' ) {
				setTimeout( options.callback, TRANSITION_DURATION );
			}

			level = 1;
		},

		// Alias
		magnify: function( options ) { this.to( options ) },
		reset: function() { this.out() },

		zoomLevel: function() {
			return level;
		}
	}

})();