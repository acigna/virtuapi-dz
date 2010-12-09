<?php

class TdModeree extends Model
{

   //Nombre de sujets à modérer pour une spécialité donnée
   function getNbrTdMod($idS)
   {
     $requete=$this->db->query("Select count(*) as nb from tdamoderer tdm ,chapitre c, module m, annee a,specialite s where tdm.idchapitre=c.id and c.idModule=m.id and 
     					m.idAnnee=a.id and a.idSpecialite=s.id and s.id='$idS'");
     
     $resultat=$requete->result();
     
     return $resultat[0]->nb;
   }

}



?>
