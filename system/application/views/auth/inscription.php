<?php
  //Charger le helper url
  $this->load->helper('url');

  //Récupérer la libririe OMS, et afficher la partie haute
  $this->load->library('oms');
  $this->oms->partie_haute("Le formulaire d'inscription");
?>

<form method="POST" class="form"> 
<p>
  <h2>Veuillez entrer vos coordonnées ci-dessous:</h2>
  <table>
    <tr>
      <td class="right"><label for="Nom">Nom:</label></td> 
      <td class="left"><input type="text" name="Nom" id="Nom" value=""/></td>
    </tr>
     
    <tr>
      <td class="right"><label for="Prenom">Prénom:</label></td> 
      <td class="left"><input type="text" name="Prenom" id="Prenom" value=""/></td>
    </tr>
    
    <tr>
      <td class="right"><label for="Pseudo">Pseudo:</label></td> 
      <td class="left"><input type="text" name="Pseudo" id="pseudo" value=""/></td> 
    </tr>
  </table><br/>
  <div class="center"><input type="button"  value="Vérifier la disponibilité du pseudo" /><br/></div>
  Et vous êtes ?<br/>
  <label><input type="radio"  name="TypeMembre" value="etudiant"/>étudiant</label>
  <label><input type="radio" name="TypeMembre" value="enseignant"/>enseignant</label>
  <label><input type="radio"  name="TypeMembre" value="autres"/>autres</label><br/><br/>
  <table>
    <tr>
      <td class="right"><label for="EMail">Addresse e-mail:</label></td> 
      <td class="left"><input type="text" name="EMail" id="EMail" value=""/></td>
    </tr>
    <tr>
      <td class="right"><label for="MotDePasse">Choisissez un mot de passe:</label></td> 
      <td class="left"><input type="password"  name="MotDePasse" id="MotDePasse" value=""/></td> 
    </tr>
    <tr>
      <td class="right"><label for="MotDePasseConfirm">Confirmer le mot de passe:</label></td>
      <td class="left"><input  type="password"  name="MotDePasseConfirm" id="MotDePasseConfirm" value=""/></td> 
    </tr>

    <tr>
      <td class="right"><label for="code"> ?</label></td>
      <td class="left"><input  type="text"  name="code" id="code" /></td> 
    </tr>  
  </table>
  <br/><div class="center"><input type="submit" value="Créer mon compte"/></div>
  
</p>
</form>
<?php
  //Afficher la partie basse
  $this->load->view('includes/partie_basse.php');
?> 
