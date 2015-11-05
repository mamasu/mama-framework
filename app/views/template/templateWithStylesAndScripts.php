<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo isset($pageTitle) ? $pageTitle . " | " : "";?>Parallels Store</title>
        <?php if(isset($styles)) echo $styles;?>
    </head>
    <body>
            <?php //echo $menu; ?>        

            <?php echo $content;?> 

            <?php 
//            if(isset($footer)){
//                echo $footer;        
//            }
//            else{
//                require_once($_SERVER['DOCUMENT_ROOT'] . '/class/footer.php');
//            }
            ?>
      <div id="titleBox"><p></p></div><?php //THIS DIV is the container of the custom title ?>
      <?php if(isset($scripts)) echo $scripts;?>
    </body>
</html>