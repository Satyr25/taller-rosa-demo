jQuery(document).ready(function($){
    $('.navbar-toggle').on('click', function(){
        $(this).toggleClass('desplegado');
        $('.navbar-header').toggleClass('menu-visible')
    });

    $('#agregar-foto-producto').on('click', function(){
        $('#fotos > div').append('<input id="productoform-fotos" name="ProductoForm[fotos][]" accept=".jpg,.jpeg,.png" type="file">');
    });

    $('#agregar-foto-imagery').on('click', function(){
        $('#fotos > div').append('<input id="productoform-fotos" name="ImageryForm[fotos][]" accept=".jpg,.jpeg,.png" type="file">');
    });
    
    $('#agregar-foto-press').on('click', function(){
        $('#fotos > div').append('<input id="pressform-fotos" name="PressForm[fotos][]" accept=".jpg,.jpeg,.png" type="file" style="margin-bottom:10px;">');
    });
    $('#agregar-video-press').on('click', function(){
        $('#videos > div').append('<input id="pressform-videos" name="PressForm[videos][]" placeholder="Youtube URL video" type="text" class="form-control" style="margin-bottom:10px;">');
    });

    $('.quitar-foto.producto').on('click', function(){
        var id = $(this).attr('id');
        $(this).parent().remove();
        $('.edita-fotos').append(' <div class="form-group field-productoform-fotos_elim"><input id="productoform-fotos_elim" class="form-control"name="ProductoForm[fotos_elim][]" value="'+id+'" type="hidden"><p class="help-block help-block-error"></p></div>')
    });

    $('.quitar-foto.imagery').on('click', function(){
        var id = $(this).attr('id');
        $(this).parent().remove();
        $('.edita-fotos').append(' <div class="form-group field-imageryform-fotos_elim"><input id="imageryform-fotos_elim" class="form-control"name="ImageryForm[fotos_elim][]" value="'+id+'" type="hidden"><p class="help-block help-block-error"></p></div>')
    });
    
    $('.eliminar-foto-press').click(function(e){
        e.preventDefault();
        var id = $(this).data('id');
        $.ajax({
            url: 'deleteimg',
            type: 'post',
            dataType: 'json',
            data: {id:id},
            success: function(){
                $('#eliminar-foto-'+id+'').hide();
                alert('Se eliminó correctamente la imagen')
            },
            error: function(){
                alert('Error algo ha salido mal.');
            },
        })
    })
    $('.eliminar-video-press').click(function(e){
        e.preventDefault();
        var id = $(this).data('id');
        $.ajax({
            url: 'deletevideo',
            type: 'post',
            dataType: 'json',
            data: {id:id},
            success: function(){
                $('#eliminar-video-'+id+'').hide();
                alert('Se eliminó correctamente el video')
            },
            error: function(){
                alert('Error algo ha salido mal.');
            },
        })
    })
    
    $('.wysi').summernote({
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'italic', 'underline', 'clear']],
          ['fontname', ['fontname']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link']],
          ['view', ['fullscreen', 'codeview', 'help']],
        ],
    });
    
    $("input[name='ProductoForm[colores][]']").change(function(){
        
        var color = $(this).val();
        var check = $(this).prop('checked');
        var id = $('#talla_colores').data('producto');
        $.ajax({
            url: 'change-color',
            type: 'post',
            data: {color:color, check:check, id:id},
            success: function(html_sold){
                $("#talla_colores").replaceWith(html_sold);
            },
            error: function(){
                alert('Error, algo salio mal');
            },
        })
    })
    $("input[name='ProductoForm[tallas][]']").change(function(){
        
        var talla = $(this).val();
        var check = $(this).prop('checked');
        var id = $('#talla_colores').data('producto');
        
        $.ajax({
            url: 'change-talla',
            type: 'post',
            data: {talla:talla, check:check, id:id},
            success: function(html_sold){
                $("#talla_colores").replaceWith(html_sold);
            },
            error: function(){
                alert('Error, algo salio mal');
            },
        })
    })
    
}); //termina document ready
