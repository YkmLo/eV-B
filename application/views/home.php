<link href="<?php echo base_url(); ?>css/home.css" rel="stylesheet" type="text/css" />

<div id="home_content"> 
<input type="button"id="button_add" value="+ ADD"/>
<div style="clear:both;"></div>
<div id="bookcase">
    <?php for($j=0;$j<3;$j++):?>
    <div class="book_collection">
		<?php for($i=0;$i<3;$i++):?>
            <img class="book" src="<?php echo base_url()?>images/book.png"/>
        <?php endfor;?>
    </div>
    <?php endfor;?>
</div>
</div>