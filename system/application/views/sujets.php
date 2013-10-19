<?php
  //R�cup�rer la libririe OMS, et afficher la partie haute
  $this->load->library('oms');
  $this->oms->partie_haute("Les sujets de la $nomannee");
?>

<?php
/* Tableaux d'association entre les valeurs base de donn�es et les valeurs r�elles*/
	  
	  //Association du type
	    $conType=array();
	    $conType['Sujet']="Le Sujet";
	    $conType['Solution']="La Solution";
	  
	  //Association du Type d'�xamen
             $conTypeE=array();
             $conTypeE['EMD1']="EMD 1";
	     $conTypeE['EMD2']="EMD 2";
	     $conTypeE['EMD3']="EMD 3";
	     $conTypeE['Synthese']="Synthése";
	     $conTypeE['Rattrapage']="Rattrapage";

?>

<h2 style="text-align:center;">Les sujets de <?php echo $nomannee; ?> classés par modules </h2>

<?php
  
  foreach($sujets as $module)
  {
?>

   <h3><?php echo stripslashes($module['nom']) ; ?></h3>
   <ul>
   
   <?php
      foreach($module['contenus'] as $contenu)
      {
    ?>
      
      <li><h4><?php  echo $contenu['anneeuniv'];?></h4></li>
      	  <ul>
      	 <?php
      	    foreach($contenu['sujetsa'] as $sujeta)
      	    {
          ?>
              <li><h4><?php echo $conTypeE[$sujeta['typeexam']] ; ?></h4></li>
              <ul>
              <?php
                foreach($sujeta['sujetse'] as  $sujete)  
                {            
              ?>
                   <li><h4>Sujet <?php echo $sujete['numsujet'] ; ?></h4></li>
                       <ul>
                      <?php 
                          foreach($sujete['sujetsn'] as $sujetn)
                          {                   
                      ?>
                      
                            <li><a href="./../../../contenu/Sujet<?php echo $sujetn['id'] ;?>.<?php echo $sujetn['typefichier'] ;?>"><?php echo $conType[$sujetn['type']] ;?></a>
                                <br/>
                                 Publié par: <?php echo $sujetn['pseudo']; ?><br/>
				 Publié le:  <?php echo date(' d/m/Y à H\h:i\m\n ',$sujetn['pub']);?><br/>
				 Derniére modification le:<?php echo date(' d/m/Y à H\h:i\m\n ',$sujetn['dernmodif']); ?><br/> 
				 Type de fichier: <?php echo $sujetn['typefichier'] ;?>
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
  $this->oms->partie_basse();
?>
