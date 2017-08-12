$('.delete_device').click(function(){
    ide = $(this).attr('ide')
    $.confirm({
                                title: 'Eliminar equipo',
                                content: 'Estas seguro de ejecutar esta acción?',
                                icon: 'fa fa-question-circle',
                                animation: 'scale',
                                closeAnimation: 'scale',
                                opacity: 0.5,
                                buttons: {
                                    'confirm': {
                                        text: 'Si',
                                        btnClass: 'btn-blue',
                                        action: function () {
                                            $.confirm({
                                                title: 'Esto puede ser delicado',
                                                content: 'Se perderan todos los paquetes relacionados a este equipo',
                                                icon: 'fa fa-warning',
                                                animation: 'zoom',
                                                closeAnimation: 'zoom',
                                                buttons: {
                                                    confirm: {
                                                        text: 'Si, estoy seguro',
                                                        btnClass: 'btn-orange',
                                                        action: function () {
                                                            $.ajax({
                                                                url:'/dashboard/device/delete',
                                                                type:'POST',
                                                                dataType: 'json',
                                                                headers: {
                                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                                },
                                                                data: { id: ide },
                                                                success: function(r){
                                                                    console.log(r.id) 
                                                                    $('.device_'+r.id).hide()
                                                                },
                                                                error: function(data){
                                                                    var errors = data.responseJSON;
                                                                    console.log(errors);
                                                                }
                                                            })
                                                        }
                                                    },
                                                    cancel: function () {
                                                        $.alert('No se ha eliminado el equipo');
                                                    }
                                                }
                                            });
                                        }
                                    },
                                    cancel: function () {

                                    },

                                }
                            });
})
