<link href="<?php echo base_url(); ?>css/home.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>js/home.js" rel="stylesheet" type="text/javascript" />
<div id="home_content"> 
<a href="<?php echo base_url();?>create"><input type="button"id="button_add" value="+ ADD"/></a>
<div style="clear:both;"></div>
    <div id="bookcase">
        <?php $flagdata=0; for($j=0;$j<$flag;$j++):?>
        <div class="book_collection">
            <?php  for($i=0;$i<3;$i++):?>
               	<?php if($flagdata>=$total) break; ?>
                <a href="<?php echo base_url();?>book/<?php echo $data[$flagdata]['bookid_pk'];?>">
                    <div <?php if($i==0):?> style="margin-left:90px;" <?php endif;?> class="book">
                        <div ><img class="image_book" src="<?php echo base_url()?>/images/dummy.jpg" /></div>
                        <div class="image_hash"><?php echo $data[$flagdata]['bookname']; ?></div>
                    </div>
                </a>
                
     		<?php $flagdata++;  endfor; ?>
            <div style="clear:both"></div>
        </div>
        <?php endfor;?>
    </div>
</div>