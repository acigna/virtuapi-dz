<?php
  //Récupérer la libririe OMS, et afficher la partie haute
  $this->load->library('oms');
  $this->oms->partie_haute("L'équipe de VirtUAPI-DZ");
?>
<h2 class="center">L'équipe de VirtUAPI-DZ</h2><br/>
<h2 class="center">Les membres actifs</h2><br/>
<table align="center">
    <tr>
        <th>Nom</th>
        <th>Fonction</th>
        <th>Organisme</th>
        <th>E-Mail</th>
    </tr>
	  	 
    <tr>
        <td>Tarik Zakaria BENMERAR </td>
        <td>Chef De Projet</td>
	<td>Acigna Inc.</td>
	<td>tarik.benmerar[at]acigna.com</td>
    </tr>

</table>
<br/>
<h2 class="center">Contributions au projet</h2><br/>
<table align="center">
    <tr>
        <th>Nom</th>
        <th>Organisme</th>
        <th>Type de contribution</th>
    </tr>
    <tr>
        <td>Lamine BENMIMOUNE</td>
        <td>-</td>
        <td>Développement</td>
    </tr>
</table>

<?php
  //Afficher la partie basse
  $this->load->view('includes/partie_basse.php');
?>
   
