<?php
  //Récupérer la libririe OMS, et afficher la partie haute
  $this->load->library('oms');
  $this->oms->partie_haute("L'université virtuelle");
?>


<h2 style="text-align:center">Bienvenu dans l'université virtuelle</h2>
    
	 <p style="text-indent: 25px;">L'université virtuelle vous permet de consulter ou de publier 
	 du contenus diverses de Cours,TP,TD ou Sujets d'examens. Elle est composée d'ensemble de 
     spécialités. Chaque spécialité est composée de plusieurs années.Une année est composée de modules.
     Et chaque module est composé de plusieurs chapitres.	
  	 </p>
 	 
	 <p style="text-indent: 25px;"> Pour publier du contenus, veuillez choisir le type de contenu
     dans <a href="#Publication">Publier du contenus</a> à gauche. Pour consulter du contenus,
     veuillez choisir la spécialité concernée et le type de contenu à consulter dans 
     <a href="#Consultation">Consulter du contenus</a> à gauche. 	 
	 </p>
	
	 <p style="text-indent: 25px;"> Il se peut que la spécialité ou l'année que vous cherchez
     ne figure dans la liste des spécialités. Dans ce cas, vous pouvez nous contacter et
     être partenaire du portail en utilisant le formulaire de 'Contactez-nous'. <a href="./../index.php/contact">Cliquez içi</a> pour
     y accédez.	
	 </p>

<?php
  //Afficher la partie basse
  $this->oms->partie_basse();
?> 
	
