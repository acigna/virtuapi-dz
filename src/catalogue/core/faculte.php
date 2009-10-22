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
  * Fichier contenant la classe Faculte.
  */

/**
 *  Inclure les autres classes (Etablissement,..).  
 *  Ils sont nécessaires pour le fonctionnement de la classe Faculte.
 */
require_once "classes.php";
/*******************************************************************************************************************/
/*******************************************************************************************************************/
/**********************************************CLASSE FACULTE*******************************************************/
/*******************************************************************************************************************/
/*******************************************************************************************************************/

/**
 * Classe pour gérer la table faculte et sa relation avec la table faculte-etablissement. 
 * Elle est utilisée pour l'ajout, la modification, la suppression, et la lecture d'éléments à partir
 * de la table faculté. Elle est aussi utilisée pour l'ajout et la suppression à partir de la table 
 * faculte-etablissement, ainsi que la lecture d'éléments de la table etablissement par l'intérmediaire de la table faculte-etablissement. 
 * @package Catalogue
 * @see Etablissement
 */
 class Faculte
 {
   /* Les attributs */
       
      /** @var integer L'identifiant de la faculté. */ 
      var $id;
      
      /** @var string Le nom de la faculté. */                    
      var $nom;
      
      /** @var string L'abréviation de la faculté. */                      
      var $abrv;                    
      
      /** @var integer La date d'ajout de la faculté. */ 
      var $timeStampAjout;          
      
      /** @var Etablissement[] La liste des établissement aux quels la faculté appartient. */
      var $etablissements;   

   /* Les méthodes */
   
     /**
      *Créer à partir de la base de données un objet Faculte dont l'identifiant est $id.
      *Remarque: l'attribut $etablissements n'est pas initialisé. Il doit être manuellement initialisé avec la méthode remplirEtab.
      *@static
      *@param integer $id L'identifiant de la faculté à charger.
      *@see remplirEtab() 
      *@return Faculte|NULL L'objet Faculte identifié par $id. NULL si un tel identifiant n'existe pas.  
      */ 
      function chargerFaculte($id)
      {
        /* Netoyage des variables d'entrées et récuperation de la faculté à partir de la BD */
         
         $sainBD['id']=mysql_real_escape_string(htmlentities($id,ENT_QUOTES,'UTF-8'));
         $faculteBD=mysql_fetch_array(mysql_query("select * from faculte where id='{$sainBD['id']}'"));
       
         if(!$faculteBD)
          return NULL; // Retourner NULL si l'identifiant n'existe pas dans la table Chapitre.
         else
         { 
           /* Instantiation et chargement du resultat dans l'objet faculte */
        
            $faculte=new Faculte;
            $faculte->id=stripslashes($sainBD['id']);
            $faculte->nom=stripslashes($faculteBD['nom']);
            $faculte->abrv=stripslashes($faculteBD['abrv']);
            $faculte->timeStampAjout=stripslashes($faculteBD['timestampajout']);
        
            return $faculte; //Retourner l'objet
         }       
      }
      
     /**
      *Ajouter une nouvelle faculté dans la base de données.
      *@static
      *@param string  $nom Le nom de la facuté à ajouter.
      *@param string  $abrv L'abréviation de la faculté à ajouter. Seules les caractéres alphanumériques et les caractéres spéciaux ". _ + -" 
      *sont autorisés. Ceci car l'abréviation est prévu pour être utilisé dans des noms de fichiers, comme ceux des contenus pédagogiques.  
      *@return integer L'identifiant de la nouvelle faculté s'elle a été ajouté avec succés. Sinon, -1 si le format de l'abréviation n'est pas respecté ou
      *0 dans si une faculté de même nom ou d'abréviation existe déjà.   
      */
      function ajouterFaculte($nom,$abrv)
      {
         /* Netoyage des variables d'entrées */
        
          $sainBD['nom']=mysql_real_escape_string(htmlentities($nom,ENT_QUOTES,'UTF-8'));
          $sainBD['abrv']=mysql_real_escape_string(htmlentities($abrv,ENT_QUOTES,'UTF-8'));
          
          if(!preg_match("#^[a-z0-9\._+-]+$#i",$sainBD['abrv']))
           return -1; /* L'abreviation sera utilisé dans des noms de fichiers. 
                         Elle doit respecter la présence stricte que de certains caractéres. */
          else
            //Ajout de données dans la BD table faculte
             mysql_query("INSERT INTO faculte VALUES('', '{$sainBD['nom']}', '{$sainBD['abrv']}','".time()."')") ; 
      
          return mysql_insert_id();    
      }
       
     /**
      *Lister les facultés contenus dans la base de données et les mettre dans un tableau d'objets de type Faculte.
      *@static
      *@param string $champsFaculte Format:"{id|nom|abrv|timestampajout}[,{id|nom|abrv|timestampajout}[,...]]". 
      *Ce paramétre contient le nom des attributs qui seront initialisés dans chaque objet du tableau retourné. 
      *Les autres attributs (sauf l'attribut $etablissements) seront mises à NULL. 
      *Exemple: "id,nom", si $c est un élément du tableau retourné, $c->id et $c->nom contiendront 
      *les informations correspondantes, mais $c->abrv et $c->timestampajout seront mises à NULL.   
      *
      *@param string $bornes Format:"[{entier1},{entier2}]". Si le paramètre est spécifié, la fonction retournera les {entier2}
      *premiers éléments a partir du {entier1}iéme résultat de la requête SQL. C'est le paramétre "LIMIT" de la requête SQL. 
      *Exemple: "1,15". On retourne le 2éme, 3éme,......, 16éme résulat de la requête.
      *
      *@param string $ordreFaculte Format:"[{id|nom|abrv|timestampajout}[,{id|nom|abrv|timestampajout}[,...]]]".
      *Ce paramètre décrit l'ordre des champs à respecter lors du tri du résultat.
      *Exemple: "abrv,nom". Le tri se fait par abréviation de faculté, puis par nom de faculté.
      *
      *@param integer $idEtablissement Une valeure O ou "" est équivalente à lister toutes les facultés. 
      *Pour les autres valeurs entières, seules les facultés appartenant à l'établissement identifié par ce paramètre 
      *($idEtablissement)seront listés. 
      *
      *@param string $champsEtablissement Format:"{id|nom|abrv|timestampajout}[,{id|nom|abrv|timestampajout}[,...]]". 
      *Ce paramétre contient le nom des attributs qui seront initialisés dans chaque élément de l'attribut tableau $etablissements. 
      *Les autres attributs seront mises à NULL. 
      *Exemple: "id,nom", si $c est un élément du tableau $etablissements, $c->id et $c->nom contiendront 
      *les informations correspondantes, mais $c->abrv, $c->timestampajout et $c->facultes seront mises à NULL.   
      *
      *@param string $ordreEtablissement Format:"[{id|nom|abrv|timestampajout}[,{id|nom|abrv|timestampajout}[,...]]]".
      *Ce paramètre décrit l'ordre des champs à respecter lors du tri de l'attribut tableau $etablissements.
      *Exemple: "abrv,nom". Le tri se fait par abréviation d'établissement, puis par nom d'établissement.
      *
      *@return Faculte[]|integer Un tableau contenant la liste des facultés si la requête n'a pas échoué. -1 dans le cas contraire.    
      */ 
      function listerFaculte($champsFaculte="id,nom,abrv,timestampajout",$bornes="0,30",$ordreFaculte="nom",$idEtablissement="0",$champsEtablissement="",
                             $ordreEtablissement="")
      {    
          //Récuperation de la déclaration des champs de la faculté 
           $champsT=explode(',',$champsFaculte);//Mettre chaque champs inclus pour la faculté comme un élément dans un tableau
           foreach($champsT as $clesChamps=>$elementChamps)
           {
            $elementChamps=chop($elementChamps,' '); //Enlever les espaces.
            $champsT[$clesChamps]="faculte.".$elementChamps." as {$elementChamps}F";
           }  
          
           if(!in_array("faculte.id as idF",$champsT)) $champsT[]="faculte.id as idF"; //Ajouter la déclaration de l'identifiant si elle n'existe pas.
          
          //Récuperation de la déclaration des etablissements
           if($champsEtablissement!="" || ($idEtablissement!="0" && $idEtablissement!=""))
           { 
           
            //Récuperation des champs de l'etablissement s'ils sont donnés            
             if($champsEtablissement!="")
             {
               $etablissementT=explode(',',$champsEtablissement);
               foreach($etablissementT as $clesEtablissement=>$elementEtablissement)
               {
                 $champsT[]="etablissement.".$elementEtablissement." as {$elementEtablissement}E";  
               }
             } 
            
            //Ajouter la condition where sur l'id de l'établissement s'il est donné
             if($idEtablissement!="0" && $idEtablissement!="")
             {
              $condition="where `faculte-etablissement`.idetablissement='$idEtablissement'";
             }
             
             //Récuperation de la jointure                               
              $jointure="RIGHT JOIN faculte ON faculte.id = `faculte-etablissement`.idfaculte
                         LEFT JOIN etablissement ON etablissement.id = `faculte-etablissement`.idetablissement";  
           
              $table="`faculte-etablissement`"; /*Selectionner la table faculte-etablissement (partie "FROM" de la requête) pour pouvoire faire la 
                                                  jointure avec etablissement .*/  
           }else
              $table="faculte"; //selectionner la table faculte dans la partie "FROM de la requete". Il n'y a pas de jointure à faire.
           
           //Reconstituer la chaine de caractére avec les deux déclarations des champs (faculté et etablissement).             
            $champs=implode(',',$champsT);
                                 
          /* Récuperation de la déclaration du tri et des bornes de recherche. */
          
           //Le tri pour les facultés
            if($ordreFaculte!="")
            {            
              $ordreT=explode(',',$ordreFaculte); 
              foreach($ordreT as $clesOrdre=>$elementOrdre)
              {
                $ordreT[$clesOrdre]="faculte.".$elementOrdre;
              }
                                          
            }
            
           //Le tri pour les etablissement
            if($champsEtablissement!="" && $ordreEtablissement!="") 
            {
             //Forcer l'ordre sur les facultés puis sur les établissements
              if($ordreFaculte=="") $ordreT[]="faculte.id";          
               
              $ordreEtabT=explode(',',$ordreEtablissement);
              foreach($ordreEtabT as $elementOrdre)
              {
               $ordreT[]="etablissement.".$elementOrdre;
              }
            
            } 
           
           //Ajout de la déclaration de tri et des bornes de recherche si elles existent
            if($ordreT!=NULL) $ordre="order by ".implode(',',$ordreT);
            if($bornes!="")   $bornes="LIMIT ".$bornes;
            
          /* Préparation de la requête de listage des facultés à partir de la BD 
                 et création d'un tableau contenant la liste des facultés     */
    
            if(!$faculteQ=mysql_query("select $champs from $table $jointure $condition $ordre $bornes"))
              return -1; //Retourner -1 si la requête est malformée.
            
            $tabFaculte=array();
                        
           //Récupération des facultés à partir de la BD
            $faculteR=mysql_fetch_array($faculteQ);
            $faculteActuelle='';
                        
            while ($faculteR)
            {
           
              //Récuperation de la faculté dans un objet Faculte
               $faculte=new Faculte;
               $faculteActuelle=$faculteR['idF'];
               $faculte->id=$faculteR['idF'];
               $faculte->nom=stripslashes($faculteR['nomF']);
               $faculte->abrv=stripslashes($faculteR['abrvF']);
               $faculte->timeStampAjout=stripslashes($faculteR['timestampajoutF']);
             
              //Récuperation des établissements dont la faculté appartient  
               while($faculteR && $faculteActuelle==$faculteR['idF']) 
               { 
                $etablissement= new Etablissement;
                $etablissement->id=$faculteR['idE']; 
                $etablissement->nom=$faculteR['nomE'];
                $etablissement->abrv=$faculteR['abrvE'];
                $etablissement->timeStampAjout=$faculteR['timestampajoutE'];
                $faculte->etablissements[]=$etablissement;
               
                $faculteR=mysql_fetch_array($faculteQ);                
               }
             
               $tabFaculte[]=$faculte; //Ajout de l'objet faculte dans le tableau à retourner
             
            }
            
           return $tabFaculte; //Retourner le tableau            
      }
      
       
     /**
      *Modifier les informations d'une faculté dans la base de données.
      *L'attribut $id contient l'identifiant de la faculté à modifier. 
      *Les attributs $nom, $abrv et $timestampajout contiennent les modifications à apporter. 
      *Il faut passer par la méthode ajouterAEtab ou enleverDeEtab pour modifier les informations dans la table faculte-etablissement. 
      *@see Faculte::ajouterAEtab(), Faculte::enleverDeEtab() 
      *@return integer 1 si la faculté a été modifié avec succés. 0 dans le cas où les nouvelles et anciennes valeurs 
      *sont identiques. -1 si le format de la nouvelle abréviation n'est pas respecté(Seules les caractéres alphanumériques et les caractéres spéciaux 
      * ". _ + -" sont autorisés pour l'abréviation).   
      */ 
      function modifierFaculte()
      {   
         /* Netoyage des variables */  
        
          $sainBD["id"]=mysql_real_escape_string(htmlentities($this->id,ENT_QUOTES,'UTF-8'));
          $sainBD["nom"]=stripslashes(mysql_real_escape_string(htmlentities($this->nom,ENT_QUOTES,'UTF-8')));
          $sainBD["abrv"]=mysql_real_escape_string(htmlentities($this->abrv,ENT_QUOTES,'UTF-8'));
         
          if(!preg_match("#^[a-z0-9\._+-]+$#i",$sainBD['abrv']))
            return -1; /* L'abreviation sera utilisé dans des noms de fichiers. 
                         Elle doit respecter la présence stricte que de certains caractéres. */
          else
         // Modification de la faculte dans la BD
          mysql_query("UPDATE faculte SET abrv='{$sainBD["abrv"]}' ,nom='{$sainBD["nom"]}' WHERE id='{$sainBD["id"]}'");
       
          
          return mysql_affected_rows(); 
      }              
      
     /**
      *Supprimer la faculté identifiée par $id de la base de données.
      *@static
      *@param integer $id L'identifiant de la faculté à supprimer.
      *@return integer 1 si la faculté a été supprimé avec succés. 0 dans le cas contraire.   
      */
      function supprimerFaculte($id)
      {
         $sainBD['id']=mysql_real_escape_string(htmlentities($id,ENT_QUOTES,'UTF-8')); // Netoyage de la variable d'entrée
         mysql_query("delete from faculte where id='{$sainBD['id']}'"); // Suppression de la faculté
      
         return mysql_affected_rows();
      }  
       
     /**
      *Ajouter la faculté à un établissement.
      *@param  integer $idEtab l'identifiant de l'établissement au quel la faculé va appartenir.
      *@see Faculte::enleverDeEtab()
      *@return integer 1 si la faculté a été ajouté avec succés. -1 dans le cas où la faculté existe déjà dans l'établissement.
      */ 
      function ajouterAEtab($idEtab)
      {
       /* Netoyage de la variable d'entrée et ajout de la faculté à l'etablissement */
        
        $sainBD['idEtab']=mysql_real_escape_string(htmlentities($idEtab,ENT_QUOTES,'UTF-8'));
        $sainBD['id']=mysql_real_escape_string(htmlentities($this->id,ENT_QUOTES,'UTF-8'));
        
        mysql_query("INSERT INTO `faculte-etablissement` VALUES('', '{$sainBD['id']}', '{$sainBD['idEtab']}')");
      
        return mysql_affected_rows();
      }  
      
     /**
      *Enlever la faculté d'un établissement.
      *@param  integer $idEtab l'identifiant de l'établissement au quel la faculé ne va plus appartenir.
      *@see Faculte::ajouterAEtab()
      *@return integer 1 si la faculté a été enlevé avec succés. 0 dans le cas où la faculté n'existe pas dans l'établissement.
      */ 
      function enleverDeEtab($idEtab)  
      {
       /* Nettoyage des variable */
        
         $sainBD['idEtab']=mysql_real_escape_string(htmlentities($idEtab,ENT_QUOTES,'UTF-8')); 
         $sainBD['id']=mysql_real_escape_string(htmlentities($this->id,ENT_QUOTES,'UTF-8'));
         
       //Suppression de la faculté de l'établissement   
         mysql_query("DELETE FROM `faculte-etablissement` WHERE idfaculte='{$sainBD['id']}' AND idetablissement='{$sainBD['idEtab']}'"); 
         
         return mysql_affected_rows();  
      }

     /**
      *Remplir le tableau $etablissements avec les établissements aux quels la faculté appartient.
      *@param  string $ordreEtablissement Format:"[{id|nom|abrv|timestampajout}[,{id|nom|abrv|timestampajout}[,...]]]".
      *Ce paramètre décrit l'ordre des champs de la table établissement à repecter lors du tri du résultat.
      */ 
      function remplirEtab($ordreEtablissement="nom")
      {
         //Netoyage de la variable $this->id 
          $sainBD['id']=mysql_real_escape_string(htmlentities($this->id,ENT_QUOTES,'UTF-8'));
        
         //Vider le tableau des établissements
          unset($this->etablissements);
        
         //Récuperation du tri des etablissements dont la faculté appartient
          if($ordreEtablissement!="")
          {            
             $ordreT=explode(',',$ordreEtablissement); 
             foreach($ordreT as $clesOrdre=>$elementOrdre)
             {
               $ordreT[$clesOrdre]="etablissement.".$elementOrdre;
             }
             $ordreEtablissement="order by ".implode(',',$ordreT);                            
          }
            
         //Construction de la requête SQL
          $etablissementQ=mysql_query("select etablissement.id, etablissement.nom, etablissement.abrv, etablissement.timestampajout from 
                                      faculte,`faculte-etablissement`, etablissement where faculte.id='{$sainBD['id']}' 
                                      AND faculte.id=`faculte-etablissement`.idfaculte AND etablissement.id=`faculte-etablissement`.idetablissement
                                       $ordreEtablissement");
       
         //Mettre les elements de la requête dans le tableau etablissements 
          while(list($id,$nom,$abrv,$timestampajout)=mysql_fetch_array($etablissementQ))
          {
           $etablissement=new Etablissement;
           $etablissement->id=$id;
           $etablissement->nom=$nom;
           $etablissement->abrv=$abrv;
           $etablissement->timeStampAjout=$timestampajout;
           
           $this->etablissements[]=$etablissement; 
          }   
      
      }         
 }
?>
