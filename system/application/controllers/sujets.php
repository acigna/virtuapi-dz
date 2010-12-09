<?php

/* Controlleur de la partie cours de Open Mind Students */

class Sujets extends Controller {

 	function Sujets()
 	{
 	   parent::Controller();	
 	   $this->load->library('oms');
 	
 	}
 	
 	function Deconnection()
        {
          	$this->oms->Deconnection($this);
        }
        
        
        
        function annees($idspecialite=0)
        {
              if($idspecialite==0)
                  show_404();
              $this->load->database();

  	      $idspecialite=mysql_real_escape_string(htmlentities($idspecialite));
	      $specialite=mysql_fetch_array(mysql_query("select NomSpecialite from specialite where Id='$idspecialite'"));	
	      
	      if(!$specialite) show_404();
	      
              $this->oms->partie_haute('./../../../',"Les sujets de la spécialité {$specialite[0]}",$this);
                      
  	       //Contenu principal ici   
               
               $requete=mysql_query("select * from annee where idspecialite='$idspecialite' order by NomAnnee");
               
	       $annees=array();
	       
	       while(list($id,$nom)=mysql_fetch_array($requete))
 	       {
 	          $annees[$id]=$nom ;
 	          
 	       }	
               
               $contenu=$this->load->view("annees",array('type'=>'sujets','nom' => $specialite[0], 'annees'=>$annees),true);             	
               echo $contenu ;
               $this->oms->partie_basse($this);

        }
        
        
        function contenu($idannee=0)
        {
 	      if($idannee==0)
                  show_404();
              $this->load->database();
              
            $idannee=mysql_real_escape_string(htmlentities($idannee));
            $annee=mysql_fetch_array(mysql_query("select * from annee where id='$idannee' "));
            
            if(!$idannee) show_404();
            
            $this->oms->partie_haute('./../../../',"Les sujets de la {$annee[1]}",$this);	
            
            $sujets=array();
            
            // Liste des modules 
             $module=mysql_query("select id,nommodule from module where idannee='$idannee'");
            
            while(list($id,$nomM)=mysql_fetch_array($module))
            {
              $contenu=mysql_query("select s.Id,s.Type,s.TypeFichier,s.NumSujet,s.TypeExam,me.Pseudo,s.AnneeUniv,s.TimeStampPub,s.TimeStampDernModif from sujets s, membre me where s.IdPubliant=me.Id and s.IdModule='$id'  order by s.AnneeUniv desc,case s.TypeExam when 'EMD1' THEN 1 WHEN 'EMD2' THEN 2  WHEN 'EMD3' THEN 3 WHEN 'Synthese' THEN 4 WHEN 'Rattrapage' THEN 5 ELSE NULL END,s.NumSujet,s.Type DESC"); 
              
              $contenus=array();             
              
              
               
             list($id,$type,$typefichier,$numsujet,$typeexam,$pseudo,$anneeuniv,$pub,$dernmodif)=mysql_fetch_array($contenu);
              
              if($id!=NULL)
              {
                 $contenus[]=array('anneeuniv'=>$anneeuniv,
                              'sujetsa'=>array(array(
                                                 'typeexam'=>$typeexam,
                                                                        'sujetse'=>array(array('numsujet'=>$numsujet,
                                                                                         'sujetsn'=>array(array('id'=>$id,'type'=>$type,'pseudo'=>$pseudo,
                                                                                          'typefichier'=>$typefichier, 'pub'=>$pub,'dernmodif'=>$dernmodif)))))));        
                      
              	while(list($id,$type,$typefichier,$numsujet,$typeexam,$pseudo,$anneeuniv,$pub,$dernmodif)=mysql_fetch_array($contenu))
             	{
             	 
             	  
                   
             	 
                    if($contenus[count($contenus)-1]['anneeuniv']==$anneeuniv)
                    {
                     
                      if($contenus[count($contenus)-1]['sujetsa'][count($contenus[count($contenus)-1]['sujetsa'])-1]['typeexam']==$typeexam)
                      {
                      
                        $contenus[count($contenus)-1]['sujetsa'][count($contenus[count($contenus)-1]['sujetsa'])-1]['sujetse'];
                      
                        if($contenus[count($contenus)-1]['sujetsa'][count($contenus[count($contenus)-1]['sujetsa'])-1]['sujetse'][count($contenus[count($contenus)-1]['sujetsa'][count($contenus[count($contenus)-1]['sujetsa'])-1]['sujetse'])-1]['numsujet']==$numsujet)
                         {
                          
                           $contenus[count($contenus)-1]['sujetsa'][count($contenus[count($contenus)-1]['sujetsa'])-1]['sujetse'][count($contenus[count($contenus)-1]['sujetsa'][count($contenus[count($contenus)-1]['sujetsa'])-1]['sujetse'])-1]['sujetsn'][]=array('id'=>$id,'type'=>$type,'pseudo'=>$pseudo,
                                                                                          'typefichier'=>$typefichier, 'pub'=>$pub,'dernmodif'=>$dernmodif);
                                 
                         
                         }else{
                          
                          $contenus[count($contenus)-1]['sujetsa'][count($contenus[count($contenus)-1]['sujetsa'])-1]['sujetse'][]=array('numsujet'=>$numsujet,
                                                                                         'sujetsn'=>array(array('id'=>$id,'type'=>$type,'pseudo'=>$pseudo,
                                                                                          'typefichier'=>$typefichier, 'pub'=>$pub,
                                                                                          'dernmodif'=>$dernmodif)));
                                                                                                                  
                        }
                        
                      
                      }else{
                         
                         $contenus[count($contenus)-1]['sujetsa'][]=array(
                                                 'typeexam'=>$typeexam,
                                                                        'sujetse'=>array(array('numsujet'=>$numsujet,
                                                                                         'sujetsn'=>array(array('id'=>$id,'type'=>$type,'pseudo'=>$pseudo,
                                                                                          'typefichier'=>$typefichier, 'pub'=>$pub,'dernmodif'=>$dernmodif)))));
                      
                      }
                        
                    
                    }else{
                  	$contenus[]=array('anneeuniv'=>$anneeuniv,
                              'sujetsa'=>array(array(
                                                 'typeexam'=>$typeexam,
                                                                        'sujetse'=>array(array('numsujet'=>$numsujet,
                                                                                         'sujetsn'=>array(array('id'=>$id,'type'=>$type,'pseudo'=>$pseudo,
                                                                                          'typefichier'=>$typefichier, 'pub'=>$pub,'dernmodif'=>$dernmodif)))))));        
                    
                    
                    
                    }
                    
                             
              	}
              	
              }	   
              
              
              $sujets[]=array('nom'=>$nomM,'contenus' =>$contenus);   
              
              
              
            }
            
            
            $contenu=$this->load->view("sujets",array('nomannee'=> $annee[1], 'sujets' => $sujets),true);             	
            echo $contenu ;
            
            $this->oms->partie_basse($this);
            

              
        
        
        }



}





?>
