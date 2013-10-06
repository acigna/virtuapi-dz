<?php
  //Récupérer la libririe OMS, et afficher la partie haute
  $this->load->library('oms');
  $this->oms->partie_haute("Modération du contenu de l'université virtuelle");
?>

 <h2 style="text-align:center;">Modération de contenus</h2>	        
   <h4>Voici la liste des spécialités que vous pouvez modérer son contenu:</h4>
       <p  style="text-align:center;">
		 <?php
		   foreach($sModerees as $sModeree )
		   {
		 ?>
	           <a href=' <?php echo site_url("admin/moderation_specialite/{$sModeree['id']}"); ?> ' ><?=stripslashes($sModeree['nom']); ?></a><br/>		 <?php 
		   }			 
		 ?>
	</p>

<?php
  //Afficher la partie basse
  $this->oms->partie_basse();
?>    
