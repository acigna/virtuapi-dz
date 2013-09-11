<?php
    class CoursAccepte extends Model
    {
        //Le constructeur
        function CoursAccepte() {
            //Récupérer une instance de CodeIgniter
            $CI = & get_instance();
            
            //Charger les modèles            
            $CI->load->model('catalogue/module', 'module');
            $CI->load->model('catalogue/chapitre', 'chapitre');
            $CI->load->model('membre');
        }
        
        //Lister les cours d'une année donnée
        function listerCoursAnnee($idannee) {
            $cours=array();
            
            // Liste des modules 
            $modules = $this->module->listerModule($idannee); 
            foreach( $modules as $module ) {

                //Lister les chapitres
                $chapitres_list = $this->chapitre->listerChapitre($module['id']);
                $chapitres = array();
                foreach($chapitres_list as $chapitre) {

                    //Lister les cours d'un chapitre
                    $contenus = $this->listerCoursChapitre($chapitre['id']);
                    
                    //Intégrer le pseudo du publiant dans chaque contenu (cours)
                    foreach ( $contenus as $i => $contenu ) {
                        $contenus[$i]['publiant'] = $this->membre->charger($contenu['idpubliant'])->pseudo;
                    }
                    
                    $chapitres[] = array('nom'=>$chapitre['nom'],'num'=>$chapitre['num'],'contenus'=> $contenus);              
                }
              
                $cours[] = array('nom'=>$module['nom'],'chapitres'=>$chapitres);   
            }
            
            return $cours;
        }
        
        //Lister les cours d'un chapitre donné
        function listerCoursChapitre($id) {
            return $this->db->query("select Id as id,Type as type, IdPubliant as idpubliant, TypeFichier as typefichier, TimeStampPub as pub,
            TimeStampDernModif as dernmodif from cours where idchapitre='$id' order by type asc")->result_array();
        }
    }
?>
