function reponse_chapitre(reponse)
{ 

  var tab_reponse = new Array();
  var chapitre;
  var chapitres=reponse.getElementsByTagName('chapitre');
  
  for each(eleC in chapitres)
  {
    
    if(typeof(eleC)=='object')
    {
     chapitre=new Array(eleC.getAttribute("id"),eleC.getAttribute("num"),eleC.childNodes[0].nodeValue);
     tab_reponse.push(chapitre);
    } 
            
  }
 
  return tab_reponse; 

}
