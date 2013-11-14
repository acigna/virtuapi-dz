<?php
    $this->load->helper('url');
?>
<div id="header">
	<ul id="menu">
			<li><a href="<?=base_url(); ?>" >Acceuil</a></li>
			<li><a href="<?=site_url(array('universite_virtuelle')); ?>">Université Virtuelle</a></li>
		    <li><a href="<?=site_url(array('equipe')); ?>">L'équipe</a></li>
            <li><a href="<?=site_url(array('contact')); ?>">Contactez-nous</a></li>  
     </ul>
	
</div>

<div id="content">
 <div id="head2">
  <div id="logo">
			<h1><a href="<?=base_url(); ?>">Acigna VirtUAPI-DZ</a></h1>
			<h2>Entraide et Collaboration pour tous</h2>
  </div>
 </div>
</div>
