<?php
  header("Content-type: text/xml");
  echo '<?xml version="1.0" encoding="UTF-8"?>';
?>

<annees>
  <?php
      foreach($annees as $annee)
      {
    ?>
        <annee id="<?php echo $annee->id; ?>"><![CDATA[<?php echo stripslashes($annee->nom); ?>]]></annee>     
    <?php
      }
    ?>
   
</annees>
