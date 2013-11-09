<?php
  //Récupérer la libririe OMS, et afficher la partie haute
  $this->load->library('oms');
  $this->oms->partie_haute("Contactez-nous");
?>
	 <h2 style="text-align:center;">Contactez-nous</h2><br/>
	 <p style="font-size:150%; color:black; text-indent: 30px;">
       Devenir partenaire du portail? Proposer une nouvelle spécialité, ou année?
       une simple suggestion, ou pour autre chose? 
	  </p>
      <p style="font-size:150%; color:black; text-indent: 30px;">
	   Toute l'équipe de VirtUAPI-DZ est à votre écoute. Veuillez nous contacter par email à l'adresse:    <strong>contact[arobase]acigna[point]com</strong>. 
	 </p>  
	 
<?php
  //Afficher la partie basse
  $this->load->view('includes/partie_basse.php');
?>
	  
	 
         
          	
	 

	
