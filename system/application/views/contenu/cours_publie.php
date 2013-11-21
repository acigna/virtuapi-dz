<?php
  //Récupérer la libririe OMS, et afficher la partie haute
  $this->load->library('oms');
  $this->oms->partie_haute("Cours publié avec succès");
?>

<h2 class="center">Votre contenu de Cours a été envoyé avec succés</h2>
<p>Avant que votre contenu soit publié, un modérateur du portail analysera votre contenu et déterminera s'il est conforme ou non. Nous vous remercions
pour votre contribution au contenu du portail VirtUAPI-DZ.<br/>
<h4>Que faire maintenant?</h4>
  <ul>
    <li><a href="">Publier un autre Cours</a><br/></li>
    <li><a href="<?=site_url( array("universite_virtuelle") );?>">Aller vers l'université virtuelle</a></li>
    <li><a href="<?=base_url();?>">Aller vers la page d'acceuil</a></li>
    <li><a href="<?=site_url( array("sujets", "publier") ); ?>">Publier un sujet ou une solution d'un sujet d'examen</a></li>
    <li><a href="<?=site_url( array("td", "publier") ); ?>">Publier une série ou une solution d'un TD</a></li>
  </ul>
</p>

<?php
  //Afficher la partie basse
  $this->load->view('includes/partie_basse.php');
?>
