<?php

class CoursModeree extends Model
{
   
   
   //Nombre de cours à modérer pour une spécialité donnée
   function getNbrCoursMod($idS)
   {
     $requete=$this->db->query("Select count(*) as nb from coursamoderer cm ,chapitre c, module m, annee a,specialite s where cm.idchapitre=c.id and c.idModule=m.id and 
     					m.idAnnee=a.id and a.idSpecialite=s.id and s.id='$idS'");
   
     $resultat=$requete->result();
     
     return $resultat[0]->nb;
   }
   
   //

}



?>
