<?php
  //Charger le helper url.
  $this->load->helper('url');
  
  //Récupérer la libririe OMS, et afficher la partie haute
  $this->load->library('oms');
  $this->oms->partie_haute("Page d'acceuil", array(base_url()."css/acceuil.css"));
  
?>
<div class="box">
  <h2>VirtUAPI-DZ c'est quoi ?</h2>
    <div class="article">
	  <p><strong>Acigna VirtUAPI-DZ</strong> est un projet libre concrétisé par l'entreprise Acigna, pour la mise en place d'un portail communautaire de nature 
	  collaborative permettant aux étudiants de s'échanger du contenu pédagogique (Cours, TD, TP et Sujets d'examens).</p>
	  <p>Pour des suggestions ou des propositions, veuillez  <a href="<?=site_url(array('contact')); ?>" >cliquez içi</a> pour nous contacter.</p>
	</div>
	<p>Pour plus de détails sur le projet VirtUAPI-DZ, vueillez <a href="<?=site_url(array('news1')); ?>">cliquer ici</a>.</p>
     
           <p class="bottom"></p>
</div>
<div class="box">
  <h3>Lancement du portail VirtUAPI-DZ</h3>
  <p>Bonjour tout le monde,</p>
  <div class="article">
    <p>Sans aucun doute, le jeune et tout particuliérement l'étudiant représente le pilier de notre société. C'est à lui qu'on fait appel pour innover, inventer et 
    faire progresser la société, c'est à lui....<a href="<?=site_url(array('news1')); ?>">Cliquer pour plus de détails</a></p> 
  </div>
  <p class="footnote"><br/><strong>Posté par Tarik le 09/11/2013 à 11:54</strong></p>
  <p class="bottom"></p>
</div>

<?php
  //Afficher la partie basse
  $this->load->view('includes/partie_basse.php');
?>
  	   
