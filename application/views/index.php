<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:fb="https://www.facebook.com/2008/fbml">
   <head>
      <title>eV-B</title>
      <link href="<?php echo base_url() ?>css/index.css" rel="stylesheet" type="text/css" />
      <script type="text/javascript">
	   var GD = {
		  'base_url': '<?php echo base_url(); ?>'
	   };
</script>

      <script src="<?php echo base_url(); ?>js/jquery.min.js"></script>
		<script src="<?php echo base_url();?>js/index.js"></script>
   </head>

   <body>

      <div data-role="page">
         <a name="top"></a>
         <?php echo $header; ?>
         <?php echo $content; ?>
         <?php echo $footer; ?>

      </div><!-- /page -->


   </body>


</html>
