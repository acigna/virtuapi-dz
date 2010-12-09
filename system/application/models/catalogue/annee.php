<?php

  // Modéle pour la classe Annee
  
  class Annee extends Model
  {
    var $id;
    var $nomannee;
    var $idspecialite;
    var $timestampajout;
    
    //Ajouter une année dans une spécialité
    function ajouterAnnee($nom,$idspecialite)
    {
    	$nom=mysql_real_escape_string(htmlentities($nom,ENT_QUOTES,'UTF-8'));
    	$idspecialite=mysql_real_escape_string(htmlentities($idspecialite,ENT_QUOTES,'UTF-8'));
        
        $requet=$this->db->insert("annee",array("nomannee"=>$nom,"idspecialite"=>$idspecialite, "timestampajout"=>time()));
    	return $this->db->insert_id();
    }
    
    //Supprimer l'année dont l'identifiant est id
    function supprimerAnnee($id)
    {
       $id=mysql_real_escape_string(htmlentities($id,ENT_QUOTES,'UTF-8'));
       $requete=$this->db->delete('annee',array("id"=>$id));    	
    }
    
    //Lister les années avec les spécialités
    function listerAnneesSpec()
    {
        $requete=$this->db->query("select a.id as ida, NomAnnee as noma, s.NomSpecialite as noms,IdSpecialite as ids from annee a, specialite s where s.id=a.idspecialite order by s.NomSpecialite ASC,a.NomAnnee ASC");    
        
        $anneesSpec=array();
        $annees=$requete->result();
        
        if($annees)
        {
           $anneesSpec[]=array("id"=>$annees[0]->ids,"nom"=>$annees[0]->noms,"annees"=>array(array("id"=>$annees[0]->ida,"nom"=>$annees[0]->noma)));
           
           unset($annees[0]);
           
           foreach($annees as $annee)
           {
              if($anneesSpec[count($anneesSpec)-1]['id']==$annee->ids)
              {
                 $anneesSpec[count($anneesSpec)-1]['annees'][]=array("id"=>$annee->ida,"nom"=>$annee->noma);                  
              }else{
                 $anneesSpec[]=array("id"=>$annee->ids,"nom"=>$annee->noms,"annees"=>array(array("id"=>$annee->ida,"nom"=>$annee->noma)));
              }                           
           }
        }
        
        return $anneesSpec;  
                                
    }
  
  
  
  } 
