<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<?php
		if (!empty($titre)) //Si le titre est indiqué , on l'affiche entre les balises <title>
		{
			echo '<title> Open Mind Students - '.stripslashes($titre).' </title>';
		}
		else //Sinon, on l'écrit title par d�faut
		{
			echo '<title> Open Mind Students </title>';
		}
		?>
	<meta name="author" content="L'équipe Open Mind Students" />
	<meta name="copyright"	content="Copyright 2009 Open Mind Students" />	
	<meta name="keywords" content="Open Mind Students, community, students, étudiant, communauté,entraide, collaboration,algérie, algeria" />
	<meta name="description" content="Un portail d'entraide et de collaboration pour les étudiants algériens" />	
	<meta http-equiv="imagetoolbar" content="no" />
	<link href="<?php echo base_url(); ?>default.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript">
<!--
<?php

 $nombreSpecialite=mysql_fetch_array(mysql_query("select count(*) from specialite"));

?>
window.onload=montre;
function montre(id) {
var d = document.getElementById(id);
	for (var i = 1; i<=<?php echo $nombreSpecialite[0] ?>; i++) {
		if (document.getElementById('smenu'+i)) {document.getElementById('smenu'+i).style.display='none';}
	}
if (d) {d.style.display='block';}
}
//-->
</script> 	
</head>

<body>
  <div id='content'>


