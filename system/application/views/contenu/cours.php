<?php
  //Charger le helper url
  $this->load->helper('url');

  //Récupérer la libririe OMS, et afficher la partie haute
  $this->load->library('oms');
  $this->oms->partie_haute("Les cours de la $nomannee");
?>

<h2 class="center">Cours de <?=stripslashes($nomannee); ?> classés par module</h2><p></p>

<?php 
  foreach($cours as $module) { 
?>
      
  <h3><?=stripslashes($module['nom']);?></h3>
  <ul>
  <?php
    foreach($module['chapitres'] as $chapitre) {
  ?>
    <li><h4>Chapitre <?=$chapitre['num']; ?>: <?=stripslashes($chapitre['nom']);?></h4></li>
    <?php
      foreach($chapitre['contenus'] as $contenu) {
    ?>
    <ul>
      <li>
        <a href='<?=base_url()."contenus/Cours".$contenu['id'].".".$contenu['typefichier']; ?>'>
        <?=$contenu['type'] == 'Complet' ? 'Le cours complet' : 'Le résumé du cours'; ?>  
        </a><br/>
        Publié par: <?=$contenu['publiant'];?><br/>
        Publié le:  <?=date('d/m/Y à H\h:i\m\n',$contenu['pub']);?><br/>
        Derniére modification le: <?=date('d/m/Y à H\h:i\m\n', $contenu['dernmodif']);?> <br/>
        Type de fichier: <?=$contenu['typefichier']; ?><br/>
      </li>
    </ul>
    <p></p>
    <?php
      }      	  
    ?>
  <?php          
    }
  ?>
  </ul>    
      
<?php 
  }
?>

<?php
  //Afficher la partie basse
  $this->load->view('includes/partie_basse.php');
?>      
