<?php
    $this->load->view( 'includes/entete', array( 'titre' => $titre ) );
    $this->load->view( 'includes/menu_haut' );
    $this->load->view('includes/menu_gauche', array( 'membre'=>$membre, 'erreurConnection' => $erreurConnection ) );
?>
<div id='colTwo'>
