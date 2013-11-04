<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<?php
		if (!empty($titre)) //Si le titre est indiqué , on l'affiche entre les balises <title>
		{
			echo '<title> VirtUAPI-DZ - '.stripslashes($titre).' </title>';
		}
		else //Sinon, on l'écrit title par d�faut
		{
			echo '<title> VirtUAPI-DZ </title>';
		}
		?>
	<meta name="author" content="L'équipe VirtUAPI-DZ" />
	<meta name="copyright"	content="Copyright 2009 VirtAPI-DZ" />	
	<meta name="keywords" content="VirtUAPI-DZ, community, students, étudiant, communauté, entraide, collaboration, algérie, algeria" />
	<meta name="description" content="Un portail d'entraide et de collaboration pour les étudiants algériens" />	
	<meta http-equiv="imagetoolbar" content="no" />
	<link href="<?=base_url(); ?>default.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url(); ?>css/virtuapidz.css" rel="stylesheet" type="text/css" />
        <?php
            //Intégrer les fichiers CSS
            foreach($css as $el) {
        ?>
                <link href="<?=$el ?>" rel="stylesheet" type="text/css" />
        <?php 
            }
        ?>
        <?php
           //Intégrer les fichiers Javascript
           foreach($js as $el) {
        ?>
               <script type="text/javascript" src="<?=$el ?>" >
               </script>
        <?php
            }
        ?>

	<script type="text/javascript">
<!--
<?php

 $nombreSpecialite = mysql_fetch_array(mysql_query("select count(*) from specialite"));

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


