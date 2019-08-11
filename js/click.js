$(function(){
	$(".comment-display").on('click', function(event){
		$(this).css('display', 'none');
		$(this).next().css('display', 'block');
		var params;
		event.preventDefault();
		var $post_id = $(this).parent().attr('class');
		var className = "#comment-"+$post_id.replace(/[^0-9]/g, "");
		// $(className).html(className);
		var pathname= location.pathname;

		params = { "post_id": $post_id};
		$.ajax({
			type: "GET",
			url: "comment_display.php",
			data: params,
			crossDomain: false,
			dataType : "json",
			scriptCharset: 'utf-8'
		}).done(function(data){
			$(className).html(data);
		}).fail(function(XMLHttpRequest, textStatus, errorThrown){
			alert(errorThrown);
		});
	});

	$(".comment-hidden").on('click', function(event){
		// event.preventDefault();
		$(this).css('display', 'none');
		$(this).prev().css('display', 'block');
		$(this).siblings('.comment-wrapper').empty();
	});
});
