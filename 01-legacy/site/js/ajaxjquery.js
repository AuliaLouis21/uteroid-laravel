//------- iki js buat togle di page testi
$(document).ready(function() {
	$("#btadd").click(function() { $("#formadd").slideToggle(200); });

//------- js buat box grid

	$('.boxgrid.caption').hover(function(){
		$(".cover", this).stop().animate({top:'0px'},{queue:false,duration:160});
	}, function() {
		$(".cover", this).stop().animate({top:'100px'},{queue:false,duration:160});
	});

//------- js buat box news ticker

	$('#newsnya').show().innerfade({
		animationtype: 'slide',
		speed: 550,
		timeout: 4000,
		type: 'sequence',
		containerheight: '1em'
	});
});

//------- js buat order pages

function next()
{
  $("#order1").slideUp();
  $("#order2").slideDown(); 
}

function mbalik()
{
  $("#order2").slideUp();
  $("#order1").slideDown(); 
}

//------- js buat categories list

$(function(){
	$("#menuscrolling").vTicker({
	   speed: 200,
	   pause: 3000,
	   showItems: 36,
	   animation: 'fade',
	   mousePause: true
	});
});

