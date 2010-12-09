function reponse_module(reponse)
{ 
  var tab_reponse = new Array();
  var module;
  var modules=reponse.getElementsByTagName('module');
  
  for each(eleM in modules)
  {
    
    if(typeof(eleM)=='object')
    {
     module=new Array(eleM.getAttribute("id"),eleM.childNodes[0].nodeValue);
     tab_reponse.push(module);
    } 
            
  }
 
  return tab_reponse; 

}
