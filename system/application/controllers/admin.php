<?php

/* Controlleur de la partie admin de Open Mind Students */

class Admin extends Controller 
{

	function Admin()
	{
		parent::Controller();	
		$this->load->library('oms'); //Les fonctions les plus courantes du site.
		$this->load->database();
		$this->load->model('catalogue/specialite','specialite');
		$this->load->model('catalogue/annee','annee');
		$this->load->model('catalogue/module','module');
		$this->load->model('catalogue/chapitre','chapitre');
		$this->load->model('membre');
		$this->load->model('contenu/coursmodere','cours');
		$this->load->model('contenu/sujetsmoderee','sujets');
		$this->load->model('contenu/tdmoderee','td');
	}
    
    // Les fonctions de vérification d'accés
	
	//Vérifier qu'un utilisateur est un modérateur    
	function _verifierModerateur($idUser)
	{
		if(!($this->membre->estModerateur($idUser)))
        	{
        		$contenu=$this->load->view('admin/erreurs/nonmod',"",true);
         		echo $contenu;
         		$this->oms->partie_basse($this);//Vérifier l'accés à la page
			die();      		
         	}
	}
	
	//Vérifier qu'un utilisateur est un admin
	function _verifierAdmin($idUser)
	{
		if(!($this->membre->estAdmin($idUser)))
        	{
        		$contenu=$this->load->view('admin/erreurs/nonadmin',"",true);
         		echo $contenu;
         		$this->oms->partie_basse($this);
			die();      		
         	}
	}
	
	//Vérifier si le membre peut modérer cette spécialité    
	function _verifierModSpecialite($idS,$idM)
	{
		if(!$this->specialite->verifierModSpecialite($idS,$idM))
        	{  
        		$contenu=$this->load->view('admin/erreurs/nonautorisemod','',true);
        		echo $contenu;            	        
          		return;          	        
        	}
	}	
	
        // Les pages de l'admin
	function gerer_samc()
	{
		$this->oms->partie_haute('./../../',"Page de gestion des spécialités, années, modules et chapitres",$this);	
		
		//Vérifier l'accés à la page
		$idUser=$this->oms->verifierConnecte($this);
		$this->_verifierAdmin($idUser);
		
		//Traiter les requêtes 
		$action=$this->input->post("action");
		$cible=$this->input->post("cible");
		
		$notification_specialite=""; //La notification pour la spécialité
		$type_notif_spec="";	     //Type de notification pour la spécialité
		$notification_annee="";	     //La notification pour l'année
		$type_notif_annee="";	     //Type de notification pour l'année
		$notification_module="";     //La notification du module
		$type_notif_module="";	     //Type de notification pour le module
		$notification_chapitre="";   //La notification du chapitre
		$type_notif_chapitre="";     //Type de notification pour le chapitre
		
		if($action!=NULL && $cible!=NULL)
		{
		   switch($cible)
		   {
		         case "specialite":     
		         		        if($action=="supp")
		         		        {
		         				$id=$this->input->post("specialite");
		         				$this->specialite->supprimerSpecialite($id);
		         				$notification_specialite="Spécialité supprimée avec succés";
		         				$type_notif_spec="succes";
		         			}else{
		         				$nom=$this->input->post("specialite");
		         				if($this->specialite->ajouterSpecialite($nom)>0)
		         				{
		         					$notification_specialite="Spécialité ajoutée avec succés";
		         					$type_notif_spec="succes";
		         				}else{
		         					$notification_specialite="Cette spécialité existe déjà";	
		         					$type_notif_spec="error";
		         				}
		         			}	
		                  		
		                  		break;
		         
		         case "annee":	
		         		
		         			if($action=="supp")
		         			{      
		    				       $id=$this->input->post("annee");	    					     			      							       $this->annee->supprimerAnnee($id);
		    				       $notification_annee="Année supprimée avec succés";
		         			       $type_notif_annee="succes";
		         			}else{		       
		         			       $nomannee=$this->input->post("annee");            
		         			       $idspecialite=$this->input->post("specialite");
		         			       if($this->annee->ajouterAnnee($nomannee,$idspecialite)>0)
		         			       {
		         			       	  $notification_annee="Année ajoutée avec succés";
		         			       	  $type_notif_annee="succes";
		         			       }else{
		         			       	  $notification_annee="Cette année existe déjà";
		         			       	  $type_notif_annee="error";
		         			       }
		         			       
		         			}
		         			
		         			break;
		   
		   	 case "module":
		         			if($action=="supp")
		         			{
		         				$id=$this->input->post("module");
		         				$this->module->supprimerModule($id);
		         				$notification_module="Module supprimé avec succés";
		         				$type_notif_module="succes";
		         				        			
		         			}else{
		         				$nommodule=$this->input->post("module");
		         				$idannee=$this->input->post("annee");
		         				if($this->module->ajouterModule($nommodule,$idannee)>0)
		         				{
		         				   $notification_module="Module ajouté avec succés";
		         				   $type_notif_module="succes";
		         				}else{
		         				   $notification_module="Ce module existe déjà";
		         				   $type_notif_module="error";		         				
		         				}
		         			}	
		         			
		         			break;
		   
		         
		         case "chapitre":
		         			if($action=="supp")
		         			{
		         			   $id=$this->input->post("chapitre");
		         			   $this->chapitre->supprimerChapitre($id);  			   
		         			   $notification_chapitre="Chapitre supprimé avec succés";
		         			   $type_notif_chapitre="succes";		         						         				
		         			}else{
		         			
		         			   $num=$this->input->post("num");
		         			   $nom=$this->input->post("nom");
		         			   $idmodule=$this->input->post("module");
		         			   
		         			   if($this->chapitre->ajouterChapitre($num,$nom,$idmodule)>0)
		         			   {
		         				   $notification_chapitre="Chapitre ajouté avec succés";
		         				   $type_notif_chapitre="succes";
		         			   }else{
		         				   $notification_chapitre="Ce chapitre existe déjà";
		         				   $type_notif_chapitre="error";		         				
		         			   }
		         			
		         			}
		         			
		         			break;
		   
		   
		   }		   
		}
			
		//Remplir les variables 
		$specialites=$this->specialite->listerSpecialites();
		     $annees=$this->annee->listerAnneesSpec();
		    $modules=$this->module->listerModule($annees[0]['annees'][0]['id']);
		    $chapitres=$this->chapitre->listerChapitre($modules[0]['id']);
		     
		$contenu=$this->load->view("admin/gerer_samc",array("specialites"=>$specialites,
							      	    "annees"=>$annees,
							            "modules"=>$modules,
							            "chapitres"=>$chapitres,
							            "notification_specialite"=>$notification_specialite,
							            "type_notif_spec"=>$type_notif_spec,
							            "notification_annee"=>$notification_annee,
							      	    "type_notif_annee"=>$type_notif_annee,
							            "notification_module"=>$notification_module,
							            "type_notif_module"=>$type_notif_module,
							            "notification_chapitre"=>$notification_chapitre,
							            "type_notif_chapitre"=>$type_notif_chapitre),true);
		echo $contenu;
		
		$this->oms->partie_basse($this);
	}
	
	function moderation()
	{ 
		$this->oms->partie_haute('./../../',"Modération du contenu de l'université virtuelle",$this);
	  
		//Vérifier l'accés à la page
		$idUser=$this->oms->verifierConnecte($this);
		$this->_verifierModerateur($idUser);          		
	  
        	$sModerees=$this->specialite->getSpecialiteMod($idUser);
          
        	$contenu=$this->load->view('admin/moderation',array('sModerees'=>$sModerees),true);
        	echo $contenu;
		
        	$this->oms->partie_basse($this);	
	}
	
	function moderation_specialite($id)
	{
		$specialite=$this->oms->verifSpecialite($this,$id); //Verifier l'existence de la spécialité 
	        
		$this->oms->partie_haute('./../../../',"Page de modération de contenus",$this);
		
		//Vérifier l'accés à cette page
		$idUser=$this->oms->verifierConnecte($this);
		$this->_verifierModerateur($idUser);          		
        	$this->_verifierModSpecialite($id,$idUser);
          	        	           	        
        	$contenu=$this->load->view('admin/moderation_specialite',
        					array("specialite"=>$specialite->nom,"nbr_cours"=>$this->cours->getNbrCoursMod($id),
          	        			    "nbr_sujets"=>$this->sujets->getNbrSujetsMod($id), "nbr_td"=>$this->td->getNbrTdMod($id),
          	        			    "id"=>$id),true);          	  	
          	echo $contenu;
         
		$this->oms->partie_basse($this);          
	}
	
	function moderer_cours($idspecialite=0)
	{
		$specialite=$this->oms->verifSpecialite($this,$idspecialite); //Verifier l'existence de la spécialité 
	  	  	
		$this->oms->partie_haute('./../../../',"Page de modération des cours de la spécialité {$specialite->nom}",$this);
		
		//Vérifier l'accés à cette page
		$idUser=$this->oms->verifierConnecte($this);
		$this->_verifierModerateur($idUser);          		
        	$this->_verifierModSpecialite($idspecialite,$idUser);
        	
        	//Traiter les requêtes
        	$action=$this->input->post("action");
        	$cible=$this->input->post("cible");
        	$notification="" ;
        	
        	switch($action)
        	{
        		case "valider":
        			       $this->cours->validerCoursMod($cible);
        		               $notification="Cours validé avec succés";
        		  	       break;
        		
        		case "refuser":
        		               //Supprimer le cours à modérer
        		               $notification="Cours supprimé avec succés";
        		               $this->cours->refuserCoursMod($cible);  
        		               break;      	
        	
        	}
        	
        	//Récupérer les cours à modérer
        	$coursMod=$this->cours->getCoursMod($idspecialite);
        	     	
        	
        	$contenu=$this->load->view('admin/moderation_cours',array("coursMod"=>$coursMod, "specialite"=>$specialite->nom,"notification"=>$notification),true);
        	echo $contenu;
        	
		$this->oms->partie_basse($this); 
	}
	
	function moderer_sujets($idspecialite=0)
	{
	     	
	}
	
	function moderer_td($idspecialite=0)
	{
	
	
	}
	
	function gerer_moderateur()
	{
		$this->oms->partie_haute('./../../',"Gérer les modérateurs",$this);
		
		//Vérifier l'accés à la page
		$idUser=$this->oms->verifierConnecte($this);
		$this->_verifierAdmin($idUser);
		
		//Traiter les requêtes posts
		$action=$this->input->post('action');
		$notification_ajout="";
		$erreur_ajout="";
		$notification_supp="";
		
		switch($action)
		{
		   case 'ajout':
		            $ajout=$this->membre->ajouterModerateur($this->input->post("nomMod"),$this->input->post("idS"));
		            
		            if($ajout>1)
		            	$notification_ajout="Moderateur ajouté avec succés";
			    else{
			    	
			    	if($ajout==0)
			    	   $erreur_ajout="Ce moderateur est déjà dans cette spécialité";
			        else
			           $erreur_ajout="Membre inexistant";
			    }
			    break;   
		   
		   case 'supp':	
		   	    $notification_supp="Moderateur supprimé avec succés";
			    $this->membre->supprimerModerateur($this->input->post("id"));
			    break;
		}
		
		//Afficher la page
		$specialites=$this->specialite->listerSpecialites();
		$moderateurs=$this->membre->listerModerateurs();
		
		$contenu=$this->load->view("admin/gerer_moderateur",
				           array("specialites"=>$specialites,"moderateurs"=>$moderateurs,
						 "notification_ajout"=>$notification_ajout, "erreur_ajout"=>$erreur_ajout,
						 "notification_supp"=>$notification_supp),true);
		echo $contenu;
		$this->oms->partie_basse($this);  
	}
	
	function index()
	{
		$this->oms->partie_haute('./../',"Page d'administration du portail",$this);	
		$idUser=$this->oms->verifierConnecte($this);
          	
          	if(!($this->membre->estAdmin($idUser)) && !($this->membre->estModerateur($idUser)))
          	{
          	    $contenu=$this->load->view('admin/erreurs/nonmodadmin',"",true);
              	    echo $contenu;
              	    $this->oms->partie_basse($this);
              	    return;      		
          	}
          		
          	$contenu=$this->load->view('admin/admin',array('admin'=>$this->membre->estAdmin($idUser), 'mod'=>$this->membre->estModerateur($idUser)),true);
              	echo $contenu;
		
		$this->oms->partie_basse($this);
	}
}        
?>
