    <h2 style='text-align:center;'>Liste de contenus de cours à modérer pour la spécialité <?=stripslashes($specialite);?></h2>
    <div style="text-align:center;"><br/><strong style="color:green;"><?=$notification;?></strong></div>	
	         <p> 
			   <table>
			    <tr>
				 <th style="text-align:center;">Publié Par</th>
				 <th style="text-align:center;">Publié Le</th>
				 <th style="text-align:center;">Nouvelle Version</th>
				 <th style="text-align:center;">Année</th>
				 <th style="text-align:center;">Module</th>
				 <th style="text-align:center;">Chapitre</th>
				 <th style="text-align:center;">Type</th>
				 <th style="text-align:center;">Actions</th>
			     </tr> 
				
				<?php
				  foreach($coursMod as $cours)
				  {
				?>
				 <tr>
				  <td style="text-align:center;"><?=$cours->pseudo;?></td>
				  <td style="text-align:center;"><?=date('d/m/Y à H:i',$cours->timestampmoderation);?></td>
				  <td style="text-align:center;"><?=$cours->nouvelleversion ? "Oui" : "Non" ;?></td>
				  <td style="text-align:center;"><?=stripslashes($cours->nomannee); ?></td>
				  <td style="text-align:center;"><?=stripslashes($cours->nommodule); ?></td>
				  <td style="text-align:center;"><?=$cours->numchapitre.":".$cours->nomchapitre; ?></td>
				  <td style="text-align:center;"><?=$cours->type; ?></td>
				  <td style="text-align:center;">
				  <?php
				    if(!$cours->nouvelleversion) 
				    {
				  ?> 
				     <a style="text-align:center;" href="<?=base_url()."temp/Cours{$cours->id}.{$cours->typefichier}"?>"><input type="button" value="  voir  "/></a>
				  <?php  
				    }else{
				  ?> 
				  <a style="text-align:center;" href="<?=base_url()."temp/Cours{$cours->id}.{$cours->typefichier}"?>"><input type="button" value="voir la nouvelle version"/></a>
                     <a style="text-align:center;" href="<?=base_url()."contenus/Cours{$cours->courscible->id}.{$cours->courscible->typefichier}"?>"><input type="button" value="voir l'ancienne version"/></a>  
				  <?php
				    
				    }
				  ?>
				  <form method="POST">
                     		     <p style="text-align:center;">
					  <input type="hidden" name="cible" value="<?=$cours->id; ?>" />
					  <input type="hidden" name="action" value="valider" />
					  <input type="submit" value="Valider"/> 
				     </p>
				   </form>
				   <form method="POST">
                    		     <p style="text-align:center;"> 
					 <input type="hidden" name="cible" value="<?=$cours->id; ?>" />
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
	  </div>
