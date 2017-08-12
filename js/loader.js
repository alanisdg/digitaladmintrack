$(window).on('load', function() { // makes sure the whole site is loaded 
 
  $('#status').fadeOut(); // will first fade out the loading animation 
  $('#preloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website. 
  $('body').delay(350).css({'overflow':'visible'});

})

function loaderON(){
	$('#status').show()
    $('#preloader').show()
    $('body').css('overflow','hidden');
}

function loaderOFF(){
	$('#status').fadeOut(); // will first fade out the loading animation 
  	$('#preloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website. 
  	$('body').delay(350)
  	$('body').css('overflow','visible');
}