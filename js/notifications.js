var socket = io(':3000');
socket.on("messages", function(data){
    console.log('FROM SERVER',data);


    $.ajax({
        url:'notifications/getlastbyauthor',
        type:'POST',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { id:data },
        success: function(r){
            console.log(r)
            console.log('f')
            $('.live').append(r['notification'])
            $('.badge-notify-p-count').removeClass('none');
            $('.badge-notify-p-count').html(r['newnotifications']);
            $('.comment-icon').addClass('blue')

            $.notify(r['message'],{
                position: 'top right',
                className: 'info',
            });

            $(".notification .nlink").on("click",function(e){

                ide = $(this).attr('ide');
                link = $(this).attr('to');
                console.log(ide)
                console.log('que pedo')
                $.ajax({
                    url:'/travel/notification_read',
                    type:'POST',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: { id:ide },
                    success: function(r){
                        window.location.href = link;
                        console.log(r)
                        console.log('go')
                    },
                    error: function(data){
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                })
                return false

             });
        },
        error: function(data){
            var errors = data.responseJSON;
            console.log(errors);
        }
    })
    console.log('expresion')

})
//socket.emit("message", 'Se autorizo un nuevo viaje')

// BORRAR NOTIFICACIONES DEL jewelButton
$('.jewelButton').click(function(){
    id = $(this).attr('ide');
    $('.badge-notify-p-count').hide();
    $('.comment-icon').removeClass('blue')
    $.ajax({
        url:'/user/jewel',
        type:'POST',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { id:3 },
        success: function(r){
            console.log(r)
        },
        error: function(data){
            var errors = data.responseJSON;
            console.log(errors);
        }
    })
})

$(".notification .nlink").on("click",function(e){

    ide = $(this).attr('ide');
    link = $(this).attr('to');
    console.log(ide)
    $.ajax({
        url:'/travel/notification_read',
        type:'POST',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { id:ide },
        success: function(r){
            window.location.href = link;
            console.log(r)
            console.log('go')
        },
        error: function(data){
            var errors = data.responseJSON;
            console.log(errors);
        }
    })
    return false

 });
