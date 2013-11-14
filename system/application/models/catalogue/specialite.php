<?php

    //Modéle pour la classe spécialité
    
    class Specialite extends Model
    {
    	var $id;
    	var $nomspecialite;
    	var $timestampajout;
    	    
    	function Specialite()
    	{
    	    parent::Model();    	
    	}
    	
    	//Ajouter une specialite
    	function ajouterSpecialite($nom)
    	{
    	  $requete = $this->db->insert("specialite",array("nomspecialite"=>$nom,"timestampajout"=>time()));
    	  return $this->db->insert_id();
    	}    	
    	
    	//Récupérer la spécialité dont l'identifiant est id
    	function getSpecialite($id) {
    	    return $this->db->query("select id, NomSpecialite as nom from specialite where id='$id'")->row();	
    	}
    	
    	
    	//Supprimer la spécialité dont l'identifiant id
    	function supprimerSpecialite($id) {
    	   $requete = $this->db->delete('specialite',array("id"=>$id));    	
    	}
    	
    	//Lister les spécialités
    	function listerSpecialites()
    	{
    	    return $this->db->query('select id, NomSpecialite as nom from specialite')->result_array();
    	}
    	
    	//Lister les spécialités à modérer
    	function getSpecialiteMod($idmod)
    	{
    	    $requete=$this->db->query("Select m.IdSpecialite as id,s.NomSpecialite as nom from moderateur m,specialite s where s.id=m.IdSpecialite and
    	    			        IdModerateur='$idmod'");
    	    
    	    $sModerees=array();
    	    
    	    foreach($requete->result() as $specialite)
    	    {
    	      $sModerees[]=array('id'=>$specialite->id,'nom'=>$specialite->nom);
    	    }
    	    
    	    return $sModerees;
    	}
    	
    	//Vérifier si un modérateur peut modérer une spécialité
    	function verifierModSpecialite($idS,$idM)
    	{
		$requete=$this->db->query("select count(*) as nb from moderateur where idspecialite='$idS' and idmoderateur='$idM' ");    	
    	        $resultat=$requete->result();
    	        return $resultat[0]->nb;
    	}
    	   
    }

?>
