<?php
  $this->load->helper('url');
?>
<div id="colOne">
  <div class="box">
    <h3 id="Consultation">Université Virtuelle:<br/>Consulter du contenus</h3>
    <!--  Widget pour la consultation de contenus -->
    <ul class="bottom">
    <?php
      foreach( $specialites as $i => $specialite ) {  ?>
      <li onclick="javascript:montre('smenu<?=($i + 1); ?>');"><a style="cursor:pointer" ><?=stripslashes($specialite['nom']); ?></a></li>
      <li> 
        <ul id="smenu<?=($i + 1); ?>"><li><a href="<?=site_url( array( 'cours', 'annees', $specialite['id'] ) ); ?>">Cours</a></li>
          <li><a href="<?=site_url( array( 'sujets', 'annees', $specialite['id'] ) ); ?>">Sujets d'éxamens</a></li>
          <li><a href="<?=site_url( array( 'td', 'annees', $specialite['id'] ) ); ?>">Travaux dirigés</a></li>
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
        <li><a href="<?=site_url( array( 'cours', 'publier' ) ); ?>">Cours</a></li>
        <li><a href="<?=site_url( array( 'sujets', 'publier' ) ); ?>">Sujets d'éxamens</a></li> 
        <li><a href="<?=site_url( array( 'td', 'publier' ) ); ?>">Travaux dirigés</a></li>
      </ul>
  </div><br/>		
	
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
            <div style="color:red;"><?=$erreurConnection; ?></div>
            <input type="submit" value="Se connecter" />
          </p>
        </form>
      </li>
      <li><a href="<?=site_url( array( 'membre', 'inscription' ) ); ?>">Devenir Membre ? Inscrivez-vous dès maintenant !!</a></li>
    </ul>		  
		      
  <?php
    } else {
  ?>
    <h3>Bonjour, <?=$membre->prenom; ?></h3>
    <ul class="bottom">
      <li><h4>Mon Compte</h4></li> 
      <li>
        <ul>
          <li><a href="<?=site_url( array('membre') ); ?>">Mon Profil</a></li>
        <?php if( $membre->estAdmin || $membre->estModerateur ) { ?>
          <li><a  href="<?=site_url( array('admin') ); ?>">Administration</a></li>
		<?php } ?>
          <li><a href="<?=site_url( array( 'membre', 'deconnexion' ) ); ?>">Se déconnecter</a></li>
        </ul>     
      </li>
    </ul>
    	 
  <?php
    }
  ?>
  </div><br/>	
</div>


