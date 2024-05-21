function changeTypeMenu() {
    $(".type_group").parent().parent().hide();
    $("#categories").parent().parent().parent().hide();
	var val = $( "#type_menu option:selected" ).val();
	if($("[id^=type_url_]").closest('.form-group').find('.translatable-field').length){
		$("[id^=type_url_]").closest('.form-group').parent().parent().hide();
		$(".html_lang").closest('.form-group').parent().parent().hide();
		if(val == 'url')
			$("[id^=type_url_]").closest('.form-group').parent().parent().show();
		else if(val == 'html')
			$(".html_lang").closest('.form-group').parent().parent().show();
		else if(val == 'category')
			$("#categories").parent().parent().parent().show();
		else
			$("#type_"+val).parent().parent().show();
	}
	else{
		$("[id^=type_url_]").closest('.form-group').hide();
		$(".html_lang").closest('.form-group').hide();	
		if(val == 'url')
			$("[id^=type_url_]").closest('.form-group').show();
		else if(val == 'html')
			$(".html_lang").closest('.form-group').show();	
		else if(val == 'category')
			$("#categories").parent().parent().parent().show();
		else
			$("#type_"+val).parent().parent().show();
	}
}

function changeWidthMenu() {
	    $(".sub_width").parent().parent().hide();
		var val = $( "#sub_menu option:selected" ).val();
		if(val == 'yes'){
			$(".sub_width").parent().parent().show();
		}	
}

function changeTypeIcon() {
	$("#icon").closest('.form-group').parent().parent().hide();
	$("#icon_class").closest('.form-group').hide();
	var type_icon = $( "#type_icon option:selected" ).val();
	if(type_icon == 'class')
	{
		$("#icon_class").closest('.form-group').show();
	}
	else if(type_icon == 'image')
	{
		$("#icon").closest('.form-group').parent().parent().show();
	}
}

function changeWidthMenu() {
	    $(".sub_width").parent().parent().hide();
		var val = $( "#sub_menu option:selected" ).val();
		if(val == 'yes'){
			 $(".sub_width").parent().parent().show();
		}	
}

jQuery(document).ready(function(){
	changeTypeMenu();
	changeWidthMenu();
	changeTypeIcon();
	$("#type_menu").change(function(){
		changeTypeMenu();
	});
	
	$("#sub_menu").change(function(){
		changeWidthMenu();
	});
	
	$("#type_icon").change(function(){
		changeTypeIcon();
	});

    // activate Nestable for list 1
    $('#nestable').nestable({
            listNodeName    : 'ol',
            itemNodeName    : 'li',
            rootClass       : 'mgmenu',
            listClass       : 'mgmenu-list',
            itemClass       : 'mgmenu-item',
            dragClass       : 'mgmenu-dragel',
            handleClass     : 'mgmenu-handle',
            collapsedClass  : 'mgmenu-collapsed',
            placeClass      : 'mgmenu-placeholder',
            noDragClass     : 'mgmenu-nodrag',
            emptyClass      : 'mgmenu-empty',
            group           : 0,
			expandBtnHTML   : '<button data-action="expand" type="button">Expand</button>',
            collapseBtnHTML : '<button data-action="collapse" type="button">Collapse</button>',
    });
    

    $('#nestable-menu').on('click', function(e)
    {
        var target = $(e.target),
            action = target.data('action');
        if (action === 'expand-all') {
            $('.mgmenu').nestable('expandAll');
        }
        if (action === 'collapse-all') {
            $('.mgmenu').nestable('collapseAll');
        }
    });
	
	$('#updateposition').click(function(){
        serialized = JSON.stringify( $('#nestable').nestable('serialize'));
		var $this  = $(this);
		$.ajax({
			type: 'POST',
			url: action+"&rand="+Math.random(),
			data : 'serialized='+serialized+'&updatePosition=1' 
		}).done( function () {
			$this.val( 'Update Sucess' );
		});
	});
	
	$(".icon-remove").click( function(){  
		var check =  confirm('are you sure you want to delete this?');
		if(check == true){
			idnovverticalmenu = $(this).data("idnovverticalmenu");
			$(this).closest('li').remove();
			$.ajax({
				url:action,
				data: 'idnovverticalmenu='+idnovverticalmenu+'&deletedata=1',
				type:'POST',
				}).done(function(msg) {
					location.reload();
				});
		}
	} );
	$(".icon-check").click( function(){  
		   if($(this).hasClass('disabled'))
				$(this).removeClass('disabled');
		   else
				$(this).addClass('disabled');
			idnovverticalmenu = $(this).data("idnovverticalmenu");
			$.ajax({
				url:action,
				data: 'idnovverticalmenu='+idnovverticalmenu+'&changestatus=1',
				type:'POST',
				}).done(function(msg) {
					return false;
				});
			return false;	
	});
});	