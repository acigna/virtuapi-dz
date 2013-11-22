<?php
  //Charger le helper url
  $this->load->helper('url');
  
  //Récupérer la libririe OMS, et afficher la partie haute
  $this->load->library('oms');
  $this->oms->partie_haute("Création d'un contenu pour les Cours", array(), array( base_url()."ajax/ajax.js" ));
?>

<h2 class="center">Création d'un contenu pour les Cours</h2>
<?php
	echo validation_errors();
?>
<form method="POST"  enctype="multipart/form-data" class="form">	
  <table>
    <tr>
      <td class="right"><label for="NomAnnee">Année:</label></td>
      <td class="left">
        <select id="NomAnnee" onchange="javascript:lancer_module('<?=site_url( array('ajax', 'module') ); ?>'+this.options[this.selectedIndex].value, 
   		          new Array('NomModule','<?=site_url( array('ajax', 'chapitre'); ?>', 'NomChapitre', true));">
        <?php
          foreach( $specialites as $specialite ) {  
        ?>
          <optgroup label='<?=stripslashes($specialite['nom']); ?>'>
          <?php
            foreach($specialite['annees'] as $annee) {
                $selected = $default['annee'] == $annee['id'] ? 'selected' : '';        
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
      <td class="right"><label for="NomModule">Module:</label></td>  
      <td class="left">   
        <select id="NomModule" onchange="javascript:lancer_chapitre('<?=site_url( array("ajax", "chapitre") ); ?'+this.options[this.selectedIndex].value,'NomChapitre');">  	      		
        <?php
          foreach($modules as $module) { 
              $selected = $default['module'] == $module['id'] ? 'selected' : ''; 
        ?>
          <option value='<?=$module['id']; ?>' <?=$selected; ?>><?=$module['nom']; ?></option>
        <?php
          }
        ?>
        </select>
      </td> 
    </tr>
	
	<tr>
      <td class="right"><label for="IdChapitre">Chapitre:</label></td>  
      <td class="left">
        <select name="IdChapitre" id="NomChapitre"> 
        <?php
          foreach( $chapitres as $chapitre ) {
              $selected = $default['chapitre'] == $chapitre['id'] ? 'selected' : '' ;
        ?>
	      <option value='<?=$chapitre['id']; ?>' <?=$selected; ?>><?=$chapitre['num']; ?> : <?=$chapitre['nom']; ?></option>
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
  <div class="center">
    <label><input type="radio" name="Type" <?=set_radio('Type', 'Resume'); ?> value="Resume"/>Résumé de cours</label>
    <label><input type="radio" name="Type" <?=set_radio('Type', 'Complet'); ?> value="Complet"/>Cours complet</label><br/><br/>
  </div>
  <fieldset class="noborder">
    <legend><h4>Chemin du contenu(1Mo max):</h4></legend>
    <input type="file" name="Cours" />
  </fieldset><br/>
  <label for="code"><?=$captcha ?>?</label>
  <input type="text" name="code" id="code" /><br/><br/><br/>
  <div class="center"><input type="submit" name="cours_publier" value="  Publier  " /></div>
</form>

<?php
  //Afficher la partie basse
  $this->load->view('includes/partie_basse.php');
?>
