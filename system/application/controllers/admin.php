<?php

/* Controlleur de la partie admin de VirtUAPI-DZ */

class Admin extends Controller {

	function Admin() {
        parent::Controller();	
        $this->load->library('oms'); //Les fonctions les plus courantes du site.
        $this->load->database();
        $this->load->model('catalogue/specialite','specialite');
        $this->load->model('catalogue/annee','annee');
        $this->load->model('catalogue/module','module');
        $this->load->model('catalogue/chapitre','chapitre');
        $this->load->model('membre');
        $this->load->model('contenu/coursmodere','cours');
        $this->load->model('contenu/sujetmodere','sujet');
        $this->load->model('contenu/tdmoderee','td');
	}
    
    // Les fonctions de vérification d'accés
	
	//Vérifier si un utilisateur est un modérateur    
    function _verifierModerateur( $idUser ) {
	    if( !( $this->membre->estModerateur($idUser) ) ) {
            echo $this->load->view( 'admin/erreurs/nonmod', '', True );
            die();      		
        }
    }
	
	//Vérifier si un utilisateur est un admin
    function _verifierAdmin( $idUser ) {
        if( !( $this->membre->estAdmin($idUser) ) ) {
            echo $this->load->view( 'admin/erreurs/nonadmin', '', True );
            die();      		
        }
    }
	
	//Vérifier si le membre peut modérer cette spécialité    
    function _verifierModSpecialite( $idS,$idM ) {
        if( !$this->specialite->verifierModSpecialite( $idS, $idM ) ) {  
            echo $this->load->view( 'admin/erreurs/nonautorisemod', '', True );
            die();          	        
        }
	}	
	
    function gerer_samc() {
    
        //Vérifier l'accés à la page
        $idUser = $this->oms->verifierConnecte();
        $this->_verifierAdmin($idUser);

        //Traiter les requêtes 
        $action = $this->input->post( "action", true );
        $cible = $this->input->post( "cible", true );

        $notification_specialite = ""; //La notification pour la spécialité
        $type_notif_spec  = "";	       //Type de notification pour la spécialité
        $notification_annee  = "";	   //La notification pour l'année
        $type_notif_annee  = "";	   //Type de notification pour l'année
        $notification_module = "";     //La notification du module
        $type_notif_module = "";	   //Type de notification pour le module
        $notification_chapitre = "";   //La notification du chapitre
        $type_notif_chapitre = "";     //Type de notification pour le chapitre
		
        if( $action != NULL && $cible != NULL ) {
           
            switch( $cible ) {
            
                case "specialite":
                    
                    if( $action == "supp" ) {
                   
                        $id = $this->input->post( "specialite", true );
                        $this->specialite->supprimerSpecialite($id);
                        $notification_specialite = "Spécialité supprimée avec succés";
                        $type_notif_spec = "succes";
		       
		            } else {
                   
                        $nom = $this->input->post( "specialite", true );
                        if( $this->specialite->ajouterSpecialite($nom) > 0 ) {
                            $notification_specialite = "Spécialité ajoutée avec succés";
                            $type_notif_spec = "succes";
                        } else {
                            $notification_specialite = "Cette spécialité existe déjà";	
                            $type_notif_spec = "error";
                        }
                       
                   }	
                   break;
		            
                case "annee":	
		         		
                    if( $action == "supp" ) {      
                    
                        $id = $this->input->post( "annee", true );	
                        $this->annee->supprimerAnnee($id);
                        $notification_annee = "Année supprimée avec succés";
                        $type_notif_annee = "succes";
                        
                    }else{
                    		       
                        $nomannee = $this->input->post( "annee", true);            
                        $idspecialite = $this->input->post( "specialite", true );
                        if( $this->annee->ajouterAnnee( $nomannee, $idspecialite ) > 0 ) {
                            $notification_annee = "Année ajoutée avec succés";
                            $type_notif_annee = "succes";
                        } else {
                            $notification_annee = "Cette année existe déjà";
                            $type_notif_annee = "error";
                        }
		         			       
                    }
                    break;

                case "module":
                
                    if( $action == "supp" ) {
		         			
                        $id = $this->input->post( "module", true );
                        $this->module->supprimerModule($id);
                        $notification_module = "Module supprimé avec succés";
                        $type_notif_module = "succes";
                                
                    } else {
		         			
                        $nommodule = $this->input->post( "module", true );
                        $idannee = $this->input->post("annee");
                        if( $this->module->ajouterModule( $nommodule, $idannee ) > 0 ) {
                            $notification_module = "Module ajouté avec succés";
                            $type_notif_module = "succes";
                        } else {
                            $notification_module = "Ce module existe déjà";
                            $type_notif_module = "error";		         				
                        }
                    }	
                    break;

                case "chapitre":
                    if( $action =="supp" ) {
                    
                        $id = $this->input->post("chapitre");
                        $this->chapitre->supprimerChapitre($id);  			   
                        $notification_chapitre = "Chapitre supprimé avec succés";
                        $type_notif_chapitre = "succes";
                        		         						         				
                    } else {
                        $num = $this->input->post( "num", true );
                        $nom = $this->input->post( "nom", true );
                        $idmodule = $this->input->post( "module", true );

                        if( $this->chapitre->ajouterChapitre( $num, $nom, $idmodule ) > 0 ) {
                            $notification_chapitre = "Chapitre ajouté avec succés";
                            $type_notif_chapitre = "succes";
                        } else {
                            $notification_chapitre = "Ce chapitre existe déjà";
                            $type_notif_chapitre = "error";		         				
                        }
		         			
                    }
                    break;
            }		   
        }
			
		//Remplir les variables 
        $specialites = $this->specialite->listerSpecialites();
        $annees = $this->annee->listerAnneesSpec();
        $modules = $this->module->listerModule( $annees[0]['annees'][0]['id'] );
        $chapitres = $this->chapitre->listerChapitre( $modules[0]['id'] );
		     
        $this->load->view( "admin/gerer_samc",
                           array( "specialites" => $specialites,
                                  "annees" => $annees,
                                  "modules" => $modules,
                                  "chapitres" => $chapitres,
                                  "notification_specialite" => $notification_specialite,
                                  "type_notif_spec" => $type_notif_spec,
                                  "notification_annee" => $notification_annee,
                                  "type_notif_annee" => $type_notif_annee,
                                  "notification_module" => $notification_module,
                                  "type_notif_module" => $type_notif_module,
                                  "notification_chapitre" => $notification_chapitre,
                                  "type_notif_chapitre" => $type_notif_chapitre ) );
	}
	
    function moderation() { 

        //Vérifier l'accés à la page
        $idUser = $this->oms->verifierConnecte();
        $this->_verifierModerateur($idUser);          		

        $sModerees = $this->specialite->getSpecialiteMod($idUser);
          
        $this->load->view( 'admin/moderation', array( 'sModerees'=>$sModerees ) );
    }
	
    function moderation_specialite($idspecialite) {
	
	    //Vérifier l'accés à cette page
        $idUser = $this->oms->verifierConnecte();
        $this->_verifierModerateur( $idUser );          	
		
        $specialite = $this->oms->verifSpecialite( $idspecialite ); //Verifier l'existence de la spécialité 
        $this->_verifierModSpecialite( $idspecialite, $idUser ); //Vérifier que le modérateur peut modérer la spécialité
	    
        $this->load->view( 'admin/moderation_specialite',
        				    array( "specialite" => $specialite->nom,"nbr_cours" => $this->cours->getNbrCoursMod($idspecialite),
          	        		       "nbr_sujets" => $this->sujet->getNbrSujetsMod($idspecialite), "nbr_td" => $this->td->getNbrTdMod($idspecialite),
          	        		       "id" => $idspecialite ) );          	  	
	}
	
    function moderer_cours($idspecialite=0) {
	
        //Vérifier l'accés à cette page
        $idUser = $this->oms->verifierConnecte();
        $this->_verifierModerateur($idUser);          		
		
        $specialite = $this->oms->verifSpecialite($idspecialite); //Verifier l'existence de la spécialité 
        $this->_verifierModSpecialite($idspecialite,$idUser);
          	
        //Traiter les requêtes
        $action = $this->input->post( "action", true );
        $cible = $this->input->post( "cible", true );
        $notification = "" ;
        	
        switch( $action ) {
        
            case "valider":
                $this->cours->validerCoursMod($cible);
                $notification = "Cours ajouté avec succés";
                break;
        		
            case "refuser":
                $this->cours->refuserCoursMod($cible);  
                $notification = "Cours supprimé avec succés";
        		break;      	
        	
        }
        	
        //Récupérer les cours à modérer
        $coursMod = $this->cours->getCoursMod($idspecialite);

        $this->load->view( 'admin/moderer_cours',
                           array( "coursMod" => $coursMod, "specialite" => $specialite->nom,"notification" => $notification ) );
    }
	
    function moderer_sujets($idspecialite=0) {
	
        //Vérifier l'accés à cette page
        $idUser = $this->oms->verifierConnecte();
        $this->_verifierModerateur($idUser);

        $specialite = $this->oms->verifSpecialite($idspecialite); //Verifier l'existence de la spécialité        		
        $this->_verifierModSpecialite( $idspecialite, $idUser );
	  	
	  	//Traiter les requêtes
        $action = $this->input->post( "action", true );
        $cible = $this->input->post( "cible", true );
        $notification = "" ;
        	
        switch( $action ) {
        
            case "valider":
                $this->sujet->validerSujetMod($cible);
                $notification = "Sujet ajouté avec succés";
                break;
        		
            case "refuser":
                $this->sujet->refuserSujetMod($cible);  
                $notification = "Sujet supprimé avec succés";
                break;      	
        	
        } 
	  	
	  	//Récupérer les sujets à modérer
	  	$sujetsMod = $this->sujet->getSujetsMod($idspecialite);
	  	
        $this->load->view( 'admin/moderer_sujets',
                           array( 'sujetsMod' => $sujetsMod, 'specialite' => $specialite->nom, "notification" => $notification ) );
	  	
    }
	
    function moderer_td($idspecialite=0) {
	
    }
	
    function gerer_moderateur() {
	
        //Vérifier l'accés à la page
        $idUser = $this->oms->verifierConnecte();
        $this->_verifierAdmin($idUser);
        
        //Traiter les requêtes posts
        $action = $this->input->post('action', true);
        $notification_ajout = "";
        $erreur_ajout = "";
        $notification_supp = "";
		
        switch( $action ) {
        
            case 'ajout':
                $ajout = $this->membre->ajouterModerateur( $this->input->post("nomMod", true), $this->input->post("idS", true) );

                if( $ajout > 1 ) { 
                    $notification_ajout = "Moderateur ajouté avec succés";
   	            } else {
                    if($ajout == 0) {
			    	     $erreur_ajout = "Ce moderateur est déjà dans cette spécialité";
                    } else {
                         $erreur_ajout = "Membre inexistant" ;
                    }
                }
                break;   
		   
            case 'supp':	
                $notification_supp = "Moderateur supprimé avec succés";
                $this->membre->supprimerModerateur( $this->input->post("id") );
                break;
        
        }
		
        //Afficher la page
        $specialites = $this->specialite->listerSpecialites();
        $moderateurs = $this->membre->listerModerateurs();
		
        $this->load->view( "admin/gerer_moderateur",
                           array( "specialites" => $specialites,"moderateurs" => $moderateurs,
                                  "notification_ajout" => $notification_ajout, "erreur_ajout" => $erreur_ajout,
                                  "notification_supp" => $notification_supp ) );
    }
	
    function index() {

	    //Vérifier l'accès à la page
        $idUser = $this->oms->verifierConnecte();
          	
        if( !( $this->membre->estAdmin($idUser) ) && !( $this->membre->estModerateur($idUser) ) ) {
            $this->load->view('admin/erreurs/nonmodadmin');
           	return;      		
        }
          		
        $this->load->view( 'admin/admin', 
                            array( 'admin' => $this->membre->estAdmin($idUser), 
                                   'mod' => $this->membre->estModerateur($idUser) ) );
    }

}        
?>
