function mostrarVideo() {

	var mediaPlayer = document.getElementById("vd-institucional");

	$(window).scroll(function(){
            
        if ($(this).scrollTop() > 326) {
            
            $('.banner-video').slideDown(200);
			$('#vd-mascara').show(200);

			mediaPlayer.play();
            
        } else {



        }
        
    });

}

function fecharVideo() {

	var mediaPlayer = document.getElementById("vd-institucional");

	$('#fecharVideo').click(function(e) {
			
		e.preventDefault();
		
		$('.banner-video').slideUp(200);
		$('#vd-mascara').hide();

		mediaPlayer.pause();
        mediaPlayer.currentTime = 0;

        location.reload();
		
	});

}

function verVideo() {
	
	var mediaPlayer = document.getElementById("vd-institucional");
	
	$('#vd-mascara').hide();

	$('#verVideo').click(function(e) {

		e.preventDefault();

		$('.banner-video').slideDown(200);
		$('#vd-mascara').show(200);

		mediaPlayer.play();

	});

}

$('#free').on($.modal.CLOSE, function(event, modal) {
            
    jwplayer("videoModal").stop();

});

$('#video-institucional').on($.modal.CLOSE, function(event, modal) {
    
    jwplayer("videoModal").stop();

});

$('#video-institucional').on($.modal.OPEN, function(event, modal) {
    
    jwplayer("videoModal").play();

});