<?php
	/*
	if($current_user = current_user())
	{
		$current_user_name = $current_user['fname'];	
	}
	else
	{
	
		$config = fb_config();
		
		$this->load->library('facebook', $config);
		$facebook = new Facebook($config);   
		
		$params = array(
			'scope' => 'user_about_me, user_birthday, user_photos, email, publish_stream, offline_access',
			'redirect_uri' => 'http://jatmikoo.com/user/fb_connect'
		);
		$loginUrl = $facebook->getLoginUrl($params);
		
	}
	*/
	$user_data = ($this->session->userdata('user_data')	);
	$fbat = $user_data['fb_access_token'];	
	$current_user_name = "Jatmiko";
?>
<link href="<?php echo base_url() ?>css/header.css" type="text/css" rel="stylesheet" />
<script type="application/javascript">
$(document).ready(function()
{

	$(window).scroll(function()
	{
		$("#header").css("left",$(window).scrollLeft()*(-1));
	});
});

</script>

<div id="header">
    <div id="header_center">
    	
        <?php if ($current_user_name): ?>
   			<div id="header_center_left">
				<img src="<?php echo base_url() ?>images/logo.png" id="header_logo"/>
            </div>
            <div id="header_center_right">
	            <a href="#">
                	<div class="header_button" ><img src="https://graph.facebook.com/me/picture?access_token=<?php echo $fbat ?>" id="header_picture" /> <?php echo $current_user_name; ?></div>
                </a>
                <a href="<?php echo base_url() ?>logout">
                	<div class="header_button">Logout</div>
                </a>
            </div>
    	<?php endif; ?>
    </div>
</div>