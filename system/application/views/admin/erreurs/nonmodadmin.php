<?php
  //Récupérer la libririe OMS, et afficher la partie haute
  $this->load->library('oms');
  $this->oms->partie_haute("Page strictement réservée aux modérateurs ou aux administrateurs");
?>

<p style="text-align:center;"><img src="<?php echo base_url(); ?>images/acces_interdit.png" alt="Accés interdit à cette partie"/>
</p>
<p style="font-size:15px;text-align:center;">Désolé, mais cette page est strictement réservée aux modérateurs ou aux administrateurs.</p>

<?php
  //Afficher la partie basse
  $this->load->view('includes/partie_basse.php');
?>
