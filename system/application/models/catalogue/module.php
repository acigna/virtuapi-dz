<?php

    //Modéle pour la classe module
    
    class Module extends Model
    {
     	var $id;
     	var $nommodule;
     	var $idannee;
     	var $timestampajout;
     	
     	
     	//Ajouter un module dans une année
    	function ajouterModule($nom,$idannee)
    	{
    		$nom=mysql_real_escape_string(htmlentities($nom,ENT_QUOTES,'UTF-8'));
    		$idannee=mysql_real_escape_string(htmlentities($idannee,ENT_QUOTES,'UTF-8'));
    		
        	$requet=$this->db->insert("module",array("nommodule"=>$nom,"idannee"=>$idannee, "timestampajout"=>time()));
    		return $this->db->insert_id();
    	}
    	
    	//Supprimer un module
    	function supprimerModule($id)
    	{   	
    		$id=mysql_real_escape_string(htmlentities($id,ENT_QUOTES,'UTF-8'));
    		$requete=$this->db->delete('module',array("id"=>$id));
    	}
    	
    	//Lister les modules d'une année
    	function listerModule($idannee)
    	{
    		$idannee=mysql_real_escape_string(htmlentities($idannee,ENT_QUOTES,'UTF-8'));
    		$requete=$this->db->query("select id,nommodule as nom, timestampajout from module where idannee='$idannee' order by nom");
    		return $requete->result_array();    	
    	}
    	
    	   
    
    }


?>
