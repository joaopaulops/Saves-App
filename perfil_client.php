<?php 
require_once("templates/header.php");



$id =  $_SESSION['id_user'];
$stmt = $conn->query("SELECT * FROM users WHERE id_user = '{$id}'");
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$name = $user['name'];
$phone = $user['phone'];
$email = $user['email'];



?>


<main class="container">
 <div class="grid">
  <fieldset class="perfilc">
   
  <pre>
   Nome:       <?= $name ?></br>
   E-mail:     <?= $email ?></br>
   Telefone:   <?= $phone ?>
  </pre>
   
  </fieldset>
 </div>
</main>

<?php require_once("templates/footer.php")?> 