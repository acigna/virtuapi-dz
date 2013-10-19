<?php


class SujetModere extends Model
{

   //Récupérer le nombre de sujets à modérer pour une spécialité donnée
   function getNbrSujetsMod($idS)
   {
     $requete=$this->db->query("Select count(*) as nb from sujetsamoderer sm , module m, annee a,specialite s where sm.idmodule=m.id and m.idAnnee=a.id and 	
     					a.idSpecialite=s.id and s.id='$idS'");
     
     $resultat=$requete->result();
     
     return $resultat[0]->nb;
   }
   
   //Récupérer le sujet cible
   function getSujetCible($sujetmod)
   {
     $sujetcible=null;
     
     if($sujetmod->nouvelleversion)
     {
       $sujetcible=$this->db->query("select id,typefichier from sujets where type='{$sujetmod->type}' and idmodule='{$sujetmod->idmodule}' and 
       				numsujet='{$sujetmod->numsujet}' and typeexam='{$sujetmod->typeexam}' and anneeuniv='{$sujetmod->anneeuniv}'")->result();
       $sujetcible=$sujetcible[0];
     }
     
     return $sujetcible;
   }
   
   //Récupérer les sujets à modérer 
   function getSujetsMod($idS)
   {
     $result=$this->db->query("Select sm.Id as id ,me.Pseudo as pseudo,idannee,idmodule,typeexam,anneeuniv,numsujet,timestampmoderation,typefichier,nommodule,nomannee,nouvelleversion,type from sujetsamoderer sm ,membre me, module m, annee a,specialite s where me.id=sm.idpubliant and sm.idmodule=m.id and m.idannee=a.id and a.idspecialite=s.id and s.id='$idS' order by timestampmoderation asc")->result();   
     
     for($i=0;$i<count($result);$i++)
     {
               $result[$i]->sujetcible=$this->getSujetCible($result[$i]); 
     		
     }
     
     return $result;
      
   }

   //Supprimer le sujet à modérer
   function supprimerSujetMod($id)
   {
     $sujet=$this->db->query("select id,typefichier from sujetsamoderer where id='$id'")->result();
     unlink(dirname(__FILE__)."/../../../../temp/Sujet{$sujet[0]->id}.{$sujet[0]->typefichier}");   
     $resultat=$this->db->query("delete from sujetsamoderer where id='$id'");   
     return $sujet;
   }
   
   
   //Refuser le sujet à modérer
   function refuserSujetMod($id)
   {  
     $this->supprimerSujetMod($id); //Supprimer le sujet à modérer       
   }
   
   
   //Valider le sujet à modérer
   function validerSujetMod($id)
   {
    
     $sujetmod=$this->db->query("select id,idmodule,idpubliant,typefichier,timestampmoderation,type,typeexam,anneeuniv,numsujet,nouvelleversion from sujetsamoderer where id='$id'")->result();
     $sujetmod=$sujetmod[0];
     $sujetcible=$this->getSujetCible($sujetmod);
     
     if($sujetcible!=null) 
     {
      
     	//Si c'est une nouvelle version d'un sujet existant 
      	$this->db->query("update sujets set timestampdernmodif='".time()."' where id='{$sujetcible->id}'");
      
      	copy(dirname(__FILE__)."/../../../../temp/Sujet{$sujetmod->id}.{$sujetmod->typefichier}",dirname(__FILE__)."/../../../../contenus/Sujet{$sujetcible->id}.{$sujetcible->typefichier}");
       
     
     
     }else{
      
      //Si c'est un nouveau sujet publié
      
      	// Recuperer le numéro de sujet maximum
      	if($sujetmod->numsujet == 0)
      	{
      	  $num_sujet = $this->db->query("select (max(numsujet)+1) as nb from sujets where idmodule='{$sujetmod->idmodule}' and type='{$sujetmod->type}' and TypeExam='{$sujetmod->typeexam}' and AnneeUniv='{$sujetmod->anneeuniv}'")->result();
          
          if($num_sujet->nb == NULL) 
          	$sujetmod->numsujet = 1;
          else
          	$sujetmod->numsujet = $num_sujet[0]->nb ; 	
        }
                                
      	$query=$this->db->insert("sujets",array("idmodule"=>$sujetmod->idmodule,"idpubliant"=>$sujetmod->idpubliant,
                                              "timestamppub"=>$sujetmod->timestampmoderation, "timestampdernmodif"=>$sujetmod->timestampmoderation,
                                              "typefichier"=>$sujetmod->typefichier, "type"=>$sujetmod->type, "typeexam" => $sujetmod->typeexam,
                                              "numsujet" => $sujetmod->numsujet, "anneeuniv"=>$sujetmod->anneeuniv));
      
     
       
     }
        
     $this->supprimerSujetMod($id);  //Supprimer le sujet à modérer
   
   
   }
   
   
    
}



?>
