<?php

    //Modéle pour la classe chapitre
    
    class Chapitre extends Model
    {
	    var $id;
     	var $numchapitre;
     	var $nomchapitre;
     	var $idmodule;
     	var $timestampajout;
     	
     	//Ajouter un chapitre
     	function ajouterChapitre($num,$nom,$idmodule) {
     	    $num = mysql_real_escape_string(htmlentities($num,ENT_QUOTES,'UTF-8'));
            $nom = mysql_real_escape_string(htmlentities($nom,ENT_QUOTES,'UTF-8'));
            $idmodule = mysql_real_escape_string(htmlentities($idmodule,ENT_QUOTES,'UTF-8'));
     	   
            $requete=$this->db->insert("chapitre",array("numchapitre"=>$num,"nomchapitre"=>$nom, "idmodule"=>$idmodule, "timestampajout"=>time()));
    	    return $this->db->insert_id();
        }
     	
     	//Supprimer un chapitre
     	function supprimerChapitre($id)	{ 	
            $id = mysql_real_escape_string(htmlentities($id,ENT_QUOTES,'UTF-8'));
            $requete = $this->db->delete('chapitre',array("id"=>$id));
     	}
     	
     	//Lister les chapitre d'un module
     	function listerChapitre($idmodule) {
             $idmodule = mysql_real_escape_string(htmlentities($idmodule,ENT_QUOTES,'UTF-8'));
             $requete = $this->db->query("select id, numchapitre as num, nomchapitre as nom, timestampajout from chapitre where idmodule='$idmodule' order by num ");
             return $requete->result_array();     	
     	}
     	
     	//Récupérer le chapitre, le module et l'année correspondants à un chapitre donné
     	function getCMA ($idchapitre) {
     	    $idchapitre = mysql_real_escape_string(htmlentities($idchapitre, ENT_QUOTES, 'UTF-8'));
     	    return $this->db->query("select c.id as chapitre, m.id as module,a.id as annee from chapitre c, module m, annee a, specialite s where ".    
	                                                     "c.id='$idchapitre' and c.idmodule=m.id and m.idannee=a.id")->row_array();     	
     	}
     	     	  
    
    }

?>
