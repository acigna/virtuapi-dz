<?php
  //Récupérer la libririe OMS, et afficher la partie haute
  $this->load->library('oms');
  $this->oms->partie_haute("Page de modération des sujets de la spécialité $specialite");
?>

<script type="text/javascript" src="<?php echo base_url(); ?>ajax/ajax.js"></script>

<h2 style="text-align:center;">Création d'un contenu pour les Cours</h2>
<?php
	echo validation_errors();
?>
<form method="POST"  enctype="multipart/form-data">	<p>
	<table style="border:none;">
	<tr>
	
		<td style="text-align:right;border:none;"><label for="NomAnnee">Année:</label></td>
   		<td style="text-align:left;border:none;">
   		   <select id="NomAnnee" onchange="javascript:lancer_module('<?php echo base_url(); ?>index.php/ajax/module/'+this.options[this.selectedIndex].value, 
   		          new Array('NomModule','<?php echo base_url(); ?>index.php/ajax/chapitre/','NomChapitre',true));">
   		 	<?php
   		 	  foreach($specialites as $specialite)
   		 	  {  
   		 	?>
   		 	  <optgroup label='<?=stripslashes($specialite['nom']); ?>'>
   		 	   <?php
   		 	     foreach($specialite['annees'] as $annee)
   		 	     {
   		 	       if($default['annee']==$annee['id'])
   		 	        $selected='selected';
   		 	       else
   		 	        $selected=''; 
   		 	       
   		 	   ?>
   		 	     
   		 	     <option value='<?=$annee['id']; ?>' <?=$selected; ?>/><?=stripslashes($annee['nom']); ?></option>
   		 	   <?php
   		 	     }
   		 	   ?>   	
   		 	   
   		 	   </optgroup>	 	       
   		 	<?php
   		 	
   		 	  }
   		 	?>
   		 	</select>
   		</td>
	</tr>
	
	<tr>
		<td style="text-align:right;border:none;"><label for="NomModule">Module:</label></td>  
  		<td style="text-align:left;border:none;">   
  	      		<select id="NomModule" onchange="javascript:lancer_chapitre('<?php echo base_url(); ?>index.php/ajax/chapitre/'+this.options[this.selectedIndex].value,'NomChapitre');">  	      		
	      		<?php
	      		  foreach($modules as $module)
	      		  {
	      		      if($default['module']==$module['id'])
   		 	        $selected='selected';
   		 	       else
   		 	        $selected=''; 
   		 	       
	      		?>
	      		  <option value='<?php echo $module['id']; ?>' <?php echo $selected; ?>><?php echo $module['nom']; ?></option>
	      		<?php
	      		   }
	      		?>
	      		</select>
       		</td> 
	</tr>
	
	<tr>
		  <td style="text-align:right;border:none;"><label for="IdChapitre">Chapitre:</label></td>  
  	   	 <td style="text-align:left;border:none;">
 		 	<select name="IdChapitre" id="NomChapitre"> 
		        <?php
	      		  foreach($chapitres as $chapitre)
	      		  {
	      		  
	      		    if($default['chapitre']==$chapitre['id'])
   		 	        $selected='selected';
   		 	       else
   		 	        $selected=''; 
	      		?>
	      		  <option value='<?=$chapitre['id']; ?>' <?php echo $selected; ?>><?php echo $chapitre['num']; ?> : <?php echo $chapitre['nom']; ?></option>
	      		
	      		<?php
	      		   }
	      		?>
		        </select>
                 </td>
	</tr>
	
	<tr>
		
	</tr>
	</table><br/>
	
	<h4>Type de contenu :</h4>
	<div style="text-align:center;">
	     <label><input type="radio" name="Type" <?php echo set_radio('Type', 'Resume'); ?> value="Resume"/>Résumé de cours</label>
	     <label><input type="radio" name="Type" <?php echo set_radio('Type', 'Complet'); ?> value="Complet"/>Cours complet</label><br/><br/>
	</div>
	<fieldset style="border:none;">
		  <legend><h4>Chemin du contenu(1Mo max):</h4></legend>
		 <input type="file" name="Cours" />
        </fieldset><br/>
         <label for="code"><?=$captcha ?>?</label>
         <input type="text" name="code" id="code" /><br/><br/><br/>
	 <div style="text-align:center;"><input type="submit" name="cours_publier" value="  Publier  " /></div>
	
	</p>
</form>

<?php
  //Afficher la partie basse
  $this->load->view('includes/partie_basse.php');
?>
