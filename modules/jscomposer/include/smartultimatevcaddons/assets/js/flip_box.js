;(function ( $, window, undefined ) {

	$(window).load(function(a){
		flip_box_set_auto_height();
	});
	$(document).ready(function(a) {
		flip_box_set_auto_height();
		$(window).resize(function(a){
			flip_box_set_auto_height();
		});
	});
	function flip_box_set_auto_height() {
		$('.flip-box').each(function(index, value) {
			var WW = $(window).width() || '';
			if(WW!='') {
				if(WW>=768) {
					var h = $(this).attr('data-min-height') || '';
					if(h!='') {
						$(this).css('height', h);
					}
				} else {

					/* 	for style - 9 */
					if( $(this).hasClass('style_9') ) {

						$(this).css('height', 'initial');
						var f1 = $(this).find('.ifb-front-1 .ifb-front').outerHeight();
						var f2 = $(this).find('.ifb-back-1 .ifb-back').outerHeight();
						/* 	set largest height - of either front or back */
						if( f1 > f2 ) {
							$(this).css('height', f1);
						} else {
							$(this).css('height', f2);
						}
						
					} else {
						$(this).css('height', 'initial');
					}
				}
			}
		});
	}

}(jQuery, window));