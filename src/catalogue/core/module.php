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
  * Fichier contenant la classe Module.
  */
 
/**
 *  Inclure les autres classes (Annee,Faculte,..)  
 *  Ils sont nécessaires pour le fonctionnement de la classe Module.
 */
require_once "classes.php";
/*******************************************************************************************************************/
/*******************************************************************************************************************/
/************************************************CLASSE MODULE******************************************************/
/*******************************************************************************************************************/
/*******************************************************************************************************************/   
 
/**
 * Classe pour gérer la table module. 
 * Elle est utilisée pour l'ajout, la modification, la suppression, et la lecture d'éléments à partir
 * de la table module.     
 * @package Catalogue
 * @see Chapitre,Annee
 */
 class Module
 {
    /* Les attributs */
    
      /** @var integer L'identifiant du module.    */
      var $id;               
      
      /** @var string Le nom du module.           */
      var $nom;              
      
      /** @var Annee L'année à laquelle le module appartient.   */
      var $annee;           
      
      /** @var integer La date d'ajout du module.      */
      var $timeStampAjout;   
      
   
   /* Les méthodes */
      
     /**
      *Créer à partir de la base de données un objet Module dont l'identifiant est $id.
      *@static
      *@param integer $id L'identifiant du module à charger. 
      *@return Module|NULL L'objet Module identifié par $id. NULL si un tel identifiant n'existe pas.  
      */
      function chargerModule($id)
      {
         /* Netoyage des variables d'entrées et récuperation du module à partir de la BD */
          
            $sainBD['id']=mysql_real_escape_string(htmlentities($id,ENT_QUOTES,'UTF-8'));
            $moduleBD=mysql_fetch_array(mysql_query("select * from module where id='{$sainBD['id']}'"));
         
        if(!$moduleBD)
         return NULL; // Retourner NULL si l'identifiant n'existe pas dans la table module.
        else
        {        
         /* Instantiation et chargement du resultat dans l'objet module */
        
           $module=new Module;
           $module->id=stripslashes($sainBD['id']);
           $module->nom=stripslashes($moduleBD['nom']);
           $module->abrv=stripslashes($moduleBD['abrv']);
           $module->annee=Annee::chargerAnnee(stripslashes($moduleBD['idannee']));
           $module->timeStampAjout=stripslashes($moduleBD['timestampajout']);
        
           return $module; // Retourner l'objet
        }       
      }
     
     /**
      *Ajouter un nouveau module dans la base de données.
      *@static
      *@param string $nom Le nom du module à ajouter.
      *@param string  $abrv L'abréviation du module à ajouter. Seules les caractéres alphanumériques et les caractéres spéciaux ". _ + -" sont autorisés.
      *Ceci car l'abréviation est prévu pour être utilisé dans des noms de fichiers, comme ceux des contenus pédagogiques.  
      *@param integer $idAnnee L'identifiant de l'année à laquelle le module à ajouter appartient. 
      *@return integer L'identifiant du nouveau module s'il a été ajouté avec succés. Sinon, -1 si le format de l'abréviation n'est pas respecté ou
      *0 dans les autres cas.   
      */
      function ajouterModule($nom,$abrv,$idAnnee)
      {
        /* Netoyage des variables d'entrée */
        
         $sainBD['nom']=mysql_real_escape_string(htmlentities($nom,ENT_QUOTES,'UTF-8'));
         $sainBD['idAnnee']=mysql_real_escape_string(htmlentities($idAnnee,ENT_QUOTES,'UTF-8'));
         $sainBD['abrv']=mysql_real_escape_string(htmlentities($abrv,ENT_QUOTES,'UTF-8'));
          
        
         if(!preg_match("#^[a-z0-9\._+-]+$#i",$sainBD['abrv']))
          return -1; /* L'abreviation sera utilisé dans des noms de fichiers. 
                       Elle doit respecter la présence stricte que de certains caractéres. */
         else
         //Ajout de données dans la BD table module
          mysql_query("INSERT INTO module VALUES('', '{$sainBD['nom']}', '{$sainBD['abrv']}', '{$sainBD['idAnnee']}','".time()."')");  
          
         return mysql_insert_id();
       }
              
     /**
      *Lister les modules contenus dans la base de données et les mettre dans un tableau d'objets de type Module.
      *
      * 
      *@static
      *@param string $champs Format:"{id|nom|abrv|timestampajout}[,{id|nom|abrv|timestampajout}[,...]]". 
      *Ce paramétre contient le nom des attributs qui seront initialisés dans chaque objet du tableau retourné. 
      *Les autres attributs(sauf l'attribut $annee) seront mises à NULL. 
      *Exemple: "id,nom", si $c est un élément du tableau retourné, $c->id et $c->nom contiendront 
      *les informations correspondantes, mais $c->abrv et $c->timeStampAjout seront mises à NULL.   
      *
      *@param string $bornes Format:"[{entier1},{entier2}]". Si le paramètre est spécifié, la fonction retournera les {entier2}
      *premiers éléments a partir du {entier1}iéme résultat de la requête SQL. C'est le paramétre "LIMIT" de la requête SQL. 
      *Exemple: "1,15". On retourne le 2éme, 3éme,......, 16éme résulat de la requête.
      *
      *@param string $ordre Format:"[{id|nom|abrv|timestampajout|idannee}[,{id|nom|abrv|timestampajout|idannee}[,...]]]".
      *Ce paramètre décrit l'ordre des champs à respecter lors du tri du résultat.
      *Exemple: "abrv,nom". Le tri se fait par abréviation de module, puis par nom de module.
      *
      *@param integer $idAnnee Une valeure O ou "" est équivalente à lister tous les modules. 
      *Pour les autres valeurs entières, seules les modules appartenant à l'année identifiée par ce paramètre 
      *($idAnnee)seront listés. 
      *
      *@return Module[]|integer Un tableau contenant la liste des modules si la requête n'a pas échoué. -1 dans le cas contraire.    
      */
      function listerModule($champs="id,nom,abrv,timestampajout ",$bornes="0,30",$ordre="nom",$idAnnee="")
      {
      
         /* Préparation de la requête de listage des modules à partir de la BD 
                  et création d'un tableau contenant la liste des modules   */
                   
           $sainBD['idAnnee']=mysql_real_escape_string(htmlentities($idAnnee,ENT_QUOTES,'UTF-8')); 
           
           if($idAnnee!="0" && $idAnnee!="") $condition=" where idannee='{$sainBD['idAnnee']}' ";
           $ordre=" order by ".$ordre;  
           if($bornes!="") $bornes=" LIMIT ".$bornes;      
           
         //Ajouter le champs idannee. On l'aura besoin dans la requête.
           if($champs=="") $champs="idannee"; else $champs= $champs.", idannee" ;          
           
           if(!$moduleQ=mysql_query("select $champs from module $condition $ordre $bornes"))
            return -1; //Retourner -1 si la requête est malformée
               
           $tabModule=array();
          
          /* Récupération des modules à partir de la BD */
           
           while  ($moduleR=mysql_fetch_array($moduleQ))
           {
        
             $module=new Module;
             $module->id=stripslashes($moduleR['id']);
             $module->nom=stripslashes($moduleR['nom']);
             $module->abrv=stripslashes($moduleR['abrv']);
             $module->annee=Annee::chargerAnnee($moduleR['idannee']);
             $module->timeStampAjout=stripslashes($moduleR['timestampajout']);
            
             $tabModule[]=$module;
        
           }
           
           
           return $tabModule;             
      }
        
     /**
      *Modifier les informations d'un module dans la base de données.
      *L'attribut $id contient l'identifiant du module à modifier. 
      *Les attributs $nom et $abrv ainsi que l'attribut $annee->id contiennent les modifications à apporter.
      *@return integer 1 si le module a été modifié avec succés. 0 dans le cas où les nouvelles et anciennes valeurs 
      *sont identiques. -1 dans le cas d'échec de la requête (Ex: identifiant de l'année inexistant) ou -1 si le format de la nouvelle abréviation n'est 
      *pas respecté(Seules les caractéres alphanumériques et les caractéres spéciaux ". _ + -" sont autorisés pour l'abréviation). .     
      */ 
      function modifierModule()
      {   
         /* Netoyage des variables */  
          
          $sainBD["id"]=mysql_real_escape_string(htmlentities($this->id,ENT_QUOTES,'UTF-8'));
          $sainBD["nom"]=mysql_real_escape_string(htmlentities($this->nom,ENT_QUOTES,'UTF-8'));
          $sainBD["abrv"]=mysql_real_escape_string(htmlentities($this->abrv,ENT_QUOTES,'UTF-8'));
          $sainBD["idAnnee"]=mysql_real_escape_string(htmlentities($this->annee->id,ENT_QUOTES,'UTF-8'));
      
          if(!preg_match("#^[a-z0-9\._+-]+$#i",$sainBD['abrv']))
           return -1; /* L'abreviation sera utilisé dans des noms de fichiers. 
                         Elle doit respecter la présence stricte que de certains caractéres. */
          else
         //Modification du module dans la BD
          mysql_query("UPDATE module SET nom='{$sainBD["nom"]}',abrv='{$sainBD["abrv"]}', idannee='{$sainBD["idAnnee"]}'  WHERE id='{$sainBD["id"]}'");
     
          return mysql_affected_rows();      
      }             
              
      
     /**
      *Supprimer le module identifié par $id de la base de données.
      *@static
      *@param integer $id L'identifiant du module à supprimer.
      *@return integer 1 si le module a été supprimé avec succés. 0 dans le cas d'échec de la requête ou dans le cas d'inexistance de l'identifiant 
      *dans la base de données.      
      */
      function supprimerModule($id)
      {
         $sainBD['id']=mysql_real_escape_string(htmlentities($id,ENT_QUOTES,'UTF-8')); // Netoyage de la variable d'entrée
         mysql_query("delete from module where id='{$sainBD['id']}'"); // Suppression du module
           
         return mysql_affected_rows();
      }  
               
                   
 }
?>
