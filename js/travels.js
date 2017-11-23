
$('.cliente').change(function(){
    $.ajax({
        url:'/locations/get',
        type:'POST',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { id: $('.cliente').val() },
        success: function(locations){
            $('.location').empty() 
            $('.routes').empty()
            $('.location').append('<option value="">Selecciona una locacion u</option>')
            if(locations == ''){
                $('.location').append('<option >Este cliente no cuenta con locaciones - cliente</option>')
            }
            $.each(locations,function(id,location){
                console.log(locations)
                $('.location').append('<option value="'+location.id+'" rel="'+location.geofences_id+'">'+location.name+'</option>')
            })
        },
        error: function(data){
            var errors = data.responseJSON;
            console.log(errors);
        }
    })
})

$('.origin_client').change(function(){
    $.ajax({
        url:'/locations/get',
        type:'POST',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { id: $('.origin_client').val() },
        success: function(locations){
            $('.origin_id').empty()
            $('.origin_id').append('<option value="">Selecciona una locacion i</option>')
            if(locations == ''){
                $('.origin_id').append('<option >Este cliente no cuenta con locaciones - cliente</option>')
            }
            $.each(locations,function(id,location){
                console.log(locations)
                $('.origin_id').append('<option value="'+location.id+'" rel="'+location.geofences_id+'">'+location.name+'</option>')
            })
        },
        error: function(data){
            var errors = data.responseJSON;
            console.log(errors);
        }
    })
})


$('.origin_id').change(function(){ 
    console.log('cambis')
    getPosibleRoutes();
})
$('.location').change(function(){
    getPosibleRoutes();
})

function getPosibleRoutes(){
    console.log('getposibles')
    origen = $('.origin_id option:selected').attr('rel') 
    destino = $('.location option:selected').attr('rel')
    console.log('origent ' + origen + ' destino ' + destino)
    if(origen != '' && destino != ''){
        console.log('buscar rutaw')
        console.log(origen + destino)
            $.ajax({
                url:'/route/getPosibleRoutes',
                type:'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { origin_id: origen, destination_id:destino },
            success: function(PosibleRoutes){
                console.log(PosibleRoutes)
                $('.posible').empty()
                $('.posible').append('<option >Selecciona una ruta</option>')
                if(PosibleRoutes == ''){
                    showMakeRoute()
                    $('.posible').append('<option >Sin rutas disponibles</option>')
                }
                $.each(PosibleRoutes,function(id,route){
                    showPosibleRoute()
                    $('.posible').append('<option value="'+route.id+'"><h1>Ruta:</h1> '+route.name+' Referencias: '+route.references_name+'</option>')
                })
            },
            error: function(data){
                var errors = data.responseJSON;
                console.log(errors);
            }
        })
    }else{
        console.log('no buscar')
        console.log(origen + destino)
    }
}
$('.createNewRoute').click(function (argument) {
    console.log('nueva')
    showMakeRoute()
})

$('.posibleRouteButton').click(function (argument) {
    console.log('nueva')
    showPosibleRoute()
})
function showMakeRoute(){
    console.log('haz ruta')
    $('.makeRoute').show()
    hidePosibleRoute()
}
function showPosibleRoute(){
    console.log('escoge')
    $('.posibleRoute').show()
    $('.posibleRouteButton').show()
    hideMakeRoute()
}

function hideMakeRoute(){
    $('.makeRoute').hide()
    console.log('esconde hacer ruta')
}
function hidePosibleRoute(){
    $('.posibleRoute').hide()
    $('.posibleRouteButton').show()
    console.log('esconde las posiblesm')
}
$('.get_travels_by_date').click(function(){
    $.ajax({
        url:'/travels/get_travels_by',
        type:'POST',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { init: $('.init').val(), end: $('.end').val(),by:'date' },
        success: function(r){
            $('.travel-table tbody').empty()
            if(r==''){
                $('.travel-table tbody').html('<tr><td colspan="7"> No existen viajes registrados en este rango de fechas</td></tr>')
            }else{
                $('.travel-table tbody').html(r)
            }
        },
        error: function(data){
            var errors = data.responseJSON;
            console.log(errors);
        }
    })
})

$('.get_travels_by_driver').click(function(){
    $.ajax({
        url:'/travels/get_travels_by',
        type:'POST',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { driver_id: $('#driver_id').val(),by:'driver'  },
        success: function(r){
            console.log(r)

            $('.travel-table tbody').empty()
            if(r==''){
                $('.travel-table tbody').html('<tr><td colspan="7"> No existen viajes registrador a este chofer</td></tr>')
            }else{
                $('.travel-table tbody').html(r)
                cancel_travel()
            }

            force = r
        },
        error: function(data){
            var errors = data.responseJSON;
            console.log(errors);
        }
    })
})


$('.get_travels_by_reference').click(function(){
    console.log($('.reference_val').val())
    $.ajax({
        url:'/travels/get_travels_by',
        type:'POST',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { reference: $('.reference_val').val(),by:'reference'  },
        success: function(r){
            console.log(r)

            $('.travel-table tbody').empty()
            if(r==''){
                $('.travel-table tbody').html('<tr><td colspan="7"> No existen viajes registrados con esta referencia</td></tr>')
            }else{
                $('.travel-table tbody').html(r)
                cancel_travel()
            }

            force = r
        },
        error: function(data){
            var errors = data.responseJSON;
            console.log(errors);
        }
    })
})



$('.get_travels_by_device').click(function(){
    console.log('por drivergs')
    $.ajax({
        url:'/travels/get_travels_by',
        type:'POST',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { device_id: $('#device_id').val(),by:'device'  },
        success: function(r){
            $('.travel-table tbody').empty()
            if(r==''){
                $('.travel-table tbody').html('<tr><td colspan="7"> No existen viajes registrados a esta unidad</td></tr>')
            }else{
                $('.travel-table tbody').html(r)
                cancel_travel()
            }

            force = r
        },
        error: function(data){
            var errors = data.responseJSON;
            console.log(errors);
        }
    })
})

$('.get_travels_by_status').click(function(){
    console.log($(this).attr('description'))
    des = $(this).attr('description')
    $.ajax({
        url:'/travels/get_travels_by', 
        type:'POST',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { by:$(this).attr('by')  },
        success: function(r){
            $('.travel-table tbody').empty()
            if(r==''){
                $('.travel-table tbody').html('<tr><td colspan="7"> No existen viajes con el estado '+ des +'</td></tr>')
            }else{
                $('.travel-table tbody').html(r)
                cancel_travel()
            }
        },
        error: function(data){
            var errors = data.responseJSON;
            console.log(errors);
        }
    })
})



$('.routes').change(function(){
    $.ajax({
        url:'/trucks/get',
        type:'POST',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { id: $('.routes').val() },
        success: function(r){
            /* DESCOMENTAR PARA DETECTAR UNIDADES
            //RELLENAR UNIDADES
            $('.devices').empty()
            $('.device_label').html('Unidades disponibles dentro de la geocerca ' + r['geofence'])
            $('.devices').append('<option >Selecciona una unidad</option>')
              if(r['devices'] == ''){
                $('.devices').append('<option >No existen unidades disponibles dentro de la geocerca de origen</option>')
            }
            $.each(r['devices'],function(id,device){
                $('.devices').append('<option value="'+device.id+'">'+device.name+'</option>')
            })

            //RELLENAR CAJAS
            $('.boxes').empty()
            $('.box_label').html('Cajas disponibles dentro de la geocerca ' + r['geofence'])
            $('.boxes').append('<option >Selecciona una unidad</option>')
              if(r['boxes'] == ''){
                $('.boxes').append('<option >No existen cajas disponibles dentro de la geocerca de origen</option>')
            }
            $.each(r['boxes'],function(id,device){
                b=''
                if(device.new==1){
                    b = '*Caja Nueva'
                }
                $('.boxes').append('<option value="'+device.id+'">'+device.name+' '+b+'</option>')
            }) */
        },
        error: function(data){
            var errors = data.responseJSON;
            console.log(errors);
        }
    })
})



$('.location').change(function(){
    $.ajax({
        url:'/route/get',
        type:'POST',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { id: $('.location option:selected').attr('rel') },
        success: function(routes){
            $('.routes').empty()
            $('.location').append('<option >Selecciona una locacion</option>')
              if(routes == ''){
                $('.routes').append('<option >Este cliente no cuenta con locaciones - location</option>')
            }
            $.each(routes,function(id,route){
                $('.routes').append('<option value="'+route.id+'">'+route.name+'</option>')
            })
        },
        error: function(data){
            var errors = data.responseJSON;
            console.log(errors);
        }
    })


})

$('.boxs_number').change(function(){
    if($(this).val()==2){
        $('.addbox').removeClass('none')
    }else{
        $('.addbox').addClass('none')
    }
})
 
function cancel_travel(){
    $('.cancel_travel').click(function(){
        ide = $(this).attr('ide')
        console.log(ide)
        $.confirm({
            title: 'Cancelar viaje!',
            content: '' +
            '<form action="" class="formName">' +
            '<div class="form-group">' +
            '<label>Porfavor ingresa el motivo de cancelación.</label>' +
            '<input type="text" placeholder=" " class="name form-control" required />' +
            '</div>' +
            '</form>', 
            buttons: { 
                formSubmit: {
                    text: 'Enviar',
                    btnClass: 'btn-blue',
                    action: function () {
                        var name = this.$content.find('.name').val();
                        if(!name){
                            $.alert('provide a valid name');
                            return false;
                        }
                        $.ajax({
                            url:'/travel/cancel',
                            type:'POST',
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: { id: ide,motivo:name },
                            success: function(r){
                                console.log(r)
                                console.log('#travel'+ide)
                                $('#travel'+ide).hide()
                            },
                            error: function(data){
                                var errors = data.responseJSON;
                                console.log(errors);
                            }
                        })
                    }
                },
                cancel: function () {
                    //close
                },
            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    console.log('x')
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    })
}
$('.cancel_travel').click(function(){
    ide = $(this).attr('ide')
    $.confirm({
        title: 'Cancelar viaje!',
        content: '' +
        '<form action="" class="formName">' +
        '<div class="form-group">' +
        '<label>Porfavor ingresa el motivo de cancelación.</label>' +
        '<input type="text" placeholder=" " class="name form-control" required />' +
        '</div>' +
        '</form>',
        buttons: {
            formSubmit: {
                text: 'Enviar',
                btnClass: 'btn-blue',
                action: function () {
                    var name = this.$content.find('.name').val();
                    if(!name){
                        $.alert('provide a valid name');
                        return false;
                    }
                    $.ajax({
                        url:'/travel/cancel',
                        type:'POST',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: { id: ide,motivo:name },
                        success: function(r){ 
                                $('#travel'+ide).hide()
                        },
                        error: function(data){
                            var errors = data.responseJSON;
                            console.log(errors);
                        }
                    })
                }
            },
            cancel: function () {
                //close
            },
        },
        onContentReady: function () {
            // bind to events
            var jc = this;
            this.$content.find('form').on('submit', function (e) {
                // if the user submits the form by pressing enter in the field.
                e.preventDefault();
                jc.$$formSubmit.trigger('click'); // reference the button and click it
            });
        }
    });
})

$('.delete_order').click(function(){
    ide = $(this).attr('ide')
    console.log(ide)
    console.log('eliminar orden')
    $.confirm({
        title: 'Eliminar orden!',
        content: '' +
        '<form action="" class="formName">' +
        '<div class="form-group">' +
        '<label>Porfavor ingresa el motivo de la eliminaci¨®n</label>' +
        '<input type="text" placeholder="Your name" class="name form-control" required />' +
        '</div>' +
        '</form>',
        buttons: {
            formSubmit: {
                text: 'Submit',
                btnClass: 'btn-blue',
                action: function () {
                    var name = this.$content.find('.name').val();
                    if(!name){
                        $.alert('provide a valid name');
                        return false;
                    }
                    $.ajax({
                        url:'/travels/delete_order',
                        type:'POST',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: { id: ide,motivo:name },
                        success: function(r){
                            if(r=='eliminado'){
                                $('#order_'+ide).hide()
                            }
                        },
                        error: function(data){
                            var errors = data.responseJSON;
                            console.log(errors);
                        }
                    })
                }
            },
            cancel: function () {
                //close
            },
        },
        onContentReady: function () {
            // bind to events
            var jc = this;
            this.$content.find('form').on('submit', function (e) {
                // if the user submits the form by pressing enter in the field.
                e.preventDefault();
                jc.$$formSubmit.trigger('click'); // reference the button and click it
            });
        }
    });
})