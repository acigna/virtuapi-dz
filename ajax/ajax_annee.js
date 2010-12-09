function reponse_annee(reponse)
{
  var tab_reponse = new Array();
  
  var annee;
  var annees=reponse.getElementsByTagName('annee');
  
  for each(eleA in annees)
  {
     if(typeof(eleM)=='object')
     {
        annee=new Array(eleA.getAttribute("id"),eleA.childNodes[0].nodeValue);
       tab_reponse.push(annee);
     }
  }
  
  return tab_reponse;
}

