<?php
  header("Content-type: text/xml");
  echo '<?xml version="1.0" encoding="UTF-8"?>';
?>


<modules>
    <?php
       foreach($modules as $module)
       {           
    ?>
       <module id="<?php echo $module['id']; ?>"><![CDATA[<?php echo stripslashes($module['nom']); ?>]]></module>
    
    <?php
       }
    ?>

</modules>
