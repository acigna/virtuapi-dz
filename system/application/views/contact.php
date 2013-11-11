<?php
  //Récupérer la libririe OMS, et afficher la partie haute
  $this->load->library('oms');
  $this->load->helper('url');
  $this->oms->partie_haute("Contactez-nous", array(base_url()."css/contact.css"));
?>
<h2 class="center">Contactez-nous</h2><br/>
<div class="article">
<p>Vous avez une proposition ou une suggestion ? Ou vous voulez intégrer l'équipe d'Acigna VirtUAPI-DZ ?</p>
<p>Toute l'équipe de VirtUAPI-DZ est à votre écoute. Veuillez nous contacter par email à l'adresse:    <strong>contact[arobase]acigna[point]com</strong>.</p>  
</div>
	 
<?php
  //Afficher la partie basse
  $this->load->view('includes/partie_basse.php');
?>
	  
	 
         
          	
	 

	
