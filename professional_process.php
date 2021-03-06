<?php 


require_once("connection.php");
require_once("globals.php");
require_once("Model/Message.php");

$message = new Message($BASE_URL);



if($_POST['type'] == "register_professional"){

	$data = $_POST;

	$empty_input = false;
			// Retirar os espaços em branco
			$data = array_map('trim', $data);
			// Retirar os espaços em branco em torno da string
			if (in_array("", $data)) {

				$empty_input = true;
				$message->setMessage("Não permitido espaços em branco","error","back");
			// Validar se o email digitado pelo usuário contém estrutura de email "user@user.com"
			} elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
				$empty_input = true;
				$message->setMessage("Formato de email inválido","error","back");
			}else{
				$name = $data['name'];
				$phone = $data['phone'];
				$email = $data['email'];
				$password = $data['password'];
				$type_user = $data['type_user'];
				$confirmPassword = $data['confirmPassword'];
                $city = $data['city'];


if($name && $phone && $email && $password && $confirmPassword && $type_user && $city){
	    
		if($password == $confirmPassword){

		 $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
	      $stmt->bindParam(':email', $email);
	      $stmt->execute();
	      $return = $stmt->rowCount();

	      if($return > 0){
	         //menssagem de erro usuario já existe
		      $message->setMessage("Usuário já cadastrado tente outro e-mail","error","back");
	      }else{
	        //nenhum usuário encontrado 
	      	try{
               $sql = "INSERT INTO users(name,email,phone,password,type_user,city) VALUES(:name,:email,:phone,:password,
			   :type_user,:city)";
			      $stmt = $conn->prepare($sql);
			      $stmt->bindParam(":name",$name);
					$stmt->bindParam(":email",$email);
					$stmt->bindParam(":phone",$phone);
					$stmt->bindParam(":password",$password);
					$stmt->bindParam(":type_user",$type_user);
					$stmt->bindParam(":city",$city);
	            $stmt->execute();
	            $message->setMessage("Usuário cadastrado com sucesso","success","back");
             

            }catch(Exception $e){
               echo $e->getMessage();
            }
	      }   

		}else{
			//menssagem de erro de senhas não batem
			$message->setMessage("As senhas não correspondem","error","back");
		}

	}else{
		//enviar menssagem de erro de dados faltantes
		$message->setMessage("Por favor preencha todos os campos","error","back");
	}



}
}
