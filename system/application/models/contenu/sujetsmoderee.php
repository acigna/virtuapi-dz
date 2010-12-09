<?php


class sujetsmoderee extends Model
{

   //Nombre de sujets à modérer pour une spécialité donnée
   function getNbrSujetsMod($idS)
   {
     $requete=$this->db->query("Select count(*) as nb from sujetsamoderer sm , module m, annee a,specialite s where sm.idmodule=m.id and m.idAnnee=a.id and 	
     					a.idSpecialite=s.id and s.id='$idS'");
     
     $resultat=$requete->result();
     
     return $resultat[0]->nb;
   }

}



?>
