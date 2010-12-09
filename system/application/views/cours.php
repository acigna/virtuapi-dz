<h2 style="text-align:center;">Cours de <?php echo $nomannee; ?> classés par module</h2><p></p>

<?php 
 foreach($cours as $module) 
 { 
?>
      
  <h3><?php echo stripslashes($module['nom']) ; ?></h3>
  <ul>
  <?php
     foreach($module['chapitres'] as $chapitre)
     {
  ?>
     <li><h4>Chapitre <?php echo $chapitre['num']; ?>: <?php echo stripslashes($chapitre['nom']);  ?></h4></li>
     	<?php
     	  foreach($chapitre['contenus'] as $contenu)
     	  {
      	?>
      	   <ul>
      	     <li>
      	     		<a href='./../../../contenus/Cours<?php echo $contenu['id'] ; ?>.<?php echo $contenu['typefichier'] ; ?>'>
      	                <?php
      	                  if($contenu['type']=='Complet')
      	                   echo 'Le cours complet';
      	                  else 
      	                   echo 'Le résumé du cours'; 
      	                ?>  
      	     		</a><br/>
      	     		Publié par: <?php echo $contenu['publiant']; ?><br/>
      	     		Publié le:  <?php echo date('d/m/Y à H\h:i\m\n',$contenu['pub']); ?><br/>
      	     		derniére modification le: <?php echo date('d/m/Y à H\h:i\m\n',$contenu['dernmodif']); ?> <br/>
      	     		type de fichier: <br/>
      	     		
      	     </li>
      	   
      	   </ul>
      	   <p></p>
      	
      	
      	<?php
      	  }      	  
      	?>
  <?php          
     }
  ?>
  </ul>    
      
<?php 

 }
?>      
