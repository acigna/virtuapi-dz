function _$(id){return document.getElementById(id)||id}; 

// Objet pour les requêtes AJAX.

function ajax(url,callback,parametres_callback)
{
   this.xhr=null;	
   this.url=url;
   this.callback=callback;
   this.parametres_callback=parametres_callback;
}

ajax.prototype={

getXMLHttpRequest: function getXMLHttpRequest()
 		   {
			var xhr = null;
	
			if (window.XMLHttpRequest || window.ActiveXObject) 
			{
				if (window.ActiveXObject) 
				{
					try {
				   	     xhr = new ActiveXObject("Msxml2.XMLHTTP");
					    } catch(e) {
						xhr = new ActiveXObject("Microsoft.XMLHTTP");
					    }
				} else {
					xhr = new XMLHttpRequest(); 
				}
			} else {
				alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
				return null;
			}
	
			return xhr;
  		   },
  
  
lancerRequete: function()
  	  	 {
  	  	 	 var _this=this; 	 
  	  	 	 if(this.xhr && this.xhr.readyState != 0) 
  	  	    	 {
		             this.xhr.abort(); // On annule la requête en cours !
		 	 }
  	
  			 this.xhr = this.getXMLHttpRequest(); 	 
  	  	 	 this.xhr.onreadystatechange=function(){
  			 	if(this.readyState == 4 && (this.status == 200 || this.status == 0)) 
  			 	{
  			 		_this.callback(this.responseXML,_this.parametres_callback);
                       			_this.xhr=null;
			 	}	  
  		 	 };
  
    			 this.xhr.open("GET", this.url, true);
    			 this.xhr.send("");
    	 }
  	  	 
};

// Partie Chapitre de la requête AJAX

function lancer_chapitre(url,elementReponse)
{
	ajax_obj=new ajax(url,remplir_chapitre,elementReponse);
	ajax_obj.lancerRequete();
}


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


function remplir_chapitre(reponse,elementResultat)
{
   var chapitres_select="";
 
   var tab_reponse=reponse_chapitre(reponse);
   
      
   for each(chapitre in tab_reponse)
   	chapitres_select+='<option value="'+chapitre[0]+'">'+chapitre[1]+' : '+chapitre[2]+'</option>';  
   
   _$(elementResultat).innerHTML=chapitres_select;
   
 
}

// Partie Module de la requête AJAX

function lancer_module(url,parametresReponse)
{
	ajax_obj=new ajax(url,remplir_module,parametresReponse);
	ajax_obj.lancerRequete();
}

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


function remplir_module(reponse,parametresReponse)
{
 
   var modules_select="";
   var tab_reponse=reponse_module(reponse);
   for each(module in tab_reponse)
   	modules_select+='<option value="'+module[0]+'">'+module[1]+'</option>';  
   
   element_module=_$(parametresReponse[0]);
   element_module.innerHTML=modules_select;
   
   if(parametresReponse[3]==true)
   {
   	if(element_module.innerHTML!="")
   	{
   	     lancer_chapitre(parametresReponse[1]+element_module.options[element_module.selectedIndex].value,parametresReponse[2]);
   	}else{
   	     _$(parametresReponse[2]).innerHTML="";	
   	}
   }
}
