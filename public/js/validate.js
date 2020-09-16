$( "#name" ).keyup(function() {
     
    validateField('name')
    validateAll()
  });
  $( "#ciudad" ).keyup(function() {
     
    validateField('ciudad')
    validateAll()
  });

$( "#empresa" ).keyup(function() {
    validateField('empresa')
    validateAll()
});
$("#unidades").keyup(function() {
    validateUnidades()
    validateAll()
});

$('#correo').keyup(function(){
    ValidateEmail($('#correo').val())
    validateAll()
})

function ValidateEmail(mail) 
{
    var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    if(!mail.match(mailformat))
    {
        console.log('invalido')
        $('#correo').removeClass('is-valid').addClass('is-invalid')
    $('#correo-errors').html('Ingresa un correo válido');
    }else{
        $('#correo').removeClass('is-invalid').addClass('is-valid')
    }
}


function validateUnidades(){
    if (!$('#unidades').val()){
        $('#unidades-errors').html('Rellena este campo');
    }
}
function validateEdad(){
    var edad = []
     
    if (!$('#edad').val()){
        edad.push('Rellena este campo');
    }else if( $('#edad').val() < 18 || $('#edad').val() > 99 ){
        console.log('error de edad')
        edad.push('Edad no permitida');
    }
    if(edad.length > 0){ 
        $('#edad').removeClass('is-valid').addClass('is-invalid')
    }
    erroresEdad = ''
    $.each(edad,function(a,b){
        erroresEdad += b + ' <br>'
    })
    $('#edad-errors').html(erroresEdad);
    if(edad.length == 0){
        $('#edad').removeClass('is-invalid').addClass('is-valid')
        return true
    }else{
        return false
    }
}



function validateField(field){
    var name = []
     
    if ($('#'+field).val().length > 50){
        
        name.push('El campo no puede tener mas de 50 caracteres');
    }
    if ($('#'+field).val().match(/\d+/g)){
        name.push('El campo solo puede contener letras'); 
    }
    if (!$('#'+field).val()){
        name.push('Rellena este campo');
    }
    if(name.length > 0){ 
        $('#'+field).removeClass('is-valid').addClass('is-invalid')
    }
    error = ''
    $.each(name,function(a,b){
       error += b + ' <br>'
    })
    $('#name-errors').html(error);
    if(name.length == 0){
        $('#'+field).removeClass('is-invalid').addClass('is-valid')
        return true
    }else{
        return false
    }
    
}


function validateNombre(){
    var name = []
     
    if ($('#name').val().length > 50){
        
        name.push('El nombre no puede tener mas de 50 caracteres');
    }
    if ($('#name').val().match(/\d+/g)){
        name.push('El nombre solo puede contener letras'); 
    }
    if (!$('#name').val()){
        name.push('Rellena este campo');
    }
    if(name.length > 0){ 
        $('#name').removeClass('is-valid').addClass('is-invalid')
    }
    error = ''
    $.each(name,function(a,b){
       error += b + ' <br>'
    })
    $('#name-errors').html(error);
    if(name.length == 0){
        $('#name').removeClass('is-invalid').addClass('is-valid')
        return true
    }else{
        return false
    }
    
}

function validateSelect(id){
    if($(id).val() != null){
        $(id).removeClass("is-invalid").addClass("is-valid");
        return true;
    }else{
        $(id).removeClass("is-valid").addClass("is-invalid");
    }
}

$('#paises').change(function(){
    validateSelect('#paises') 
    validateAll()
})
$('#estados').change(function(){
    validateSelect('#estados') 
    validateAll()
})
$('#ciudades').change(function(){
    validateSelect('#ciudades')
    validateAll()
})
 function validateAll(){
    i = 0;
    $("form :input").each(function(){
        
        if( $(this).hasClass('is-valid')){
            i++
        }
        console.log(i)
        if(i == 5){
            $('button').removeAttr('disabled');
        }else{
            $('button').attr("disabled", true);
        }
       });
 }


  
$( "#signupForm" ).submit(function( event ) {
    event.preventDefault();
    validateNombre()
    validateEdad()
    validateSelect('#paises')
    validateSelect('#estados')
    validateSelect('#ciudades') 
    if(validateSelect('#paises') == true && validateSelect('#estados') == true && validateSelect('#ciudades') == true && validateNombre() == true && validateEdad() == true){
        user = {
            ciudadId:$('#ciudades').val(),
            nombre:$('#nombre').val(),
            edad:$('#edad').val()
        }
        console.log(user)
        $.ajax({
            type: "POST",
            url: "http://localhost:8080/servicio/guardar",
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify(user),
            dataType: "json",
            success: function (response) {  
                console.log(response)
                $('.form-container').html('<p>'+response.resultado+'</p><p>Bienvenido a SISU</p>')
                
            },
            error: function (xhr, status, error) {
              console.log(error);
            },
          });
    }
});