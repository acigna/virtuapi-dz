<?php
  //Récupérer la libririe OMS, et afficher la partie haute
  $this->load->library('oms');
  $this->oms->partie_haute("Gestion des spécialités, années, modules et chapitres");
?>

<!-- Les requêtes AJAX --> 

<script type="text/javascript" src="<?php echo base_url(); ?>ajax/ajax.js"></script>

<h2 style="text-align:center;">Page de gestion des spécialités,années,modules et chapitres</h2><br/><h3 style="text-align:center;" id="specialite">Spécialités:</h3>
<div style="text-align:center;"><br/><strong style="color:<?php if($type_notif_spec=='error') echo 'red'; else echo 'green'; ?>;"><?=$notification_specialite;?></strong></div>

<form method="POST" action="#specialite">
  <p> 
   <fieldset>
  	<legend>Ajouter une spécialité</legend>
   	<div style="text-align:center;">
   	<br/>
   	<label for="NomSpecialite0">Nom de la spécialité:</label><input id="NomSpecialite0" type="text" name="specialite" />
   	<br/><br/>
  	<input type="hidden" name="action" value="ajout"/>
   	<input type="hidden" name="cible" value="specialite"/>
   	<input type="submit" value="Ajouter cette spécialité"/>
   	</div>
        <br/>
   </fieldset>
   <br/>
  </p></form>


<form method="POST" action="#specialite">
      <p>
	  <fieldset>
	  <legend>Supprimer une spécialité</legend>	  
   	  <div style="text-align:center;">
	  <label><br/>
	  Liste des spécialités:  
  	  <select name="specialite">
  	  <?php
  	    foreach($specialites as $specialite)
  	    {
  	  ?>
  	     <option value="<?=$specialite['id'];?>"><?=stripslashes($specialite['nom']);?></option>
  	  <?php
  	    }
  	  ?>
  	  </select>
	  </label>
	  <br/><br/>
	   <input type="hidden" name="action" value="supp"/>
	   <input type="hidden" name="cible" value="specialite"/>
	   <input type="submit" value="Supprimer cette spécialité"/>
	   <br/><br/>
	  </div>
	  </fieldset>
	  <br/>
     </p></form>

<h3 style="text-align:center;" id="annees">Années:</h3>

<div style="text-align:center;"><br/><strong style="color:<?php if($type_notif_annee=='error') echo 'red'; else echo 'green'; ?>;"><?=$notification_annee;?></strong></div>

<form method="POST" action="#annees">
      <p>  
	  <fieldset>
	  <legend>Ajouter une année</legend><br/>
	  <div style="text-align:center;">
	   <table style="border:none;">
 	   	<tr>
	   		 <td style="text-align:right;border:none;"><label for="NomAnnee">Nom de l'année:</label></td>
	    		 <td style="text-align:left;border:none;"><input id="NomAnnee" type="text" name="annee" /></td>
	   	</tr>    
        	
        	<tr>
             		<td style="text-align:right;border:none;"><label for="NomSpecialite">Dans la spécialité:</label></td>  
  	     		<td style="text-align:left;border:none;">
			  <select name="specialite" id="NomSpecialite"> 
			  <?php
  	    		  	foreach($specialites as $specialite)
  	   		  	{
  	  		  ?>
  	     				<option value="<?=$specialite['id'];?>"><?=stripslashes($specialite['nom']);?></option>
  	 		  <?php
  	    			}
  	  	  	  ?>
	          	  </select>
	     		</td>     
		</tr>
	    </table>
	<br/>
   	<input type="hidden" name="action" value="ajout"/>
    	<input type="hidden" name="cible" value="annee"/>
    	<input type="submit" value="Ajouter cette année"/>
	<br/><br/>
    </div>
   </fieldset>
    <br/>
   </p></form>


<form method="POST" action="#annees">
  <p>  
     <fieldset>
       <legend>Supprimer une année</legend>
        <div style="text-align:center;">
		<br/>
		<td style="text-align:right;border:none;"><label for="NomAnnee0">Liste des années:</label></td>
		<td style="text-align:left;border:none;">
  		<select id="NomAnnee0" name="annee"> 
  		<?php
  		  foreach($annees as $specialite)
  		  {  		
  		?>
  		   <optgroup label="<?=stripslashes($specialite['nom']);?>">
  		   <?php
  		     foreach($specialite['annees'] as $annee)
  		     {
  		   ?>
  		     <option value="<?=$annee['id'];?>"><?=stripslashes($annee['nom']);?></option>
  		   <?php
  		     }
  		   ?>
  		   
  		   </optgroup>
  		<?php
  		  }
  		?>
		</select>
		</td>
		<br/><br/>
		<input type="hidden" name="action" value="supp"/>
		<input type="hidden" name="cible" value="annee"/>
    		<input type="submit" value="Supprimer cette année"/>
	</div>
	<br/>
   </fieldset>
   <br/>
  </p></form>   


<h3 style="text-align:center;" id="modules">Modules:</h3>

<div style="text-align:center;"><br/><strong style="color:<?php if($type_notif_module=='error') echo 'red'; else echo 'green'; ?>;"><?=$notification_module;?></strong></div>

<form method="POST" action="#modules">
     <p>
	  <fieldset>
	   <legend>Ajouter un module</legend><br/>
	   <div style="text-align:center;">
	   <table style="border:none;">
	    <tr>
		 <td style="text-align:right;border:none;"><label for="NomModule4">Nom du module:</label></td>
		 <td style="text-align:left;border:none;"><input id="NomModule4" type="text" name="module" /></td>
        </tr>
	    <tr> 
	     <td style="text-align:right;border:none;"><label for="NomAnnee4">Dans l'année:</label></td>  
  	     <td style="text-align:left;border:none;">
		 <select id="NomAnnee4" name="annee"> 
	         <?php
  		    foreach($annees as $specialite)
  		    {  		
  		  ?>
  		   <optgroup label="<?=stripslashes($specialite['nom']);?>">
  		     <?php
  		       foreach($specialite['annees'] as $annee)
  		       {
  		     ?>
  		     <option value="<?=$annee['id'];?>"><?=stripslashes($annee['nom']);?></option>
  		     <?php
  		       }
  		     ?>
  		   </optgroup>
  		<?php
  		  }
  		?>
	    	</select>
	    </tr>
	    </table>
	   <br/>
	  <input type="hidden" name="action" value="ajout"/>
	  <input type="hidden" name="cible" value="module"/>
	  <input type="submit" value="Ajouter ce module"/><br/><br/>
      </div>
	  </fieldset>
	  <br/>
      </p>	
	</form>  



<form method="POST" action="#modules">
      <p>  
	  <fieldset>
	  <legend>Supprimer un module</legend>
	  <div style="text-align:center;">
	  <table style="border:none;">
	    <tr>
		 <td style="text-align:right;border:none;"><label for="NomAnnee1">Liste des années:</label></td>  
  	     	 <td style="text-align:left;border:none;">
		 <select  id="NomAnnee1" onchange="javascript:lancer_module('<?php echo base_url(); ?>index.php/ajax/module/'+this.options[this.selectedIndex].value, 
   		          new Array('NomModule1','','',false));">
	     	 <?php
  		    foreach($annees as $specialite)
  		    {  		
  		 ?>
  		    <optgroup label="<?=stripslashes($specialite['nom']);?>">
  		     <?php
  		       foreach($specialite['annees'] as $annee)
  		       {
  		     ?>
  		        <option value="<?=$annee['id'];?>"><?=stripslashes($annee['nom']);?></option>
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
		   <td style="text-align:right;border:none;"><label for="NomModule1">Liste des modules:</label></td>  
  	           <td style="text-align:left;border:none;"> 
			<select id="NomModule1" name="module">
			<?php
			   foreach($modules as $module)
			   {
			?>
				<option value="<?=$module['id']; ?>"><?=$module['nom']; ?></option>			
			<?php
			   }
			?>
	        	</select>
		   </td> 
         </tr> 
       </table> 	   
	   <input type="hidden" name="action" value="supp"/>
	   <input type="hidden" name="cible" value="module"/>
	   <input type="submit" value="Supprimer ce module"/><br/><br/>
	  </fieldset>
	  <br/>
	  </p>
</form>


<h3 style="text-align:center;" id="chapitres">Chapitres:</h3>
	 
	 <div style="text-align:center;"><br/><strong style="color:<?php if($type_notif_chapitre=='error') echo 'red'; else echo 'green'; ?>;"><?=$notification_chapitre;?></strong></div>

	 
	 <form method="POST" action="#chapitres">
         <p>
	  <fieldset>
	   <legend>Ajouter un chapitre</legend><br/>
	   <div style="text-align:center;">
	   <table style="border:none;">
	    <tr>
	       <td style="text-align:right;border:none;"><label for="NumChapitre">Numéro du chapitre:</label></td>
		   <td style="text-align:left;border:none;"><input id="NumChapitre" type="text" name="num" /></td>
	    </tr>
		
	    <tr>
	     <td style="text-align:right;border:none;"><label for="NomChapitre4">Nom du chapitre:</label></td>
	     <td style="text-align:left;border:none;"><input id="NomChapitre4" type="text" name="nom" /></td>
        </tr>
	   
	    <tr>
	      <td style="text-align:right;border:none;"><label for="NomAnnee3">Dans l'année:</label></td>  
		  <td style="text-align:left;border:none;">
 		   <select  id="NomAnnee3" onchange="javascript:lancer_module('<?php echo base_url(); ?>index.php/ajax/module/'+this.options[this.selectedIndex].value, new Array('NomModule3','','',false));"> 
	           <?php
  		    foreach($annees as $specialite)
  		    {  		
  		   ?>
  		    <optgroup label="<?=stripslashes($specialite['nom']);?>">
  		     <?php
  		       foreach($specialite['annees'] as $annee)
  		       {
  		     ?>
  		     <option value="<?=$annee['id'];?>"><?=stripslashes($annee['nom']);?></option>
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
	      <td style="text-align:right;border:none;"><label for="NomModule3">Du module:</label></td>  
  	      <td style="text-align:left;border:none;">
		   <select id="NomModule3" name="module" >
		   <?php
			foreach($modules as $module)
			{
		   ?>
			  <option value="<?=$module['id']; ?>"><?=$module['nom']; ?></option>			
		   <?php
		        }
		   ?> 
	           </select>
	      </td>
          </tr>

	   </table><br/>
	    <input type="hidden" name="action" value="ajout"/>
	    <input type="hidden" name="cible" value="chapitre"/>
	    <input type="submit" value="Ajouter ce chapitre"/>
	   </div><br/>
	  </fieldset>
	  </p>
	 </form>	 
    
     <form method="POST" action="#chapitres">
      <p> 
	 <fieldset>
     	 <legend>Supprimer un chapitre</legend><br/>
	 <div style="text-align:center;">
	 <table style="border:none;">
	  <tr>
           <td style="text-align:right;border:none;"><label for="NomAnnee2">Liste des années:</label></td>
	   <td style="text-align:left;border:none;">
  	     <select name="NomAnnee" id="NomAnnee2" onchange="javascript:lancer_module('<?php echo base_url(); ?>index.php/ajax/module/'+this.options[this.selectedIndex].value, new Array('NomModule2','<?php echo base_url(); ?>index.php/ajax/chapitre/','NomChapitre',true));"> 
	      <?php
  		    foreach($annees as $specialite)
  		    {  		
  		   ?>
  		    <optgroup label="<?=stripslashes($specialite['nom']);?>">
  		     <?php
  		       foreach($specialite['annees'] as $annee)
  		       {
  		     ?>
  		     <option value="<?=$annee['id'];?>"><?=stripslashes($annee['nom']);?></option>
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
	  <td style="text-align:right;border:none;"><label for="NomModule2">Liste des modules:</label></td>  
	  <td style="text-align:left;border:none;">
	   <select name="NomModule" id="NomModule2" onchange="javascript:lancer_chapitre('<?php echo base_url(); ?>index.php/ajax/chapitre/'+this.options[this.selectedIndex].value,'NomChapitre');">
	   <?php
		foreach($modules as $module)
		{
	    ?>
			  <option value="<?=$module['id']; ?>"><?=$module['nom']; ?></option>			
	    <?php
		}
	    ?> 
	   </select>
      	  </td> 
	 </tr>  
	    
	  <tr>
	   <td style="text-align:right;border:none;"><label for="NomChapitre">Liste des chapitres:</label></td>  
  	   <td style="text-align:left;border:none;">
	   <select name="chapitre" id="NomChapitre">
	   <?php
	       foreach($chapitres as $chapitre)
	       {
	   ?> 
	        	<option value="<?=$chapitre['id']; ?>"><?=$chapitre['num'];?> : <?=stripslashes($chapitre['nom']);?></option>
	   <?php
	       }
	   ?>
	    </select>
       	   </td>
	  </tr>
	 
	  </table><br/> 
	   <input type="hidden" name="action" value="supp"/>
	   <input type="hidden" name="cible" value="chapitre"/>
	   <input type="submit" value="Supprimer ce chapitre"/>
	   </div><br/>
	 </fieldset>
	  <br/>
     </p>
	 </form>
	 
<?php
  //Afficher la partie basse
  $this->load->view('includes/partie_basse.php');
?>    

