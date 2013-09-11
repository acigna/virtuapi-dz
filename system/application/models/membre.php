<?php

   //Modéle pour la classe membre
   
   class Membre extends Model
   {
      var $id;
      var $pseudo;
      var $nom;
      var $prenom;
      var $typemembre;
      var $email;
      var $motdepasse;
      var $timestampinscrit;
      var $dernessai;
      
      
      //Charger le membre
      function charger($id)
      {
        $requete=$this->db->query("select id, pseudo, nom, prenom, typemembre, email, motdepasse, timestampinscrit, dernessai from membre where id='$id'");
        
        $resultat=$requete->result();
        $resultat=$resultat[0];
        
        $estAdmin=$this->estAdmin($id);
        $estModerateur=$this->estModerateur($id);
      
        $resultat->estAdmin=$estAdmin;
        $resultat->estModerateur=$estModerateur;
      
        return $resultat;
      }
      
      //Ajouter un modérateur
      function ajouterModerateur($nomM,$idS)
      {
        $resultat=$this->db->query("select id from membre where pseudo='$nomM'")->result();
        
        if($resultat)
        { 
          $idM=mysql_real_escape_string(htmlentities($resultat[0]->id));
          $moderateur=array("idmoderateur"=>$idM,"idspecialite"=>$idS);
          $this->db->insert("moderateur",$moderateur);
                   
          return $this->db->insert_id();
        }
        
        return -1;
      }
      
      function supprimerModerateur($id)
      {
         $id=mysql_real_escape_string(htmlentities($id));
         $this->db->delete('moderateur', array('id' => $id));      
      }
           
      function listerModerateurs()
      {
         return $this->db->query("select mo.Id as idm,s.NomSpecialite noms,m.Pseudo nom from moderateur mo, specialite s, membre m where mo.IdModerateur=m.Id and mo.IdSpecialite=s.Id order by m.Pseudo ASC,s.NomSpecialite ASC")->result_array();
      }
      
      function estAdmin($id)
      {
         $admin=$this->db->query("Select count(*) as nb from administrateur where IdAdministrateur='$id'")->result();    
	 
	 if($admin[0]->nb)
      	   return 1;
      	 else
      	   return 0;      	         
      }
      
      function estModerateur($id)
      {
         $mod=$this->db->query("Select count(*) as nb from moderateur where IdModerateur='$id'")->result();    
	 
	 if($mod[0]->nb)
      	   return 1;
      	 else
      	   return 0;      	   
      }
   }


?>
