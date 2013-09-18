<?php

class CoursModere extends Model
{
   function ajouter($idchapitre, $type, $idpubliant, $typefichier) {
       $idchapitre = mysql_real_escape_string(htmlentities($idchapitre));
       $type = mysql_real_escape_string(htmlentities($type)); 
       
       $this->db->insert( "coursamoderer", array( "idchapitre" => $idchapitre, "type" => $type, "idpubliant" => $idpubliant, 
                                                  "typefichier" => $typefichier,  "timestampmoderation" => time() ) ); 
       return $this->db->insert_id();        
   }
  
   //Récupérer le nombre de cours à modérer pour une spécialité donnée
   function getNbrCoursMod($idS)
   {
     $requete=$this->db->query("Select count(*) as nb from coursamoderer cm ,chapitre c, module m, annee a,specialite s where cm.idchapitre=c.id and c.idModule=m.id and m.idAnnee=a.id and a.idSpecialite=s.id and s.id='$idS'");
   
     $resultat=$requete->result();
     
     return $resultat[0]->nb;
   }
   
   //Récupérer le cours cible
   function getCoursCible($coursmod)
   {
     $courscible=$this->db->query("select id,typefichier from cours where type={$coursmod->type} and idchapitre='{$coursmod->idchapitre}'")->result();
     return $courscible;
   }
   
   //Récupérer les cours à modérer
   function getCoursMod($idS)
   {
     $result=$this->db->query("Select cm.Id as id,me.Pseudo as pseudo,idchapitre,timestampmoderation,typefichier,numchapitre,nomchapitre,nommodule,nomannee,type from membre me,coursamoderer cm ,chapitre c, module m, annee a,specialite s where me.Id=cm.IdPubliant and cm.idchapitre=c.id and c.idModule=m.id and m.idAnnee=a.id and a.idSpecialite=s.id and s.id='$idS' order by TimeStampModeration asc")->result();
     
     for($i=0;$i<count($result);$i++)
     {
       $courscible=$this->db->query("select id,typefichier  from cours where type='{$result[$i]->type}' and idchapitre='{$result[$i]->idchapitre}'")->result();
       $result[$i]->nouvelleversion=count($courscible);
       
       if($result[$i]->nouvelleversion)
       {
         $result[$i]->courscible=$courscible[0];
       }
       
     }
     
     return $result;
   }
     
   //Supprimer le cours à modérer
   function supprimerCoursMod($id)
   {
     $cours=$this->db->query("select id,typefichier from coursamoderer where id='$id'")->result();
     unlink(dirname(__FILE__)."/../../../../temp/Cours{$cours[0]->id}.{$cours[0]->typefichier}");   
     $resultat=$this->db->query("delete from coursamoderer where id='$id'");   
     return $cours;
   }
   
   
   //Refuser le cours à modérer
   function refuserCoursMod($id)
   {  
     $this->supprimerCoursMod($id); //Supprimer le cours à modérer       
   }
   
   //Valider le cours à modérer
   function validerCoursMod($id)
   {
     $coursmod=$this->db->query("select id,idchapitre,idpubliant,typefichier,timestampmoderation,type from coursamoderer where id='$id'")->result();
     $courscible=$this->getCoursCible($coursmod[0]);

     if(count($courscible)!=0) 
     {
       //Si c'est une nouvelle version d'un cours existant
       $this->db->query("update cours set timestampdernmodif='".time()."' where id='{$courscible[0]->id}'");
       copy(dirname(__FILE__)."/../../../../temp/Cours{$coursmod[0]->id}.{$coursmod[0]->typefichier}",dirname(__FILE__)."/../../../../contenus/Cours{$courscible[0]->id}.{$courscible[0]->typefichier}");
     }else{
       //Si c'est un nouveau cours publié
       $query = $this->db->insert("cours", array( "idchapitre" => $coursmod[0]->idchapitre, "idpubliant" => $coursmod[0]->idpubliant,
                                                  "timestamppub" => $coursmod[0]->timestampmoderation, "timestampdernmodif"=>$coursmod[0]->timestampmoderation,
                                                  "typefichier" => $coursmod[0]->typefichier, "type"=>$coursmod[0]->type));
      
       copy(dirname(__FILE__)."/../../../../temp/Cours{$coursmod[0]->id}.{$coursmod[0]->typefichier}",
            dirname(__FILE__)."/../../../../contenus/Cours".$this->db->insert_id().".{$coursmod[0]->typefichier}");
     }
        
     $this->supprimerCoursMod($id);  //Supprimer le cours à modérer
   }
   

}



?>
