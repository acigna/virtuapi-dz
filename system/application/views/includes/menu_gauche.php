	<div id="colOne">
		<div class="box">
			<h3 id="Consultation">Université Virtuelle:<br/>Consulter du contenus</h3>
			<ul class="bottom">
			<?php
			   $i=0;
			   $SpecialiteResultat=mysql_query("select * from specialite order by NomSpecialite");
			   while($SpecialiteDonnees=mysql_fetch_array($SpecialiteResultat)){
			    $i++;
			 ?>
			   <li onclick="javascript:montre('smenu<?php echo $i; ?>');"><a style="cursor:pointer" ><?php echo stripslashes($SpecialiteDonnees['NomSpecialite']); ?></a></li>
			   <li> 
				 <ul id="smenu<?php echo $i; ?>">
			 	   <li><a href="<?php echo base_url(); ?>index.php/cours/annees/<?php echo $SpecialiteDonnees['Id']; ?>">Cours</a></li>
				   <li><a href="<?php echo base_url(); ?>index.php/sujets/annees/<?php echo $SpecialiteDonnees['Id']; ?>">Sujets d'éxamens</a></li>
				   <li><a href="<?php echo base_url(); ?>index.php/td/<?php echo $SpecialiteDonnees['Id']; ?>">Travaux dirigés</a></li>
				  </ul>
			   </li>
            <?php
             }
            ?>	
             </ul>			
			
		</div><br/>  			
       
    <!--  Widget pour la publication de contenus -->
		<div class="box" id="Publication">
		<h3>Université Virtuelle:<br/>Publier du contenus</h3>
		   	 	   <ul class="bottom">
					 <li><a href="<?php echo base_url(); ?>index.php/cours/publier">Cours</a></li>
					 <li><a href="<?php echo base_url(); ?>index.php/sujets/publier">Sujets d'éxamens</a></li>
					 <li><a href="<?php echo base_url(); ?>index.php/td/publier">Travaux dirigés</a></li>
					 
				   </ul>
				
	 	</div>
		<br/>		
		<!--  Widget pour la consultation de contenus -->
		
	
    <!-- Widget de connection de compte -->
	   <div id="login" class="box">						
			<?php
			 if(!$membre){ //Le cas où le membre n'est pas connecté, on affiche le formulaire de connection
			  
			?>  
		    	<h3>Identification</h3>
		         <ul class="bottom">
				 <li>
			     <form method="post" >
				  <p>
				   <label for="PseudoC">Pseudo:</label>
				   <input id="PseudoC" name="PseudoC" type="text" />
				   <label for="MotDePasseC">Mot de Passe:</label><input id="MotDePasseC" name="MotDePasseC" type="password" />
				   <div style="color:red;"><?php echo $erreurConnection; ?></div>
				   <input type="submit" value="Se connecter" />
    			  </p>
				 </form>
				 </li>
                 <li><a href="<?php echo base_url(); ?>index.php/membre/inscription">Devenir Membre ? Inscrivez-vous dès maintenant !!</a></li>
 			     </ul>		  
		      
			<?php
		     }else{
			?>
			    <h3>Bonjour, <?php echo $membre->prenom; ?></h3>
				<ul class="bottom">
		         <li><h4>Mon Compte</h4></li> 
				 <li>
				  <ul>
				   <li><a href="<?php echo base_url(); ?>index.php/membre">Mon Profil</a></li>
				   <?php if($membre->estAdmin || $membre->estModerateur){ ?>
				   <li><a  href="<?php echo base_url(); ?>index.php/admin">Administration</a></li>
				   <?php } ?>
				   
				   <li><a href="<?php echo base_url(); ?>index.php/welcome/Deconnection">Se déconnecter</a></li>
				  </ul>
				 </li>
			    </ul>	 
			<?php
		     }
			?>
		</div><br/>	

   </div>


