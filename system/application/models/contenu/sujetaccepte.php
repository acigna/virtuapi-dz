<?php
class SujetAccepte extends Model {
    
    //Le contructeur
    function SujetAccepte() {
        //Récupérer une instance de CodeIgniter
        $CI = & get_instance();
            
        //Charger les modèles            
        $CI->load->model('catalogue/module', 'module');
        $CI->load->model('membre');        
    }
        
    function listerSujetsAnnee( $id ) {
        $sujets = array();
            
        // Liste des modules 
        $modules = $this->module->listerModule($id); 
            
        foreach($modules as $module) {
            $contenus = $this->listerSujetsModule($module['id']);
            if( count($contenus) != 0) {
                $sujets[] = array( 'nom'=>$module['nom'], 'contenus' => $contenus );
            }            
        }
            
        return $sujets;        
    }
    
    function listerSujetsModule( $id ) {
        $resultat = $this->db->query("select s.Id as id,s.Type as type,s.TypeFichier as typefichier, s.NumSujet as numsujet, s.TypeExam as typeexam, me.Pseudo as pseudo, s.AnneeUniv as anneeuniv, s.TimeStampPub as pub, s.TimeStampDernModif as dernmodif from sujets s, membre me where s.IdPubliant=me.Id and s.IdModule='$id'  order by s.AnneeUniv desc,case s.TypeExam when 'EMD1' THEN 1 WHEN 'EMD2' THEN 2  WHEN 'EMD3' THEN 3 WHEN 'Synthese' THEN 4 WHEN 'Rattrapage' THEN 5 ELSE NULL END, s.NumSujet, s.Type DESC")->result_array();
        
        $contenus = array();
        
        if( count($resultat) != 0 ) {
            $i = 0;
            while( $i < count($resultat) ) {
                $anneeuniv = $resultat[$i]['anneeuniv'];
                list( $i, $sujetsa ) = $this->listerSujetsAnneeUniv( $resultat, $i, $anneeuniv );
                $contenus[] = array( 'anneeuniv' => $anneeuniv, 'sujetsa' => $sujetsa );           
            }
        }
        return $contenus;
    }
    
    function listerSujetsAnneeUniv( $resultat, $i, $anneeuniv ) {
        $sujetsa = array();
        while( $i < count($resultat) &&  $anneeuniv == $resultat[$i]['anneeuniv'] ) {
              $typeexam = $resultat[$i]['typeexam'];
              list( $i, $sujetse ) = $this->listerSujetsTypeExam( $resultat, $i, $anneeuniv, $typeexam );
              $sujetsa[] = array( 'typeexam' => $typeexam, 'sujetse' => $sujetse );
        }
        return array( $i, $sujetsa );     
    }
    
    function listerSujetsTypeExam( $resultat, $i, $anneeuniv, $typeexam ) {
        $sujetse = array();
        while( $i < count($resultat) &&  $anneeuniv == $resultat[$i]['anneeuniv'] && $typeexam == $resultat[$i]['typeexam'] ) {
            $numsujet = $resultat[$i]['numsujet'];
            list( $i, $sujetsn ) = $this->listerSujetsNumSujet( $resultat, $i, $anneeuniv, $typeexam, $numsujet );
            $sujetse[] = array( 'numsujet' => $numsujet, 'sujetsn' => $sujetsn );
        }
        return array( $i, $sujetse );
    }
    
    function listerSujetsNumSujet( $resultat, $i, $anneeuniv, $typeexam, $numsujet ) {
        $sujetsn = array();
        while( $i < count($resultat) &&  $anneeuniv == $resultat[$i]['anneeuniv'] && 
               $typeexam == $resultat[$i]['typeexam'] &&  $numsujet == $resultat[$i]['numsujet'] ) {
            $sujetn = $resultat[$i];
            $sujetsn[] = array( 'id' => $sujetn['id'], 'typefichier' => $sujetn['typefichier'], 'type' => $sujetn['type'], 
                                'pseudo' => $sujetn['pseudo'], 'pub' => $sujetn['pub'], 'dernmodif' => $sujetn['dernmodif'] );
            $i++;
        }
        return array( $i, $sujetsn );   
    }
    
}

?>
