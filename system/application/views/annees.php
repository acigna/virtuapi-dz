<h2 style="text-align:center;">Les <?php echo $type; ?> de la spécialité <?php echo stripslashes($nom); ?></h2>
<h3>Vueillez choisir l'année qui vous concerne:</h3>
<ul>
 <?php foreach($annees as $annee)
       { 
 ?>
 <li><a href="./../../../index.php/<?php echo $type; ?>/contenu/<?php echo $annee->id ; ?>"> <?php echo stripslashes($annee->nom) ; ?></a></li>

 <?php 
       }
 ?>
</ul>
