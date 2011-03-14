<h2 style='text-align:center;'>Liste de contenus de sujets d'examens à  modérer pour la spécialité <?=stripslashes($specialite); ?></h2>
<div style="text-align:center;"><br/><strong style="color:green;"><?=$notification;?></strong></div>

  <p>
	    <table>
         	 <tr>
		   <th>Publié Par</th>
		   <th>Publié Le</th>
		   <th>Nouvelle Version</th>
		   <th>Année</th>
		   <th>Type d'examen</th>
		   <th>Module</th>
		   <th>Année universitaire</th>
		   <th>N° Sujet</th>
		   <th>Type</th>
		   <th>Actions</th>
		 </tr>
		 
		 <?php
		    foreach($sujetsMod as $sujet)
		    {
		 ?>
		       <tr>
		          <td style="text-align:center;"><?=$sujet->pseudo;?></td>
			  <td style="text-align:center;"><?=date('d/m/Y à H:i',$sujet->timestampmoderation);?></td>
			  <td style="text-align:center;"><?=$sujet->nouvelleversion ? "Oui" : "Non" ;?></td>
			  <td style="text-align:center;"><?=stripslashes($sujet->nomannee); ?></td>
			  <td style="text-align:center;"><?=stripslashes($sujet->typeexam); ?></td>
			  <td style="text-align:center;"><?=stripslashes($sujet->nommodule); ?></td>
			  <td style="text-align:center;"><?=$sujet->anneeuniv; ?></td>
			  <td style="text-align:center;"><?=$sujet->numsujet; ?></td>
			  <td style="text-align:center;"><?=$sujet->type; ?></td>
			  
			  <td style="text-align:center;">
			  <?php
				if(!$sujet->nouvelleversion) 
				{
			  ?> 
				<a style="text-align:center;" href="<?=base_url()."temp/Sujet{$sujet->id}.{$sujet->typefichier}"?>"><input type="button" value="  voir  "/></a>
			  <?php  
			        }else{
			  ?> 
			        <a style="text-align:center;" href="<?=base_url()."temp/Sujet{$sujet->id}.{$sujet->typefichier}"?>"><input type="button" value="  voir la nouvelle version  "/></a>
				<a style="text-align:center;" href="<?=base_url()."contenus/Sujet{$sujet->sujetcible->id}.{$sujet->sujetcible->typefichier}"?>"><input type="button" value="  voir l'ancienne version  "/></a>
			  <?php
			       }
			  ?> 
			  
			           <form method="POST">
                     		     <p style="text-align:center;">
					  <input type="hidden" name="cible" value="<?=$sujet->id; ?>" />
					  <input type="hidden" name="action" value="valider" />
					  <input type="submit" value="Valider"/> 
				     </p>
				   </form>
				   <form method="POST">
                    		     <p style="text-align:center;"> 
					 <input type="hidden" name="cible" value="<?=$sujet->id; ?>" />
					 <input type="hidden" name="action" value="refuser" />
					 <input type="submit" value="Refuser"/> 
				     </p>
				   </form>
			  </td>
		       </tr>
		       	
	         <?php
	            }
	         ?> 
	   </table>
	   
  </p>	   	 
