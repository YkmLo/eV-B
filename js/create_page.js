// JavaScript Document
$(document).ready(function()
{ 
	$("#submit_btn").click(function(){
		var form_data = 
		{
			tag: $("#tags").val()
		};
		$.ajax(
			{
				url: GD.base_url + "create_book",
				type: 'POST',
				async : true,
				data: form_data,
				dataType: 'json',
				success: function(msg)
				{
					location.replace('/home');
				},
				error: function(msg)
				{
				   alert("Error connecting");
				}
			}
		);
	});
});