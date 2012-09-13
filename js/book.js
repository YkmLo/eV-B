skip = 0;

$(document).ready(function(){
	$('#book').turn({
		autoCenter : true	
	});
	
	$('#book').bind('turning', function(event, pageObject, corner){
		if (pageObject == 4) {
			$('.p2').addClass('fixed');
		}
		if (pageObject == 3) {
			$('.p2').removeClass('fixed');
		}
		
		if (pageObject == $('#book').turn('pages')-3) {
			$('.beforelast').addClass('fixed');
		}
		
		if (pageObject == $('#book').turn('pages')-2) {
			$('.beforelast').removeClass('fixed');
		}
		
		if(pageObject <= 40)		
			$('.page-depth-left').width((pageObject-4)/2);
		
		if(pageObject >= $('#book').turn('pages')-40)		
			$('.page-depth-right').width(($('#book').turn('pages')-pageObject-4)/2);
		
	});
	
	$('#book').bind('turned', function(event, pageObject, corner){
		pages = $('#book').turn('view');
		
		for(i in pages)
		{
			if(pages[i] > 2 && pages[i] < item_count+2){
				$('.p'+pages[i]).html(load_images(pages[i]-3))
			}
		}
		
	});
});

function load_images(skip)
{
	html = '';
	$.ajax(
    {
        url: GD.base_url + "index/get_item?book_id="+book_id+"&skip="+skip+'&time_limit='+timelimit,
        type: 'GET',
        async : false,
        dataType: 'json',
        success: function(items)
        {
            if (items != null)
            {
				html = '<div class="page_content" align="center">';
				html += '<a href="'+ items.location +'">';
				html += '<div class="image_wrapper">';
				html += '<img class="image_item" src="'+ items.location +'" />';
				html += '</div>';
				html += '</a>';
				html += '<div class="image_description_wrapper">';
				html += '<div class="uploaded_by">Uploaded By</div>';
				html += '<div class="image_description_content">';
				html += '<div class="image_uploader">';
				html += '<img src="'+ items.profile_picture_path +'" />';
				html += '</div>';
				html += '<div class="image_description">';
				html += '<span class="image_uploader_name">'+ items.uploader_name +'</span> '+ items.caption +'';
				html += '<div class="timestamp">'+ items.timestamp +'</div>';
				html += '</div>';
				html += '</div>';
				html += '</div>';
				html += '</div>';
            }
        }
    });
	
	return html;
}