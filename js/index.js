// JavaScript Document

$('.fb_btn').click(function () {
	fb_dialog = window.open('', 'Facebook', 'menubar=no,width=790,height=360,toolbar=no');
  
    var form_data = {
        type : 'connect'
    };
    
	$.ajax(
    {
        url: GD.base_url + "fb_connection",
        type: 'POST',
        async : true,
        data : form_data,
        dataType: 'json',
        success: function(msg)
        {
            if (msg.status == "success")
            {
                fb_dialog.document.location.href = msg.url
            }
            else
            {
				fb_dialog.close();
                alert(msg.reason);
            	
			}
        }
		,error: function(msg)
		{
			alert(msg.reason);
		}
    });
});