<?php
    class CoursAccepte extends Model
    {
        //Le constructeur
        function CoursAccepte() {
            $CI = & get_instance();
            $CI->load->model('catalogue/module', 'module');
            $this->module = $CI->module;
        }
        
        //Lister les cours d'une année donnée
        function listerCoursAnnee($idannee) {
            $cours=array();
            
            // Liste des modules 
            $modules = $this->module->listerModule($idannee); 
            foreach($modules as $module)
            {
                $chapitre = mysql_query("select id,nomchapitre,numchapitre from chapitre where idmodule='{$module['id']}'");
                $chapitres = array();
              
                while(list($id,$nomC,$num)=mysql_fetch_array($chapitre))
                {
                    $contenu=mysql_query("select  Id,Type,IdPubliant,TypeFichier,TimeStampPub,TimeStampDernModif from cours where idchapitre='$id' order by 
                                          type asc");
                    $contenus=array();
                
                    while(list($id,$type,$idpubliant,$typefichier,$pub,$dernModif)=mysql_fetch_array($contenu))
                    {
                        $nomP=mysql_fetch_array(mysql_query("select * from membre where id='$idpubliant'"));
                        $contenus[]=array('id'=>$id,'type'=>$type,'publiant'=>$nomP['Pseudo'],'typefichier'=>$typefichier,'pub'=>$pub,
                                          'dernmodif'=> $dernModif);                
                    }
                
                    $chapitres[]=array('nom'=>$nomC,'num'=>$num,'contenus'=>$contenus);              
                }
              
                $cours[]=array('nom'=>$module['nom'],'chapitres'=>$chapitres);   
            }
            
            return $cours;
        }
    }
?>
