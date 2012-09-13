<link href="<?php echo base_url(); ?>css/create_page.css" rel="stylesheet" type="text/css" />
<div id="page_content">
    <div id="page_title">CREATE NEW EVENT BOOK</div>

    <div id="create_form">
    <form action="<?php echo base_url();?>create_page" method="post" >
        <div class="input_box">Tags : <input type="text" name="tags" id="tags"/></div>
        <div class="input_box">
        	<div class="radio_btn"><input type="radio" id name="type" value="public"/>Public</div>
        	<div class="radio_btn"><input type="radio" name="type" value="private"/>Private</div>
        </div>
        <div class="input_box"><input type="submit" name="submit" value="create" id="submit_btn"/></div>
    </form>
    <div id="errors"><?php echo validation_errors();?></div>
    </div>
</div>