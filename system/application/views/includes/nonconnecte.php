<?php
  //Récupérer la libririe OMS, et afficher la partie haute
  $this->load->library('oms');
  $this->load->helper('url');
  $this->oms->partie_haute("Accès non autorisé", array(base_url()."css/acc_error.css"));
?>

<p class="center"><img src="<?=base_url();?>images/acces_interdit.png" alt="Accés interdit à cette partie"/>
</p>
<p class="message">Désolé, mais cette page est réservée uniquement aux membres du Portail. Si vous poussedez déjâ un compte, vueillez vous identifier en utilisant le <a href="#login">formulaire à gauche</a>. Sinon,
    vous devez vous s'inscrire en <a href="<?=site_url( array( 'membre', 'inscription' ) );?>">cliquant içi</a>.</p>

<?php
  //Afficher la partie basse
  $this->load->view('includes/partie_basse.php');
?>
