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
  *Fichier contenant la classe Annee.
  */

/**
 *  Inclure les autres classes (Cycle,Faculte,..).  
 *  Ils sont nécessaires pour le fonctionnement de la classe Annee.
 */
require_once "classes.php";
/*******************************************************************************************************************/
/*******************************************************************************************************************/
/************************************************CLASSE ANNEE*******************************************************/
/*******************************************************************************************************************/
/*******************************************************************************************************************/ 
/**
 * Classe pour gérer la table annee. 
 * Elle est utilisée pour l'ajout, la modification, la suppression, et la lecture d'éléments à partir
 * de la table annee.     
 * @package Catalogue
 * @see Cycle, Module, Faculte, Etablissement 
 */
 class Annee
 {
    /* Les attributs */
    
      /** @var integer L'identifiant de l'année.    */
      var $id;               
      
      /** @var Faculte La faculté à laquelle l'année appartient.    */      
      var $faculte;         
      
      /** @var Etablissement L'établissement auquel l'année appartient.    */      
      var $etablissement;    
      
      /** @var integer Le numéro de l'année.  */
      var $numAnnee;        
      
      /** @var Cycle Le cycle auquel l'année appartient. */
      var $cycle;            
      
      /** @var string La branche à laquelle l'année.  */
      var $branche;   
      
      /** @var integer La date d'ajout de l'année.  */
      var $timeStampAjout;   
      
    /* Les méthodes */
   
     /**
      *Créer à partir de la base de données un objet Annee dont l'identifiant est $id.
      *@static
      *@param integer $id L'identifiant de l'année à charger. 
      *@return Annee|NULL L'objet Annee identifié par $id. NULL si un tel identifiant n'existe pas.  
      */
      function chargerAnnee($id)
      {
        /* Netoyage des variables d'entrées et récuperation de la faculté à partir de la BD */
         
           $sainBD['id']=mysql_real_escape_string(htmlentities($id,ENT_QUOTES,'UTF-8'));
           $anneeBD=mysql_fetch_array(mysql_query("
                                                   SELECT A.numannee,A.branche,A.timestampajout,
                                                          F.id,F.nom,F.abrv,F.timestampajout,
                                                          E.id,E.nom,E.abrv,E.timestampajout, 
                                                          C.id,C.code,C.nom
                                                   FROM annee A,cycle C,faculte F,etablissement E,`faculte-etablissement` FE
                                                   WHERE      A.`idfac-etab`     = FE.id
                                                          AND FE.idetablissement = E.id 
                                                          AND FE.idfaculte       = F.id 
                                                          AND A.idcycle          = C.id 
                                                          AND A.id               = '{$sainBD['id']}'"));
        
       
        
           if(!$anneeBD)
             return NULL; // Retourner NULL si l'identifiant n'existe pas dans la table Chapitre.
           else
           { 
             /* Instantiation et chargement du resultat dans l'objet faculté */
        
                $faculte=new Faculte;
                $faculte->id=stripslashes($anneeBD[3]);  
                $faculte->nom=stripslashes($anneeBD[4]);
                $faculte->abrv=stripslashes($anneeBD[5]);
                $faculte->timeStampAjout=stripslashes($anneeBD[6]);
           
             /* Instantiation et chargement du resultat dans l'objet établissement */
        
                $etablissement=new Etablissement;
                $etablissement->id=stripslashes($anneeBD[7]);  
                $etablissement->nom=stripslashes($anneeBD[8]);
                $etablissement->abrv=stripslashes($anneeBD[9]);
                $etablissement->timeStampAjout=stripslashes($anneeBD[10]);
           
             /* Instantiation et chargement du resultat dans l'objet cycle */       
           
                $cycle=new Cycle;
                $cycle->id=stripslashes($anneeBD[11]);  
                $cycle->code=stripslashes($anneeBD[12]);
                $cycle->nom=stripslashes($anneeBD[13]);
         
                  
             /* Instantiation et chargement du resultat dans l'objet annee */   
       
                $annee=new Annee;
                $annee->id=stripslashes($sainBD['id']); 
                $annee->faculte=$faculte;
                $annee->etablissement=$etablissement;
                $annee->numAnnee=stripslashes($anneeBD[0]);
                $annee->cycle=$cycle;
                $annee->branche=stripslashes($anneeBD[1]); 
                $annee->timeStampAjout=stripslashes($anneeBD[2]);
       
                return $annee; // Retourner l'objet
           }   
               
      }
      
     /**
      *Ajouter une nouvelle année dans la base de données.
      *@static
      *@param integer $idFacEtab l'identifiant de la faculté-établissement à laquel l'année appartient.
      *@param integer $numAnnee  Le numéro de l'année.
      *@param integer  $idCycle   L'identifiant du cycle auquel l'année appartient. 
      *@param string  $branche   La branche à laquelle l'année appartient.
      *@return integer L'identifiant de la nouvelle année si elle a été ajouté avec succés. 0 dans le cas contraire.   
      */
      function ajouterAnnee($idFacEtab,$numAnnee,$idCycle,$branche)
      {
         /* Netoyage des variables d'entrées */
        
          $sainBD['idfac-etab']=mysql_real_escape_string(htmlentities($idFacEtab,ENT_QUOTES,'UTF-8'));
          $sainBD['numAnnee']=mysql_real_escape_string(htmlentities($numAnnee,ENT_QUOTES,'UTF-8'));
          $sainBD['idCycle']=mysql_real_escape_string(htmlentities($idCycle,ENT_QUOTES,'UTF-8'));
          $sainBD['branche']=mysql_real_escape_string(htmlentities($branche,ENT_QUOTES,'UTF-8'));
          
         /* Ajout de données dans la BD table annee */
          
           mysql_query("INSERT INTO annee VALUES('', '{$sainBD['idfac-etab']}', '{$sainBD['numAnnee']}','{$sainBD['idCycle']}',
                                                 '{$sainBD['branche']}','".time()."')"); 
          
          return mysql_insert_id();
      }
      
      
     /**
      *Lister les années contenus dans la base de données et les mettre dans un tableau d'objets de type Annee.
      *
      * 
      *@static
      *@param string $champsAnnee Format:"{id|numannee|branche|timestampajout}[,{id|numannee|branche|timestampajout}[,...]]". 
      *Ce paramétre contient le nom des attributs qui seront initialisés dans chaque objet du tableau retourné. 
      *Les autres attributs(sauf l'attribut $etablissement,$faculte et $annee) seront mises à NULL. 
      *Exemple: "id,numannee", si $c est un élément du tableau retourné, $c->id et $c->numAnnee contiendront 
      *les informations correspondantes, mais $c->branche et $c->timeStampAjout seront mises à NULL.   
      *
      *@param string $bornes Format:"[{entier1},{entier2}]". Si le paramètre est spécifié, la fonction retournera les {entier2}
      *premiers éléments a partir du {entier1}iéme résultat de la requête SQL. C'est le paramétre "LIMIT" de la requête SQL. 
      *Exemple: "1,15". On retourne le 2éme, 3éme,......, 16éme résulat de la requête.
      *
      *
      *@param integer $idEtablissement Une valeure O ou "" est équivalente à lister les années sans se restreindre à un établissement particulièr. 
      *Pour les autres valeurs entières, seules les années appartenant à l'établissement identifié par ce paramètre 
      *($idEtablissement)seront listés. 
      *
      *@param integer $idFaculte Une valeure O ou "" est équivalente à lister les années sans se restreindre à une faculté particulière. 
      *Pour les autres valeurs entières, seules les années appartenant à la faculté identifiée par ce paramètre 
      *($idFaculte)seront listés. 
      *
      *@param string $champsFaculte Format:"{id|nom|abrv|timestampajout}[,{id|nom|abrv|timestampajout}[,...]]". 
      *Ce paramétre contient le nom des attributs qui seront initialisés dans l'attribut $faculte. 
      *Les autres attributs seront mises à NULL. 
      *Exemple: "id,nom", si $c est un élément du tableau retourné, $c->faculte->id et $c->faculte->nom contiendront 
      *les informations correspondantes, mais $c->faculte->abrv, $c->faculte->timeStampAjout et $c->faculte->etablissements seront mises à NULL.
      *
      *@param string $champsEtablissement Format:"{id|nom|abrv|timestampajout}[,{id|nom|abrv|timestampajout}[,...]]". 
      *Ce paramétre contient le nom des attributs qui seront initialisés dans l'attribut $faculte. 
      *Les autres attributs seront mises à NULL. 
      *Exemple: "id,nom", si $c est un élément du tableau retourné, $c->etablissement->id et $c->etablissement->nom contiendront 
      *les informations correspondantes, mais $c->etablissement->abrv, $c->etablissement->timeStampAjout 
      *et $c->etablissement->facultes seront mises à NULL.
      *
      *@param string $ordre Format: "[{id|numannee|branche|timestampajout|c.{id|code|nom}|e.{id|nom|abrv|timestampajout}|f.{id|nom|abrv|timestampajout}}
      *[,{id|numannee|branche|timestampajout|c.{id|code|nom}|e.{id|nom|abrv|timestampajout}|f.{id|nom|abrv|timestampajout}}[,..]]]".Ce paramètre décrit 
      *l'ordre des champs à respecter lors du tri du résultat. Les préfixes "c." (cycle), "e." (etablissement), "f." (faculte) peuvent être 
      *utilisés pour spécifier la table à laquelle appartient ce champs. Exemple: "numannee,e.nom". Le tri se fait par numéro d'année, puis par nom 
      *d'établissement.
      *
      *
      *
      *@param string $champsCycle Format:"{id|code|nom}[,{id|code|nom}[,...]]".
      *Ce paramétre contient le nom des attributs qui seront initialisés dans l'attribut $cycle. 
      *Les autres attributs seront mises à NULL. 
      *Exemple: "id,nom", si $c est un élément du tableau retourné, $c->cycle->id et $c->cycle->nom contiendront 
      *les informations correspondantes, mais $c->cycle->code sera mise à NULL.   
      *
      *@return Annee[]|integer Un tableau contenant la liste des années. si la requête n'a pas échoué. -1 dans le cas contraire.   
      */
      function listerAnnee( $champsAnnee="id,numannee,branche,timestampajout",
                            $bornes="0,30",
                            $ordre="c.code,numannee",
                            $idFaculte="0",
                            $idEtablissement="0", 
                            $champsFaculte="nom",
                            $champsEtablissement="abrv",
                            $champsCycle="nom" )
                            
      { 
            $conditionFE=false; // Variable indiquant si une jointure avec faculte-etablissement est nécessaire 
            
          // Initialisation des tableaux de déclaration de condition et des tables
           
            $conditionT=array(" Where A.idcycle = C.id ");
            $tablesT=array(" annee A,cycle C ");
         
         /* Récuperation de la déclaration des champs de l'année */
            
            $champsT=explode(',',$champsAnnee); // Mettre chaque champs comme un élément dans un tableau
            foreach($champsT as $clesChamps=>$elementChamps)
            {
                $elementChamps=chop($elementChamps,' '); // Enlever les espaces
                $champsT[$clesChamps]="A.".$elementChamps." as {$elementChamps}A";  
            }  
          
          // Verification l'inclusion de la faculté ds la requete
                        
            if($champsFaculte!="" || ($idFaculte!="0"&& $idFaculte!=""))
            { 
              $conditionFE=true;
              $tablesT[]="faculte F";
              $conditionT[]=" FE.idfaculte = F.id ";
          
              if($champsFaculte!="")
              {
                 /* Récuperation de la déclaration des champs de la faculté */
            
                 $faculteT=explode(',',$champsFaculte); // Mettre chaque champs comme un élément dans un tableau
                 foreach($faculteT as $clesChamps=>$elementChamps)
                 {
                    $elementChamps=chop($elementChamps,' '); // Enlever les espaces 
                    $champsT[]="F.".$elementChamps." as {$elementChamps}F";  
                    
                 }
              }
              
              if($idFaculte!="0" && $idFaculte!="") $conditionT[]=" F.id='$idFaculte' ";                  
                     
            } 
          
          // Verification de l'inclusion de l'établissement ds la requete
             
            if($champsEtablissement!="" || ($idEtablissement!="0" && $idEtablissement!=""))    
            { 
               $conditionFE=true;
               $tablesT[]="etablissement E ";
               $conditionT[]=" FE.idetablissement = E.id ";
               
               if($champsEtablissement!="") 
               {
                /* Récuperation de la déclaration des champs de l'établissement */
            
                 $etablissementT=explode(',',$champsEtablissement); // Mettre chaque champs comme un élément dans un tableau
                 foreach($etablissementT as $clesChamps=>$elementChamps)
                 {
                    $elementChamps=chop($elementChamps,' '); // Enlever les espaces 
                    $champsT[]="E.".$elementChamps." as {$elementChamps}E";  
                 }
               } 
              
               if($idEtablissement!="0" && $idEtablissement!="")$conditionT[]=" E.id='$idEtablissement' ";          
                 
            } 
          
            if($conditionFE==true) // Verifiant si on rajout la table faculte-etablissement dans la requête
            { 
               $tablesT[]="`faculte-etablissement` FE ";
               $conditionT[]=" A.`idfac-etab` = FE.id ";
            }
                
          
          /* Récuperation de la déclaration des champs du cycle */
            
            $cycleT=explode(',',$champsCycle); // Mettre chaque champs comme un élément dans un tableau            
            foreach($cycleT as $clesChamps=>$elementChamps)
            {
                $elementChamps=chop($elementChamps,' '); // Enlever les espaces 
                $champsT[]="C.".$elementChamps." as {$elementChamps}C";  
            } 
             
            $champs=implode(',',$champsT);
            $tables=implode(',', $tablesT);
            $condition=implode(' AND ',$conditionT);
                                     
         /* Récuperation de la déclaration du tri dans $orderQ, et des bornes de recherche. */
           
            $ordreT=explode(',',$ordre);     
            foreach($ordreT as $clesordre=>$elementOrdre)  
            {
                $elementOrdre=chop($elementOrdre,' '); // Enlever les espaces
                
               /* Vérifier si l'élément du tri est un élément de la table année ou 
                   un élément de l'un des tables: cycle, faculte, ou établissement               
               */
                if(!preg_match("#^(e.|f.|c.)#i",$elementOrdre))
                  $ordreT[$clesordre]="A.".$elementOrdre;
                else{
                  $elementOrdre[0]=strtoupper($elementOrdre[0]);//Mettre l'initiale de la table en majiscule
                  $ordreT[$clesordre]=$elementOrdre;  
                }
            
            }              
            $ordre="order by ".implode(',',$ordreT);  
            if($bornes!="") $bornes=" LIMIT ".$bornes;
       
       
         /* Préparation de la requête de listage des anneés à partir de la BD 
                 et création d'un tableau contenant la liste des années       */
   
            if(!$anneeQ=mysql_query("select $champs from $tables $condition $ordre $bornes"))
              return -1; //Retourner -1 si la requête est malformée
                
            $tabAnnee=array();
       
           
        /* Récupération des années à partir de la BD */
           
            while ($anneeR=mysql_fetch_array($anneeQ))
            {               
                     
            /* Instantiation et chargement du resultat dans l'objet faculté */

              $faculte=new Faculte;
              $faculte->id=stripslashes($anneeR['idF']);  
              $faculte->nom=stripslashes($anneeR['nomF']);
              $faculte->abrv=stripslashes($anneeR['abrvF']);
              $faculte->timeStampAjout=stripslashes($anneeR['timestampajoutF']);
           
            /* Instantiation et chargement du resultat dans l'objet établissement */
        
              $etablissement=new Etablissement;
              $etablissement->id=stripslashes($anneeR['idE']);  
              $etablissement->nom=stripslashes($anneeR['nomE']);
              $etablissement->abrv=stripslashes($anneeR['abrvE']);
              $etablissement->timeStampAjout=stripslashes($anneeR['timestampajoutE']);
           
            /* Instantiation et chargement du resultat dans l'objet cycle */       
           
              $cycle=new Cycle;
              $cycle->id=stripslashes($anneeR['idC']);  
              $cycle->code=stripslashes($anneeR['codeC']);
              $cycle->nom=stripslashes($anneeR['nomC']);
                           
            /* Instantiation et chargement du resultat dans l'objet année */   
            
              $annee=new Annee;
              $annee->id=stripslashes($anneeR['idA']);
              $annee->numAnnee=stripslashes($anneeR['numanneeA']);   
              $annee->branche=stripslashes($anneeR['brancheA']);
              $annee->faculte=$faculte;
              $annee->etablissement=$etablissement;
              $annee->cycle=$cycle;
              $annee->timeStampAjout=stripslashes($anneeR['timestampajoutA']);
        
              $tabAnnee[]=$annee;
             
            }
           
           return $tabAnnee;             
      }
      
     /**
      * Extraire le nom complet de l'année sous forme d'une chaîne de caractères. 
      * Cette chaîne de caractères est composée du numéro de l'année suivi de son suffixe ("ére ou éme"), du nom du cycle, du nom de la faculté,
      * de la branche, et de l'abréviation de l'établissement mis entre crochet. Exemple: 3éme année ingéniorat éléctronique instrumentation [USTHB],
      * 1ére année Licence LMD informatique MI [USTHB]. 
      * @return string Le nom complet de l'année.
      */
      function retournerNomComplet()
      { 
      
        $sain["numAnnee"]=htmlentities($this->numAnnee,ENT_QUOTES,'UTF-8');
        $sain["nomCycle"]=htmlentities($this->cycle->nom,ENT_QUOTES,'UTF-8');
        $sain["nomFaculte"]=htmlentities($this->faculte->nom,ENT_QUOTES,'UTF-8');
        $sain["branche"]=htmlentities($this->branche,ENT_QUOTES,'UTF-8');
        $sain["abrvEtablissement"]=htmlentities($this->etablissement->abrv,ENT_QUOTES,'UTF-8');
        
          
        if($this->numAnnee==1) $suffixeNum="ère";
        else $suffixeNum="ème";
       
        return "{$sain["numAnnee"]} $suffixeNum année {$sain["nomCycle"]} {$sain["nomFaculte"]} {$sain["branche"]} [{$sain["abrvEtablissement"]}]"; 
     
      }
     
     /**
      *Modifier les informations d'une année dans la base de données.
      *L'attribut $id contient l'identifiant de l'année à modifier. 
      *Les attributs $num et $nom ainsi que l'attribut $cycle->id contiennent les modifications à apporter. 
      *Il faut passer par la méthode mettreDansFacEtab pour modifier l'identifiant de la faculté-établissement de l'année. 
      *@return integer 1 si l'année a été modifié avec succés. 0 dans le cas contraire.  -1 dans le cas d'échec de la requête (Ex: identifiant du cycle 
      *inexistant). 
      */ 
      function modifierAnnee()
      {   
         /* Netoyage des variables */  
        
          $sainBD["id"]=mysql_real_escape_string(htmlentities($this->id,ENT_QUOTES,'UTF-8'));
          $sainBD["numAnnee"]=mysql_real_escape_string(htmlentities($this->numAnnee,ENT_QUOTES,'UTF-8'));
          $sainBD["branche"]=mysql_real_escape_string(htmlentities($this->branche,ENT_QUOTES,'UTF-8'));
          $sainBD["idCycle"]=mysql_real_escape_string(htmlentities($this->cycle->id,ENT_QUOTES,'UTF-8'));
          
         // Modification de l'année dans la BD
            mysql_query("UPDATE annee SET branche='{$sainBD["branche"]}',numannee='{$sainBD["numAnnee"]}', idcycle='{$sainBD["idCycle"]}'  
                         WHERE id='{$sainBD["id"]}'");
      
            return mysql_affected_rows();
      }        
     
     /**
      *Supprimer l'année identifiée par $id de la base de données.
      *@static
      *@param integer $id L'identifiant de l'année à supprimer.
      *@return integer 1 si l'année a été supprimé avec succés. 0 dans le cas contraire.   
      */
      function supprimerAnnee($id)
      {
         //Netoyage de la variable d'entrée 
          $sainBD['id']=mysql_real_escape_string(htmlentities($id,ENT_QUOTES,'UTF-8')); 

         //Suppression de la faculté 
          mysql_query("delete from annee where id='{$sainBD['id']}'"); 
      
          return mysql_affected_rows();
      }  
    
     /**
      *Modifier le champs idfac-etab de l'année dans la base de données. 
      *A la suite de l'appel de cette méthtode, les attributs $faculte->id et $etablissement->id seront changés pour refléter le changement. 
      *Néaumoins, les attributs $faculte et $etablissement ne seront pas rechargés intégralement.
      *Ceci doit être fait manuellement en utilisant les méthodes Faculte::chargerFaculte et Etablissement::chargerFaculte avec paramètre l'identifiant 
      *de $faculte et $etablissement respectivement. 
      *@param integer $idFacEtab L'identifiant de la nouvelle faculté-établissement.
      *@see Faculte::chargerFaculte(),Etablissement::chargerEtablissement()
      *@return integer 1 si l'année a été supprimé avec succés. 0 dans le cas contraire.   
      */ 
      function mettreDansFacEtab($idFacEtab) 
      {
        //Netoyage de la variable d'entrée
         $sainBD['idFacEtab']=mysql_real_escape_string(htmlentities($idFacEtab,ENT_QUOTES,'UTF-8')); 
         $sainBD['id']=mysql_real_escape_string(htmlentities($this->id,ENT_QUOTES,'UTF-8'));
        
        //Mise à jour de la faculté-établissement de cette année dans la BD
         mysql_query("UPDATE  annee SET `idfac-etab`='{$sainBD['idFacEtab']}' WHERE id='{$sainBD['id']}'"); 
         
        //Modifier l'identifiant de faculte et etablissement.
         if(mysql_affected_rows())
         {
           $resFacEtab=mysql_fetch_array(mysql_query("select * from `faculte-etablissement` where id={$sainBD['idFacEtab']}"));
           $this->faculte->id=$resFacEtab['idfaculte'];
           $this->etablissement->id=$resFacEtab['idetablissement'];
         }
         
         
         return mysql_affected_rows();          
      } 
 }
?>
