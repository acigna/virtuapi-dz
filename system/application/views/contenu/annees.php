<?php
  //Charger le helper url  
  $this->load->helper('url');

  //Charger la librairie oms et afficher la partie haute
  $this->load->library('oms');
  $this->oms->partie_haute("Les $type de la spécialité " . stripslashes($nom));
?>

<h2 class="center">Les <?=$type; ?> de la spécialité <?=stripslashes($nom); ?></h2>
<h3>Vueillez choisir l'année qui vous concerne:</h3>
<ul>
  <?php foreach($annees as $annee) { 
  ?>
  <li><a href="<?=site_url( array( $type, "contenu", $annee->id ) ); ?>"> <?=stripslashes($annee->nom) ; ?></a></li>

  <?php 
       }
  ?>
</ul>

<?php
  //Afficher la partie basse
  $this->load->view('includes/partie_basse.php');
?>
