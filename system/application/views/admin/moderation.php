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
