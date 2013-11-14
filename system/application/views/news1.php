<?php
  //Charger le helper url
  $this->load->helper('url');  
  
  //Récupérer la libririe OMS, et afficher la partie haute
  $this->load->library('oms');
  $this->oms->partie_haute("Lancement du site");
?>

<p>Bonjour tout le monde,</p>
<div class="article">
<p>Sans aucun doute, le jeune et tout particuliérement l'étudiant représente le pilier de notre société. C'est à lui qu'on fait appel pour innover, inventer et faire progresser la société, c'est à lui qu'on fait appel pour la main d'oeuvre, c'est à lui qu'on fait lors des famines et des catastrophes naturelles, c'est à lui aussi qu'on fait au temps des guerres pour défendre notre terre. C'est l'entité du changement et du progrés culturel, technologique et économique.</p>

<p>Mais voilà, sentons-nous  cette résponsabilité envers notre société? Ou contentons-nous juste de nous-même? N'est-il  pas le moment de s'ouvrir à la société et aux autres et admettre cette résponsabilité?</p>

<p>De bons projets ou initiatives éxistent bien sure dans nous universités, et personne ne peut le démentir. Mais, pour la plupart du temps, nous étudiants font face à des difficultés considérables pour les concritiser. On peut facilement faire porter le chapeau au manque de volentés, de moyens, ou même de compétences. Mais, ceci est injustifiable, ce n'est pas vraiment le probléme. Le vrai probléme réside dans notre refut de travailler en groupe ou de dévoiler nous idées aux autres.</p>
      
<p>Un projet ou une initiative requirt de la patience, et de la ténacité pendant une longue période. C'est bien plus que de la connaissance ou de la compétence que tout le monde peut acquérir, surtout avec nous moyens modernes de communication.</p>

<p>L'être humain, par sa nature est faible, il ne peut pas à lui tout seul supporter une telle charge pour une initiative ou un projet. De plus, une idée n'est innovante et intérrésente que si elle intégre une autre. Le travail en groupe est une nécéssité, pas une option. Il peut rendre cette faiblesse une force en solidifiant encore plus les relations entre les gens.</p>

<p>Et c'est dans ce contexte, que vient se placer notre portail. L'idée dérriére ce portail est de réunir tous les étudiants  dans une méme place pour éssayer de résoudre les problémes ensemble, et regrouper toute cette matiére grise, qui a eu de la peine à concrétiser ces idées, et faire avancer les choses.</p>
   
<p>Actuellement, le portail comporte  une seule rubrique nommée l'université virtuelle. Cette rubrique vise à apporter un espace communautaire pour la publication et la consultation du contenu pédagogique incluant les Cours, sujets d'examens, TD, et TP. Tout étudiant peut y contribuer en publiant du contenu à condition que le module ou le chapitre du module concerné soit répertorié dans le portail. Le contenu n'est pas publié directement et passe par un modérateur de la spécialité concernée. Cette rubrique a été concue de telle façon à permettre une inclusion facile et rapide de nouvelles spécialités et années. A noter qu'il y'a quelques problémes techniques, concernant la publication de contenus pour les utilisateurs d'Internet Explorer dans la partie publication de contenus. Nous espérons régler ces problémes dans prochainement.</p>

<p>Certainement, l'inclusion de nouvelles spécialités et années requirt l'implication d'autres étudiants pour la modération et la publication. Nous éspérons que d'autres étudiants vont nous rejoindre pour enrichir le contenu du portail. Si vous voulez  que votre spécialité ou année soit incluse, vieullez nous contacter <a href="<?=site_url( array('contact') );?>">ici</a>.</p>
     
<p>Je tiens à remercier toute l'équipe de Open Mind Students ainsi que tous ceux qui ont contribués ou qui contriburont dans le portail. Nous incluerons leurs noms au fil du temps en guise de remerciement pour leurs aides et contributions.</p>

<p>Et pour finir, au nom de toute l'équipe, j'annonce le lancement du projet VirtUAPI-DZ.</p>
</div>
<p>
  Mr Tarik Zakaria BENMERAR,<br/> 
  Chef du projet,<br/>  
  Acigna VirtUAPI-DZ
</p>
<p></p>
     
<?php
  //Afficher la partie basse
  $this->load->view('includes/partie_basse.php');
?>

