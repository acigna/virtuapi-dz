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
  * Fichier contenant la classe Etablissement.
  */
 
/**
 *  Inclure les autres classes (Faculte,..).  
 *  Ils sont nécessaires pour le fonctionnement de la classe Etablissement.
 */
require_once "classes.php";
/*******************************************************************************************************************/
/*******************************************************************************************************************/
/********************************************CLASSE ETABLISSEMENT***************************************************/
/*******************************************************************************************************************/
/*******************************************************************************************************************/

/**
 * Classe pour gérer la table etablissement et sa relation avec la table faculte-etablissement. 
 * Elle est utilisée pour l'ajout, la modification, la suppression, et la lecture d'éléments à partir
 * de la table etablissement. Elle est aussi utilisée aussi pour l'ajout et la suppression à partir de la table 
 * faculte-etablissement, ainsi que la lecture d'éléments de la table faculte par l'intérmediaire de la table faculte-etablissement. 
 * @package Catalogue
 * @see Faculte
 */
 class Etablissement
 {
    /* Les attributs */
    
      /** @var integer L'identifiant de l'établissement. */
      var $id;               
      
      /** @var string Le nom de l'établissement. */
      var $nom;              
      
      /** @var string L'abréviation de l'établissement. */
      var $abrv;             
      
      /** @var integer La date d'ajout de l'établissement. */
      var $timeStampAjout;   
      
      /** @var Faculte[] La liste des facultés de l'établissement. */
      var $facultes;         
      
    /* Les méthodes */
   
     /**
      *Créer à partir de la base de données un objet Etablissement dont l'identifiant est $id.
      *Remarque: l'attribut $facultes n'est pas initialisé. Il doit être manuellement initialisé avec la méthode remplirFaculte. 
      *@static
      *@param integer $id L'identifiant de l'établissement à charger. 
      *@see remplirFaculte()
      *@return Etablissement|NULL L'objet Etablissement identifié par $id. NULL si un tel identifiant n'existe pas.  
      */
      function chargerEtablissement($id)
      {
        /* Netoyage des variables d'entrées et récuperation de l'établissement à partir de la BD */
         
         $sainBD['id']=mysql_real_escape_string(htmlentities($id,ENT_QUOTES,'UTF-8'));
         $etablissementBD=mysql_fetch_array(mysql_query("select * from etablissement where id='{$sainBD['id']}'"));
         if(!$etablissementBD)
          return NULL; // Retourner NULL si l'identifiant n'existe pas dans la table Chapitre.
         else
         { 
          /* Instantiation et chargement du resultat dans l'objet etablissement */
        
           $etablissement=new Etablissement;
           $etablissement->id=$sainBD['id'];
           $etablissement->nom=$etablissementBD['nom'];
           $etablissement->abrv=$etablissementBD['abrv'];
           $etablissement->timeStampAjout=$etablissementBD['timestampajout'];
                                        
           return $etablissement;//Retourner l'objet
         }        
      }
      
     /**
      *Ajouter un nouveau établissement dans la base de données.
      *@static
      *@param string  $nom Le nom de l'établissement à ajouter.
      *@param string  $abrv L'abréviation de l'établissement à ajouter. Seules les caractéres alphanumériques et les caractéres spéciaux ". _ + -" 
      *sont autorisés. Ceci car l'abréviation est prévu pour être utilisé dans des noms de fichiers, comme ceux des contenus pédagogiques.  
      *@return integer L'identifiant du nouveau établissement s'il a été ajouté avec succés. Sinon, -1 si le format de l'abréviation n'est pas respecté ou
      *0 si un établissement de même nom ou d'abréviation existe déjà.   
      */
      function ajouterEtablissement($nom,$abrv)
      {
        /* Netoyage des variables d'entrées */
       
         $sainBD['nom']=mysql_real_escape_string(htmlentities($nom,ENT_QUOTES,'UTF-8'));
         $sainBD['abrv']=mysql_real_escape_string(htmlentities($abrv,ENT_QUOTES,'UTF-8'));
        
         if(!preg_match("#^[a-z0-9\._+-]+$#i",$sainBD['abrv']))
          return -1; /* L'abreviation sera utilisé dans des noms de fichiers. 
                        Elle doit respecter la présence stricte que de certains caractéres. */
         else
           //Ajout de données dans la BD table etablissement
            mysql_query("INSERT INTO etablissement VALUES('', '{$sainBD['nom']}', '{$sainBD['abrv']}','".time()."')");
      
         return mysql_insert_id(); 
      }
       
     /**
      *Lister les établissements contenus dans la base de données et les mettre dans un tableau d'objets de type Etablissement.
      *@static
      *@param string $champsEtablissement Format:"{id|nom|abrv|timestampajout}[,{id|nom|abrv|timestampajout}[,...]]". 
      *Ce paramétre contient le nom des attributs qui seront initialisés dans chaque objet du tableau retourné. 
      *Les autres attributs (sauf l'attribut $facultes) seront mises à NULL. 
      *Exemple: "id,nom", si $c est un élément du tableau retourné, $c->id et $c->nom contiendront 
      *les informations correspondantes, mais $c->abrv et $c->timestampajout seront mises à NULL.   
      *
      *@param string $bornes Format:"[{entier1},{entier2}]". Si le paramètre est spécifié, la fonction retournera les {entier2}
      *premiers éléments a partir du {entier1}iéme résultat de la requête SQL. C'est le paramétre "LIMIT" de la requête SQL. 
      *Exemple: "1,15". On retourne le 2éme, 3éme,......, 16éme résulat de la requête.
      *
      *@param string $ordreEtablissement Format:"[{id|nom|abrv|timestampajout}[,{id|nom|abrv|timestampajout}[,...]]]".
      *Ce paramètre décrit l'ordre des champs à respecter lors du tri du résultat.
      *Exemple: "abrv,nom". Le tri se fait par abréviation d'établissement, puis par nom d'établissement.
      *
      *@param integer $idFaculte Une valeure O ou "" est équivalente à lister tous les établissements. 
      *Pour les autres valeurs entières, seules les établissements contenant la faculté identifiée par ce paramètre 
      *($idfaculté)seront listés. 
      *
      *@param string $champsFaculte Format:"{id|nom|abrv|timestampajout}[,{id|nom|abrv|timestampajout}[,...]]". 
      *Ce paramétre contient le nom des attributs qui seront initialisés dans chaque élément de l'attribut tableau $facultes. 
      *Les autres attributs seront mises à NULL. 
      *Exemple: "id,nom", si $c est un élément du tableau $facultes, $c->id et $c->nom contiendront 
      *les informations correspondantes, mais $c->abrv, $c->timestampajout et $c->etablissements seront mises à NULL.   
      *
      *@param string $ordreFaculte Format:"[{id|nom|abrv|timestampajout}[,{id|nom|abrv|timestampajout}[,...]]]".
      *Ce paramètre décrit l'ordre des champs à respecter lors du tri de l'attribut tableau $facultes.
      *Exemple: "abrv,nom". Le tri se fait par abréviation de faculté, puis par nom de faculté.
      *
      *@return Etablissement[]|integer Un tableau contenant la liste des établissements si la requête n'a pas échoué. -1 dans le cas contraire.    
      */ 
      function listerEtablissement($champsEtablissement="id,nom,abrv,timestampajout",$bornes="0,30",$ordreEtablissement="nom",$idFaculte="0",
                                   $champsFaculte="", $ordreFaculte="")
      {
    
         // Récuperation de la déclaration des champs de l'établissement 
           $champsT=explode(',',$champsEtablissement);//Mettre chaque champs inclus pour l'établissement comme un élément dans un tableau
           foreach($champsT as $clesChamps=>$elementChamps)
           {
            $elementChamps=chop($elementChamps,' '); //Enlever les espaces.
            $champsT[$clesChamps]="etablissement.".$elementChamps." as {$elementChamps}E";
           }  
               
         //Ajouter la déclaration de l'identifiant si elle n'existe pas  
          if(!in_array("etablissement.id as idE",$champsT)) $champsT[]="etablissement.id as idE"; 
         
         //Récuperation de la déclaration des facultés
          if($champsFaculte!="" || ($idFaculte!="0" && $idFaculte!=""))
          { 
                     
           //Récuperation des champs de la faculté s'ils sont donnés 
            if($champsFaculte!="")
            {              
               $faculteT=explode(',',$champsFaculte);
               foreach($faculteT as $clesFaculte=>$elementFaculte)
               {
                 $champsT[]="faculte.".$elementFaculte." as {$elementFaculte}F";  
               }
            } 
            
           //Ajouter la condition where sur l'id de la faculté s'il est donné
            if($idFaculte!="0" && $idFaculte!="")
            {
             $condition="where `faculte-etablissement`.idfaculte='$idFaculte'";
            }
             
             //Récuperation de la jointure                               
              $jointure="LEFT JOIN faculte ON faculte.id = `faculte-etablissement`.idfaculte
                         RIGHT JOIN etablissement ON etablissement.id = `faculte-etablissement`.idetablissement";  
           
              $table="`faculte-etablissement`"; /*Selectionner la table faculte-etablissement (partie "FROM" de la requête) pour pouvoire faire la 
                                                  jointure avec faculte .*/  
           }else
             $table="etablissement"; //selectionner la table etablissement dans la partie "FROM de la requete". Il n'y a pas de jointure à faire.        
        
           //Reconstituer la chaine de caractére avec les deux déclarations des champs (faculté et etablissement).             
            $champs=implode(',',$champsT);
            
          /* Récuperation de la déclaration du tri et des bornes de recherche. */
          
           //Le tri pour les établissements
            if($ordreEtablissement!="")
            {            
              $ordreT=explode(',',$ordreEtablissement); 
              foreach($ordreT as $clesOrdre=>$elementOrdre)
              {
                $ordreT[$clesOrdre]="etablissement.".$elementOrdre;
              }
        
            }
            
           //Le tri pour les facultés
            if($champsFaculte!="" && $ordreFaculte!="") 
            {
               //Forcer l'ordre sur les établissements puis sur les facultés
                if($ordreEtablissement=="") $ordreT[]="etablissement.id";          
               
                $ordreFacT=explode(',',$ordreFaculte);
                foreach($ordreFacT as $elementOrdre)
                {
                 $ordreT[]="faculte.".$elementOrdre;
                }
        
            } 
          
           //Ajout de la déclaration de tri et des bornes de recherche si elles existent
            if($ordreT!=NULL) $ordre="order by ".implode(',',$ordreT);
            if($bornes!="")   $bornes="LIMIT ".$bornes; 
    
    
           /* Préparation de la requête de listage des établissements à partir de la BD 
                 et création d'un tableau contenant la liste des facultés     */
    
            if(!$etablissementQ=mysql_query("select $champs from $table $jointure $condition $ordre $bornes"))
              return -1; //Retourner -1 si la requête est malformée.
            
            $tabEtablissement=array();
                           
           //Récupération des facultés à partir de la BD
            $etablissementR=mysql_fetch_array($etablissementQ);
            $etablissementActuelle='';
           
           /* Récupération des établissements à partir de la BD */ 
           
            while ($etablissementR)
            {           
               //Récuperation de la faculté dans un objet Faculte
                $etablissement= new Etablissement;
                $etablissementActuelle=$etablissementR['idE'];
                $etablissement->id=$etablissementR['idE']; 
                $etablissement->nom=$etablissementR['nomE'];
                $etablissement->abrv=$etablissementR['abrvE'];
                $etablissement->timeStampAjout=$etablissementR['timestampajoutE'];
                            
               //Récuperation des établissements dont la faculté appartient  
                while($etablissementR && $etablissementActuelle==$etablissementR['idE']) 
                {
                 $faculte=new Faculte;
                 $faculte->id=$etablissementR['idF'];
                 $faculte->nom=stripslashes($etablissementR['nomF']);
                 $faculte->abrv=stripslashes($etablissementR['abrvF']);
                 $faculte->timeStampAjout=stripslashes($etablissementR['timestampajoutF']);
                 $etablissement->facultes[]=$faculte;
                
                 $etablissementR=mysql_fetch_array($etablissementQ);                
                }
             
                $tabEtablissement[]=$etablissement; //Ajout de l'objet etablissement dans le tableau à retourner
             
            }
            
           return $tabEtablissement; //Retourner le tableau             
       }
     
     /**
      *Modifier les informations d'un établissement dans la base de données.
      *L'attribut $id contient l'identifiant de l'établissement à modifier. 
      *Les attributs $nom, $abrv et $timestampajout contiennent les modifications à apporter. 
      *Il faut passer par la méthode ajouterFac ou enleverFac pour modifier les informations dans la table faculte-etablissement. 
      *@return integer 1 si l'établissement a été modifié avec succés. 0 dans le cas où les nouvelles et anciennes valeurs 
      *sont identiques. -1 si le format de la nouvelle abréviation n'est pas respecté(Seules les caractéres alphanumériques et les caractéres spéciaux 
      * ". _ + -" sont autorisés pour l'abréviation). 
      *@see Etablissement::ajouterFac(), Etablissement::enleverFac()
      */ 
      function modifierEtablissement()
      {   
         /* Netoyage des variables */  
        
          $sainBD["id"]=mysql_real_escape_string(htmlentities($this->id,ENT_QUOTES,'UTF-8'));
          $sainBD["nom"]=mysql_real_escape_string(htmlentities($this->nom,ENT_QUOTES,'UTF-8'));
          $sainBD["abrv"]=mysql_real_escape_string(htmlentities($this->abrv,ENT_QUOTES,'UTF-8'));
  
          if(!preg_match("#^[a-z0-9\._+-]+$#i",$sainBD['abrv']))
           return -1; /* L'abreviation sera utilisé dans des noms de fichiers. 
                         Elle doit respecter la présence stricte que de certains caractéres. */
          else
           // Modification de l'établissement dans la BD
           mysql_query("UPDATE etablissement SET abrv='{$sainBD["abrv"]}' ,nom='{$sainBD["nom"]}' WHERE id='{$sainBD["id"]}'");
       
          return mysql_affected_rows(); 
      }              
  
     /**
      *Supprimer l'établissement identifié par $id de la base de données.
      *@static
      *@param integer $id L'identifiant de l'établissement à supprimer.
      *@return integer 1 si l'établissement a été supprimé avec succés. 0 dans le cas contraire.   
      */
      function supprimerEtablissement($id)
      {
         $sainBD['id']=mysql_real_escape_string(htmlentities($id,ENT_QUOTES,'UTF-8')); // Netoyage la variable d'entrée
         mysql_query("delete from etablissement where id='{$sainBD['id']}'"); // Suppression de l'établissement
     
         return mysql_affected_rows();
      }
       
     /**
      *Ajouter une faculté à l'établissement.
      *@param  integer $idFac l'identifiant de la faculté à ajouter.
      *@see Etablissement::enleverFac()
      *@return integer 1 si la faculté a été ajouté avec succés. -1 dans le cas où la faculté existe déjà dans l'établissement.
      */ 
      function ajouterFac($idFac)
      {
        
         $sainBD['idFac']=mysql_real_escape_string(htmlentities($idFac,ENT_QUOTES,'UTF-8')); // Netoyage de la variable d'entrée
         $sainBD['id']=mysql_real_escape_string(htmlentities($this->id,ENT_QUOTES,'UTF-8')); // Netoyage de la variable $this->id 
         
        // Ajout de la faculte
         mysql_query("INSERT INTO `faculte-etablissement` VALUES('', '{$sainBD['idFac']}', '{$sainBD['id']}')") ;

         return mysql_affected_rows();
      }
 
     /**
      *Enlever une faculté de l'établissement.
      *@see Etablissement::ajouterFac()
      *@param  integer $idFac l'identifiant de la faculté à enlever.
      *@return integer 1 si la faculté a été enlevé avec succés. 0 dans le cas où la faculté n'existe pas dans l'établissement.
      */ 
      function enleverFac($idFac)  
      {
        /* Nettoyage des variables */
        
         $sainBD['idFac']=mysql_real_escape_string(htmlentities($idFac,ENT_QUOTES,'UTF-8')); 
         $sainBD['id']=mysql_real_escape_string(htmlentities($this->id,ENT_QUOTES,'UTF-8'));
         
        //Suppression de la faculté de l'établissement 
         mysql_query("DELETE FROM `faculte-etablissement` WHERE idetablissement='{$sainBD['id']}' AND idfaculte='{$sainBD['idFac']}'"); 
         
         return mysql_affected_rows();  
      }
           
     /**
      *Remplir le tableau $facultes avec les facultés appartenant à cet etablissement.
      *@param  string $ordreFaculte Format:"[{id|nom|abrv|timestampajout}[,{id|nom|abrv|timestampajout}[,...]]]".
      *Ce paramètre décrit l'ordre des champs de la table faculte à repecter lors du tri du résultat.
      */ 
      function remplirFaculte($ordreFaculte="nom")
      {
        //Netoyage de la variable $this->id
         $sainBD['id']=mysql_real_escape_string(htmlentities($this->id,ENT_QUOTES,'UTF-8'));
         
        //Vider le tableau des établissements
         unset($this->etablissements);
    
        //Récuperation du tri des facultés de l'etablissement
         if($ordreFaculte!="")
         {            
            $ordreT=explode(',',$ordreFaculte); 
            foreach($ordreT as $clesOrdre=>$elementOrdre)
            {
              $ordreT[$clesOrdre]="faculte.".$elementOrdre;
            }
            $ordreFaculte="order by ".implode(',',$ordreT);                            
         } 
            
        //Construction de la requête SQL
         $faculteQ=mysql_query("select faculte.id, faculte.nom, faculte.abrv, faculte.timestampajout from 
                                faculte,`faculte-etablissement`, etablissement where etablissement.id='{$sainBD['id']}' 
                                AND faculte.id=`faculte-etablissement`.idfaculte AND etablissement.id=`faculte-etablissement`.idetablissement
                                $ordreFaculte");
        
        //Mettre les elements de la BD dans le tableau facultes de l'objet etablissement 
         while(list($id,$nom,$abrv,$timestampajout)=mysql_fetch_array($faculteQ))
         {
           $faculte=new Faculte;
           $faculte->id=$id;
           $faculte->nom=$nom;
           $faculte->abrv=$abrv;
           $faculte->timeStampAjout=$timestampajout;
           
           $this->facultes[]=$faculte; 
         }
      }          
 
                    
 }

?>
