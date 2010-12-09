<h2 style="text-align:center;">Administration du portail</h2>
	<p style="text-align:center;">
	  <?php /*Verifier s'il est moderateur */
	       if($admin){ /*S'il est administrateur*/  ?>
      <a  href=' <?=site_url("admin/gerer_moderateur"); ?> '>choix des moderateurs<br/></a>
	  <a  href=' <?=site_url("admin/gerer_samc") ; ?>'>Gérer les spécialités,années,modules, et chapitres<br/></a>
           <?php } 
	       if($mod){ /*S'il est moderateur*/ ?>
  	  <a  href=' <?=site_url("admin/moderation"); ?> '>Modération de contenus<br/></a>
           <?php
            } ?>
	</p>
