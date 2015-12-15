$(function() {
	
	var speed = 500;
	var autoswitch = true;
	var autoswitch_speed = 4000;
	
	$('.slide').first().addClass('active');
	$('.slide').hide();
	$('.active').show();

	
	if (autoswitch == true) {
		setInterval(nextSlide, autoswitch_speed);
	}
	
	$('.slider-next').on('click',  nextSlide);
	
	$('.slider-prev').on('click', prevSlide);
	
	function nextSlide() {
		$('.active').removeClass('active').addClass('oldActive');
		if ($('.oldActive').is(':last-child')) {
			$('.slide').first().addClass('active');
		} else {
			
			$('.oldActive').next().addClass('active');
		}
		
		$('.oldActive').removeClass('oldActive');
		$('.slide').fadeOut(speed);
		$('.active').fadeIn(speed);
		
		return false;
		
	};
	
	function prevSlide() {
		$('.active').removeClass('active').addClass('oldActive');
		if($('.oldActive').is(':first-child')){
			$('.slide').last().addClass('active');
		} else {
			$('.oldActive').prev().addClass('active');
		}
		$('.oldActive').removeClass('oldActive');
		$('.slide').fadeOut(speed);
		$('.active').fadeIn(speed);
		
		return false;
	}
	
	
	
})