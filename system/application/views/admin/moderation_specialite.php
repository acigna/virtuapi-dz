<?php
  //Récupérer la libririe OMS, et afficher la partie haute
  $this->load->library('oms');
  $this->oms->partie_haute("Page de modération de contenus");
?>

<div id="colTwo" >
            <h2 style="text-align:center;">Modération de contenus pour la spécialité <?=stripslashes($specialite);?></h2>
            <table style="border:none;margin-left:250px;">
		
		<tr>
			<td style="text-align:center;border:none;"><a href=' <?php echo site_url("admin/moderer_cours/$id"); ?> '>Cours</a></td>
			<td style="text-align:left;border:none;">
			<?php
			 if($nbr_cours!=0)
			  if($nbr_cours==1)
			  {
			?>
			   (1 nouveau contenu à modérer)
			<?php
			  }else{
			?>
			   (<?=$nbr_cours ?> nouveaux contenus à modérer)
			<?php
			  }
			?>
			</td>
		</tr>
		
		<tr>
			<td style="text-align:center;border:none;"><a href=' <?php echo site_url("admin/moderer_sujets/$id");?> '>Sujets</a></td>
			<td style="text-align:left;border:none;">
			<?php
			 if($nbr_sujets!=0)
			  if($nbr_sujets==1)
			  {
			?>
			   (1 nouveau contenu à modérer)
			<?php
			  }else{
			?>
			   (<?=$nbr_sujets ?> nouveaux contenus à modérer)
			<?php
			  }
			?>
			</td>
		</tr>
		
		<tr>
			<td style="text-align:center;border:none;"><a href=' <?php echo site_url("admin/moderer_td/$id"); ?> '>TD</a></td>
			<td style="text-align:left;border:none;">
			<?php
			 if($nbr_td!=0)
			  if($nbr_td==1)
			  {
			?>
			   (1 nouveau contenu à modérer)
			<?php
			  }else{
			?>
			   (<?=$nbr_td ?> nouveaux contenus à modérer)
			<?php
			  }
			?>
			</td>
		</tr>
		
		
            	
            </table>                        

</div> 
<?php
  //Afficher la partie basse
  $this->oms->partie_basse();
?>           
