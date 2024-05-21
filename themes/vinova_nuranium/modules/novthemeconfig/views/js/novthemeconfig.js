$(document).ready(function(){
	$(".nov-image-more").each(function() {
		addJSProduct($(this).data("idproduct"));
		addHoverImage();
	});
});

function addJSProduct(idproduct) {
        $('.thumbs_list_'+idproduct).serialScroll({
            items: 'li:visible',
            prev: '.view_scroll_left_' + idproduct,
            next: '.view_scroll_right_' + idproduct,
            axis: 'y',
            offset: 0,
            start: 0,
            stop: true,
            duration: 700,
            step: 1,
            lazy: true,
            lock: false,
            force: false,
            cycle: false
        });
        $('.thumbs_list_' + idproduct).trigger('goto', 1);
        $('.thumbs_list_' + idproduct).trigger('goto', 0);
}

function addHoverImage() {
	$(".nov-list-image").each(function() {
		$(this).mouseover(function() {
			var view_image = $(this).parent().attr("href");
			$(this).closest('.product-container').find(".product_img_link img").attr("src", view_image);
		});
		$(this).closest('a').fancybox({
			'hideOnContentClick': true,
			'transitionIn'  : 'elastic',
			'transitionOut' : 'elastic'
		});
	});
}