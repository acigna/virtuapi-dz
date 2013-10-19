<?php
  //Récupérer la libririe OMS, et afficher la partie haute
  $this->load->library('oms');
  $this->oms->partie_haute("Accès non autorisé");
?>

<p style="text-align:center;"><img src="<?php echo base_url(); ?>images/acces_interdit.png" alt="Accés interdit à cette partie"/>
</p>
<p style="font-size:15px;">Désolé, mais cette page est réservée uniquement aux membres du Portail. Si vous poussedez déjâ un compte, vueillez vous identifier en utilisant le <a href="#login">formulaire à gauche</a>. Sinon,
    vous devez vous s'inscrire en <a href="<?php echo base_url(); ?>index.php/inscription">cliquant içi</a>.</p>

<?php
  //Afficher la partie basse
  $this->load->view('includes/partie_basse.php');
?>
