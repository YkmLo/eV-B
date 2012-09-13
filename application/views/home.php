<link href="<?php echo base_url(); ?>css/home.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>js/home.js" rel="stylesheet" type="text/javascript" />
<div id="home_content"> 
<a href="<?php echo base_url();?>/create"><input type="button"id="button_add" value="+ ADD"/></a>
<div style="clear:both;"></div>
<div id="bookcase">
    <?php for($j=0;$j<3;$j++):?>
    <div class="book_collection">
		<?php for($i=0;$i<3;$i++):?>
            <div class="book">
            	<div ><img class="image_book" src="<?php echo base_url()?>/images/dummy.jpg" /></div>
                <div class="image_hash">#hashtag</div>
            </div>
        <?php endfor;?>
    </div>
    <?php endfor;?>
</div>
</div>