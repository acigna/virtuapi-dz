<?php

/*  
     VirtUAPI-DZ API de l'université virtuelle de OpenMindStudents.org
               Copyright (C) 2009  OpenMindStudents.org

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along
    with this program; if not, write to the Free Software Foundation, Inc.,
    51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/

/** Fichier contenant la classe Cycle.
  */

 
/*******************************************************************************************************************/
/*******************************************************************************************************************/
/************************************************CLASSE CYCLE*******************************************************/
/*******************************************************************************************************************/
/*******************************************************************************************************************/ 
 
/**
 * Classe pour gérer la table cycle. 
 * Elle est utilisée pour l'ajout, la modification, la suppression, et la lecture d'éléments à partir
 * de la table cycle.     
 * @package Catalogue
 * @see Annee
 */
 class Cycle
 {
    /* Les attributs */
    
      /** @var integer L'identifiant du cycle.    */
      var $id;               
      
      /** @var string Le code du cycle.    */
      var $code;             
            
      /** @var string Le nom du cycle.    */
      var $nom;              
      
     /**
      *Créer à partir de la base de données un objet Cycle dont l'identifiant est $id.
      *@static
      *@param integer $id L'identifiant du cycle à charger. 
      *@return Cycle|NULL L'objet Cycle identifié par $id. NULL si un tel identifiant n'existe pas.  
      */
      function chargerCycle($id)
      {
        /* Netoyage des variables d'entrées et récuperation du cycle à partir de la BD */
         
         $sainBD['id']=mysql_real_escape_string(htmlentities($id,ENT_QUOTES,'UTF-8'));
         $cycleBD=mysql_fetch_array(mysql_query("select * from cycle where id='{$sainBD['id']}'"));
        
       if(!$cycleBD)
         return NULL; // Retourner NULL si l'identifiant n'existe pas dans la table cycle.
        else
        {           
        /* Instantiation et chargement du resultat dans l'objet cycle */
        
         $cycle=new Cycle;
         $cycle->id=stripslashes($sainBD['id']);
         $cycle->code=stripslashes($cycleBD['code']);
         $cycle->nom=stripslashes($cycleBD['nom']);
         
         return $cycle;     
        }
      }
      
     /**
      *Ajouter un nouveau cycle dans la base de données.
      *@static
      *@param string $nom  Le nom  du cycle à ajouter.
      *@param string  $code Le code du cycle à ajouter. 
      *@return integer L'identifiant du nouveau cycle s'il a été ajouté avec succés. 0 dans le cas contraire.   
      */
      function ajouterCycle($code,$nom)
      {
         /* Netoyage des variables d'entrées */
        
          $sainBD['code']=mysql_real_escape_string(htmlentities($code,ENT_QUOTES,'UTF-8'));
          $sainBD['nom']=mysql_real_escape_string(htmlentities($nom,ENT_QUOTES,'UTF-8'));
                    
         /* Ajout de données dans la BD table cycle */
                  
          mysql_query("INSERT INTO cycle VALUES('', '{$sainBD['code']}', '{$sainBD['nom']}')"); 
          
          return mysql_insert_id();
      }
       
 
     /**
      *Lister les cycles contenus dans la base de données et les mettre dans un tableau d'objets de type Cycle.
      *
      * 
      *@static
      *@param string $champs Format:"{id|code|nom}[,{id|code|nom}[,...]]". 
      *Ce paramétre contient le nom des attributs qui seront initialisés dans chaque objet du tableau retourné. 
      *Les autres attributs seront mises à NULL. 
      *Exemple: "id,nom", si $c est un élément du tableau retourné, $c->id et $c->nom contiendront 
      *les informations correspondantes, mais $c->code sera mise à NULL.   
      *
      *@param string $bornes Format:"[{entier1},{entier2}]". Si le paramètre est spécifié, la fonction retournera les {entier2}
      *premiers éléments a partir du {entier1}iéme résultat de la requête SQL. C'est le paramétre "LIMIT" de la requête SQL. 
      *Exemple: "1,15". On retourne le 2éme, 3éme,......, 16éme résulat de la requête.
      *
      *@param string $ordre Format:"[{id|code|nom}[,{id|code|nom}[,...]]]".
      *Ce paramètre décrit l'ordre des champs à respecter lors du tri du résultat.
      *Exemple: "code,nom". Le tri se fait par code de cycle, puis par nom de cycle.
      *
      *@return Cycle[] Un tableau contenant la liste des cycles si la requête n'a pas échoué. -1 dans le cas contraire.     
      */
      function listerCycle($champs="id,code,nom",$bornes="0,30",$ordre="nom,code")
      {
          /* Préparation de la requête de listage des cycles à partir de la BD 
                   et création d'un tableau contenant la liste des cycles   */
            
            $ordre=" order by ".$ordre;  
            if($bornes!="") $bornes=" LIMIT ".$bornes;      
           
       
            if(!$cycleQ=mysql_query("select $champs from cycle $ordre $bornes"))
              return -1; //Retourner -1 si la requête est malformée
                  
            $tabCycle=array();
          
          /* Récupération des cycles à partir de la BD */
           
           while ($cycleR=mysql_fetch_array($cycleQ))
           {
        
             $cycle=new Cycle;
             $cycle->id=stripslashes($cycleR['id']);
             $cycle->nom=stripslashes($cycleR['nom']);
             $cycle->code=stripslashes($cycleR['code']);
            
             $tabCycle[]=$cycle;
        
           }
           
           
           return $tabCycle;             
      }
     
     /**
      *Modifier les informations d'un cycle dans la base de données.
      *L'attribut $id contient l'identifiant du cycle à modifier. 
      *Les autres attributs ($nom et $code) contiennent les modifications à apporter.
      *@return integer 1 si le cycle a été modifié avec succés. 0 dans le cas où les nouvelles et anciennes valeurs 
      *sont identiques.   
      */
      function modifierCycle()
      {   
      
         /* Netoyage des variables */  
        
          $sainBD["id"]=mysql_real_escape_string(htmlentities($this->id,ENT_QUOTES,'UTF-8'));
          $sainBD["nom"]=mysql_real_escape_string(htmlentities($this->nom,ENT_QUOTES,'UTF-8'));
          $sainBD["code"]=mysql_real_escape_string(htmlentities($this->code,ENT_QUOTES,'UTF-8'));
  
         // Modification du cycle dans la BD
          mysql_query("UPDATE cycle SET code='{$sainBD["code"]}' ,nom='{$sainBD["nom"]}' WHERE id='{$sainBD["id"]}'");
       
       
         return mysql_affected_rows();
      }
       
     /**
      *Supprimer le cycle identifié par $id de la base de données.
      *@static
      *@param integer $id L'identifiant du cycle à supprimer.
      *@return integer 1 si le cycle a été supprimé avec succés. 0 dans le cas d'échec de la requête ou dans le cas d'inexistance de l'identifiant 
      *dans la base de données.   
      */
      function supprimerCycle($id)
      {
        
        /* Netoyage de la variable d'entrée et suppression du cycle */
        
          $sainBD['id']=mysql_real_escape_string(htmlentities($id,ENT_QUOTES,'UTF-8'));
          mysql_query("delete from cycle where id='{$sainBD['id']}'");
           
         return mysql_affected_rows();
      }       
 }
?>

