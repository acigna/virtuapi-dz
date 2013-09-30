<?php
  //Récupérer l'instance de CI, et afficher la partie haute
  $CI = & get_instance();
  $CI->load->library('oms');
  $this->oms->partie_haute("Cours publié avec succès");
?>

<h2 style="text-align:center;">Votre contenu de Cours a été envoyé avec succés</h2>
<p>
Avant que votre contenu soit publié,un modérateur du portail analysera votre contenu et déterminera s'il est conforme ou non. Nous vous remercions
pour votre contribution au contenu du portail VirtUAPI-DZ.<br/>
<h4>Que faire maintenant?</h4>
  <ul>
    <li><a href="">Publier un autre Cours</a><br/></li>
    <li><a href="./../../index.php/universite_virtuelle">Aller vers l'université virtuelle</a></li>
    <li><a href="./../../">Aller vers la page d'acceuil</a></li>
    <li><a href="./../../index.php/sujets/publier">Publier un sujet ou une solution d'un sujet d'examen</a></li>
    <li><a href="./../../index.php/td/publier">Publier une série ou une solution d'un TD</a></li>
  </ul>
</p>

<?php
  //Afficher la partie basse
  $CI->oms->partie_basse();
?>
