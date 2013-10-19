<?php
  //Récupérer la libririe OMS, et afficher la partie haute
  $this->load->library('oms');
  $this->oms->partie_haute("Gérer les modérateurs");
?>

<h2 style="text-align:center;">Gestion des modérateurs</h2><br/>
		<?php
			if($notification_ajout)
			{
		?>
				<p style="text-align:center;color:green;"><?=$notification_ajout;?></p>
		<?php
			}
		?>
		
		<?php
			if($erreur_ajout)
			{
		?>
				<p style="text-align:center;color:red;"><?=$erreur_ajout;?></p>
		<?php
			}
		?>
		
		<?php
			if($notification_supp)
			{
		?>
				<p style="text-align:center;color:green;"><?=$notification_supp;?></p>
		<?php
			}
		?>
		
		<form method="POST">
                     <fieldset>
					  <legend>Ajouter un modérateur</legend>
					  <p>
                        <table style="border:none;"> 
						  <input type="hidden" name="action" value="ajout" />
                          
						  <tr> 
						    <td style="text-align:right;border:none;"><label for="nomMod">Pseudo du modérateur:</label></td>
						    <td style="text-align:left;border:none;"><input type="text" name="nomMod"/></td>
						  </tr>
                          
						  <tr>
						    <td style="text-align:right;border:none;"><label  for="idS">Contenu à modérer:</label></td>
						    <td style="text-align:left;border:none;">
						      <select name="idS">
                                                      <?php
                                                        foreach($specialites as $specialite)
                                                        {
                                                      ?>
                                                         <option value='<?=$specialite["id"];?>'><?=stripslashes($specialite["nom"]);?></option>
                                                      <?php
                                                       	}
                                                      ?>
                                                      </select>
						    </td>
                                                  </tr>
                         </table>                        
						 <br/>
						 <div style="text-align:center"><input type="submit" value="Ajouter ce modérateur" /></div><br/>
					 </p>
					 </fieldset> 
					 
					 
                    </form>
                    
                    <h3 style="text-align:center;">Liste des modérateurs:</h3><br/>
    <div align="center">                   
      <table style="align:center;">
       <tr>
         <th>Nom du modérateur</th>
         <th>contenu à modérer</th>
         <th>Actions</th>
       </tr>
       <?php
         foreach($moderateurs as $moderateur)
         {
       ?>
       <tr>
       	 <td><?=$moderateur['nom']; ?></td>
         <td><?=stripslashes($moderateur['noms']); ?></td>
         <td><form method="POST"><p><input type="hidden"   name="action" value="supp" /><br/><input type="submit" value="Supprimer"/><input type="hidden" name="id" value="<?=$moderateur['idm']; ?>"/></p></form></td>
       </tr>
       <?php
         }
       ?>
      </table> <br/>
    </div> 
    
<?php
  //Afficher la partie basse
  $this->load->view('includes/partie_basse.php');
?>
