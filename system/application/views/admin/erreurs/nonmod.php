<?php
  //Récupérer la libririe OMS, et afficher la partie haute
  $this->load->library('oms');
  $this->oms->partie_haute("Page strictement reservée aux modérateurs");
?>

<p style="text-align:center;"><img src="<?php echo base_url(); ?>images/acces_interdit.png" alt="Accés interdit à cette partie"/>
</p>
<p style="font-size:15px;text-align:center;">Désolé, mais cette page est strictement réservée aux modérateurs.</p>

<?php
  //Afficher la partie basse
  $this->oms->partie_basse();
?>
