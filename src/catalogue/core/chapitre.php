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

/**
  * Fichier contenant la classe Chapitre.
  */
 
/**
 *  Inclure les autres classes (Module,Annee,..).  
 *  Ils sont nécessaires pour le fonctionnement de la classe Chapitre.
 */
require_once "classes.php";
/*******************************************************************************************************************/
/*******************************************************************************************************************/
/********************************************CLASSE CHAPITRE********************************************************/
/*******************************************************************************************************************/
/*******************************************************************************************************************/ 
 
/**
 * Classe pour gérer la table chapitre. 
 * Elle est utilisée pour l'ajout, la modification, la suppression, et la lecture d'éléments à partir
 * de la table chapitre.     
 * @package Catalogue
 * @see Module
 */
 class Chapitre
 {
   /* Les attributs */
   
      /** @var integer L'identifiant du chapitre.    */
      var $id;               
      
      /** @var integer Le numéro du chapitre.       */
      var $num;            
      
      /** @var string Le nom du chapitre.           */
      var $nom;              
      
      /** @var Module Le module auquel le chapitre appartient.   */
      var $module;           
      
      /** @var integer La date d'ajout du chapitre.      */
      var $timeStampAjout;   
      
   /* Les méthodes */
   
      
     /**
      *Créer à partir de la base de données un objet Chapitre dont l'identifiant est $id.
      *@static
      *@param integer $id L'identifiant du chapitre à charger. 
      *@return Chapitre|NULL L'objet Chapitre identifié par $id. NULL si un tel identifiant n'existe pas.  
      */
      function chargerChapitre($id)
      {
        /* Netoyage des variables d'entrées et récuperation du chapitre à partir de la BD */
         
         $sainBD['id']=mysql_real_escape_string(htmlentities($id,ENT_QUOTES,'UTF-8'));
         $chapitreBD=mysql_fetch_array(mysql_query("select * from chapitre where id='{$sainBD['id']}'"));
                        
        if(!$chapitreBD)
         return NULL; // Retourner NULL si l'identifiant n'existe pas dans la table chapitre.
        else
        {
        /* Instantiation et chargement du resultat dans l'objet chapitre */
        
         $chapitre=new Chapitre;
         $chapitre->id=stripslashes($sainBD['id']);
         $chapitre->num=stripslashes($chapitreBD['num']);
         $chapitre->nom=stripslashes($chapitreBD['nom']);
         $chapitre->module=Module::chargerModule(stripslashes($chapitreBD['idmodule']));
         $chapitre->timeStampAjout=stripslashes($chapitreBD['timestampajout']);
        
         return $chapitre; // Retourner l'objet
        }       
      }
      
        
     /**
      *Ajouter un nouveau chapitre dans la base de données.
      *@static
      *@param integer $num Le numéro du chapitre à ajouter.
      *@param string  $nom Le nom du chapitre à ajouter.
      *@param integer $idModule L'identifiant du module auquel le chapitre à ajouter appartient. 
      *@return integer L'identifiant du nouveau chapitre s'il a été ajouté avec succés. 0 dans le cas contraire.   
      */
      function ajouterChapitre($num,$nom,$idModule)
      {
        /* Netoyage des variables d'entrées */
         
          $sainBD['num']=mysql_real_escape_string(htmlentities($num,ENT_QUOTES,'UTF-8'));
          $sainBD['nom']=mysql_real_escape_string(htmlentities($nom,ENT_QUOTES,'UTF-8'));
          $sainBD['idModule']=mysql_real_escape_string(htmlentities($idModule,ENT_QUOTES,'UTF-8'));
          
        /* Ajout de données dans la BD table chapitre */
         
          mysql_query("INSERT INTO chapitre VALUES('', '{$sainBD['num']}', '{$sainBD['nom']}','{$sainBD['idModule']}','".time()."')") ;
          
          return mysql_insert_id();
      }
      
     /**
      *Lister les chapitres contenus dans la base de données et les mettre dans un tableau d'objets de type Chapitre.
      *
      * 
      *@static
      *@param string $champs Format:"{id|num|nom|timestampajout}[,{id|num|nom|timestampajout}[,...]]". 
      *Ce paramétre contient le nom des attributs qui seront initialisés dans chaque objet du tableau retourné. 
      *Les autres attributs(sauf l'attribut $module) seront mises à NULL. 
      *Exemple: "id,nom", si $c est un élément du tableau retourné, $c->id et $c->nom contiendront 
      *les informations correspondantes, mais $c->num et $c->timeStampAjout seront mises à NULL.   
      *
      *@param string $bornes Format:"[{entier1},{entier2}]". Si le paramètre est spécifié, la fonction retournera les {entier2}
      *premiers éléments a partir du {entier1}iéme résultat de la requête SQL. C'est le paramétre "LIMIT" de la requête SQL. 
      *Exemple: "1,15". On retourne le 2éme, 3éme,......, 16éme résulat de la requête.
      *
      *@param string $ordre Format:"[{id|num|nom|timestampajout|idmodule}[,{id|num|nom|timestampajout|idmodule}[,...]]]".
      *Ce paramètre décrit l'ordre des champs à respecter lors du tri du résultat.
      *Exemple: "num,nom". Le tri se fait par numéro de chapitre, puis par nom de chapitre.
      *
      *@param integer $idModule Une valeure O ou "" est équivalente à lister tous les chapitres. 
      *Pour les autres valeurs entières, seules les chapitres appartenant au module identifié par ce paramètre 
      *($idModule)seront listés. 
      *
      *@return Chapitre[]|integer Un tableau contenant la liste des chapitres si la requête n'a pas échoué. -1 dans le cas contraire.    
      */
      function listerChapitre($champs="id,num,nom,timestampajout",$bornes="0,30",$ordre="nom",$idModule="0")
      {
         
          /* Préparation de la requête de listage des modules à partir de la BD 
                   et création d'un tableau contenant la liste des modules   */
                                 
                   
            $sainBD['idModule']=mysql_real_escape_string(htmlentities($idModule,ENT_QUOTES,'UTF-8')); 
            
           //Ajout de la déclaration de la condition sur l'identifiant du module s'il est donné. 
            if($idModule!="0" && $idModule!="") $condition=" where idmodule='{$sainBD['idModule']}' ";
            
           //Ajout des déclaration du tri et des bornes.
            $ordre=" order by ".$ordre;  
            if($bornes!="") $bornes=" LIMIT ".$bornes;      
           
          //Ajouter le champs idmodule. On l'aura besoin dans la requête.
            if($champs=="") $champs="idmodule"; else $champs= $champs.", idmodule" ;          
        
            if(!$chapitreQ=mysql_query("select $champs from chapitre $condition $ordre $bornes"))
              return -1; //Retourner -1 si la requête est malformée
            $tabChapitre=array();
          
         /* Récupération des chapitres à partir de la BD */
           
           while ($chapitreR=mysql_fetch_array($chapitreQ))
           { 
        
             $chapitre=new Chapitre;
             $chapitre->id=stripslashes($chapitreR['id']);
             $chapitre->num=stripslashes($chapitreR['num']);
             $chapitre->nom=stripslashes($chapitreR['nom']);
             $chapitre->module=Module::chargerModule($chapitreR['idmodule']);
             $chapitre->timeStampAjout=stripslashes($chapitreR['timestampajout']);
          
             $tabChapitre[]=$chapitre;
        
           }
           
          return $tabChapitre;             
      }
       
          
     /**
      *Modifier les informations d'un chapitre dans la base de données.
      *L'attribut $id contient l'identifiant du chapitre à modifier. 
      *Les attributs $num et $nom ainsi que l'attribut $module->id contiennent les modifications à apporter.
      *@return integer 1 si le chapitre a été modifié avec succés. 0 dans le cas où les nouvelles et anciennes valeurs sont identiques. -1 dans le cas 
      *d'échec de la requête (Ex: identifiant du module inexistant).
      */ 
      function modifierChapitre()
      {   
         /* Netoyage des variables */  
         
          $sainBD["id"]=mysql_real_escape_string(htmlentities($this->id,ENT_QUOTES,'UTF-8'));
          $sainBD["num"]=mysql_real_escape_string(htmlentities($this->num,ENT_QUOTES,'UTF-8'));
          $sainBD["nom"]=mysql_real_escape_string(htmlentities($this->nom,ENT_QUOTES,'UTF-8'));
          $sainBD["idModule"]=mysql_real_escape_string(htmlentities($this->module->id,ENT_QUOTES,'UTF-8'));
         
         //Modification du chapitre dans la BD
          mysql_query("UPDATE chapitre SET num='{$sainBD["num"]}',nom='{$sainBD["nom"]}', idmodule='{$sainBD["idModule"]}'  WHERE id='{$sainBD["id"]}'");
       
          return mysql_affected_rows();
      } 
       
     /**
      *Supprimer le chapitre identifié par $id de la base de données.
      *@static
      *@param integer $id L'identifiant du chapitre à supprimer.
      *@return integer 1 si le chapitre a été supprimé avec succés. 0 dans le cas d'échec de la requête ou dans le cas d'inexistance de l'identifiant 
      *dans la base de données.   
      */
      function supprimerChapitre($id)
      {
         $sainBD['id']=mysql_real_escape_string(htmlentities($id,ENT_QUOTES,'UTF-8')); // Netoyage de la variable d'entrée
         mysql_query("delete from chapitre where id='{$sainBD['id']}'"); // Suppression du chapitre
      
         return mysql_affected_rows();
      } 
       
      
      
 }
?>
