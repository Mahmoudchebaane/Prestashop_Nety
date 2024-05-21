$(function() {

	$('.comments_advices_tab').click(function(e){
		e.preventDefault();
		//$('body').scrollTop();
		$('#content-wrapper ul.nav-tabs a').removeClass('active');
		$('a[href="#reviews"]').addClass('active');
		$('#content-wrapper .tab-pane').removeClass('active');
		$("#reviews").addClass('active');
		if(!$("#reviews").hasClass("in"))
			$("#reviews").addClass('in');
	});

	novproductcomments_controller_url = novproductcomments_controller_url.replace(/&amp;/g, '&').replace(/%2C/g, ',');
	$('input.star').rating();
	$('.auto-submit-star').rating();

	$('button.usefulness_btn').click(function() {
		var id_product_comment = $(this).data('id-product-comment');
		var is_usefull = $(this).data('is-usefull');
		var parent = $(this).parent();

		$.ajax({
			url: novproductcomments_controller_url + '?rand=' + new Date().getTime(),
			data: {
				id_product_comment: id_product_comment,
				action: 'comment_is_usefull',
				value: is_usefull
			},
			type: 'POST',
			headers: { "cache-control": "no-cache" },
			success: function(result){
				parent.fadeOut('slow', function() {
					parent.remove();
				});
			}
		});
	});

	$('span.report_btn').click(function() {
		if (confirm(confirm_report_message))
		{
			var idProductComment = $(this).data('id-product-comment');
			var parent = $(this).parent();

			$.ajax({
				url: novproductcomments_controller_url + '?rand=' + new Date().getTime(),
				data: {
					id_product_comment: idProductComment,
					action: 'report_abuse'
				},
				type: 'POST',
				headers: { "cache-control": "no-cache" },
				success: function(result){
					parent.fadeOut('slow', function() {
						parent.remove();
					});
				}
			});
		}
	});

	$('#submitNewMessage').click(function(e) {
		// Kill default behaviour
		e.preventDefault();

		// Form element
        if (novproductcomments_url_rewrite && novproductcomments_url_rewrite == 1)
			url_options = '?';
		else
			url_options = '&';
		
		$.ajax({
			url: novproductcomments_controller_url + url_options + 'action=add_comment&secure_key=' + secure_key + '&rand=' + new Date().getTime(),
			data: $('#id_new_comment_form').serialize(),
			type: 'POST',
			headers: { "cache-control": "no-cache" },
			dataType: "json",
			success: function(data){
				if (data.result)
				{
					$('#new_comment_form_footer').append('<span class="success-comment">'+productcomment_added+'</span>');
					$('#new_comment_form').modal('hide');
				}
				else
				{
					$('#new_comment_form_error ul').html('');
					$.each(data.errors, function(index, value) {
						$('#new_comment_form_error ul').append('<li>'+value+'</li>');
					});
					$('#new_comment_form_error').slideDown('slow');
				}
			}
		});
		return false;
	});
});

function productcommentRefreshPage() {
    window.location.reload();
}