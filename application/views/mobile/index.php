<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:fb="https://www.facebook.com/2008/fbml">
   <head>
      <title>Flipix</title>
      <link href="<?php echo base_url() ?>css/index.css" rel="stylesheet" type="text/css" />
      <link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.1/jquery.mobile.structure-1.1.1.min.css" />       
      <script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
      <script src="http://code.jquery.com/mobile/1.1.1/jquery.mobile-1.1.1.min.js"></script>   
      
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
