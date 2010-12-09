<?php
  header("Content-type: text/xml");
  echo '<?xml version="1.0" encoding="UTF-8"?>';
?>

<chapitres>
    <?php
      foreach($chapitres as $chapitre)
      {
    ?>
        <chapitre num="<?php echo $chapitre['num']; ?>" id="<?php echo $chapitre['id']; ?>"><![CDATA[<?php echo stripslashes($chapitre['nom']); ?>]]></chapitre>     
    <?php
      }
    ?>

</chapitres>
