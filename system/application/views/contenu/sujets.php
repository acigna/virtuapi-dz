<?php
  //Récupérer la libririe OMS, et afficher la partie haute
  $this->load->library('oms');
  $this->oms->partie_haute("Les sujets de la $nomannee");
?>

<?php
  //Association du type

  $conType=array();

  $conType['Sujet']="Le Sujet";

  $conType['Solution']="La Solution";

	  
  //Association du Type d'éxamen

  $conTypeE=array();

  $conTypeE['EMD1']="EMD 1";

  $conTypeE['EMD2']="EMD 2";
  $conTypeE['EMD3']="EMD 3";

  $conTypeE['Synthese']="Synthèse";

  $conTypeE['Rattrapage']="Rattrapage";

?>

<h2 class="center">Les sujets de <?=stripslashes($nomannee); ?> classés par modules </h2>

<?php
  foreach( $sujets as $module ) {
?>
  <h3><?=stripslashes($module['nom']) ; ?></h3>
  <ul>
  <?php
    foreach( $module['contenus'] as $contenu ) {
  ?>
    <li><h4><?=$contenu['anneeuniv'];?></h4></li>
    <ul>
    <?php
      foreach( $contenu['sujetsa'] as $sujeta ) {
    ?>
      <li><h4><?=$conTypeE[$sujeta['typeexam']] ; ?></h4></li>
      <ul>
      <?php
        foreach($sujeta['sujetse'] as  $sujete) {            
      ?>
        <li><h4>Sujet <?=$sujete['numsujet'] ; ?></h4></li>
        <ul>
        <?php 
          foreach( $sujete['sujetsn'] as $sujetn ) {                   
        ?>
          <li><a href="./../../../contenu/Sujet<?=$sujetn['id'] ;?>.<?=$sujetn['typefichier'] ;?>"><?=$conType[$sujetn['type']] ;?></a><br/>
          Publié par: <?=$sujetn['pseudo']; ?><br/>
          Publié le:  <?=date(' d/m/Y Ã  H\h:i\m\n ',$sujetn['pub']);?><br/>
          Dernière modification le:<?=date(' d/m/Y Ã  H\h:i\m\n ', $sujetn['dernmodif']); ?><br/> 

          Type de fichier: <?=$sujetn['typefichier'] ;?>
          </li><br/>
                       
        <?php
          }
        ?>
        </ul>
      <?php
        }                
      ?> 
      </ul>
    <?php
      }          
    ?>
    </ul>
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
