<?php
  //Récupérer la libririe OMS, et afficher la partie haute
  $this->load->library('oms');
  $this->oms->partie_haute("La modération de ce contenu n'est pas autorisé");
?>

<p style="text-align:center;"><img src="<?php echo base_url(); ?>images/acces_interdit.png" alt="Accés interdit à cette partie"/>
</p>
<p style="text-align:center; font-size:15px;">Désolé, Vous n'étez pas autorisé à modérer ce contenu.</p>

<?php
  //Afficher la partie basse
  $this->oms->partie_basse();
?>
