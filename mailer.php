<?php
if(isset($_POST['email'])) {

    // Editar as linhas abaixo conforme necessário
    $email_to = "sosrsform@gmail.com";
    $email_subject = "Nova Submissão de Formulário";


    function died($error) {
        // Seu código de erro pode ser colocado aqui
        echo "Desculpe-nos, mas encontramos erro(s) no formulário que você enviou. ";
        echo "Os erros estão listados abaixo.<br /><br />";
        echo $error."<br /><br />";
        echo "Por favor, volte e corrija esses erros.<br /><br />";
        die();
    }

    // Validação dos dados esperados
    if(!isset($_POST['nome']) ||
        !isset($_POST['email']) ||
        !isset($_POST['telefone']) ||
        !isset($_POST['story'])) {
        died('Desculpe-nos, mas parece haver um problema com o formulário que você enviou.');      
    }

    $nome = $_POST['nome']; // obrigatório
    $email_from = $_POST['email']; // obrigatório
    $telefone = $_POST['telefone']; // obrigatório
    $rede_social = $_POST['rede-social']; // opcional
    $story = $_POST['story']; // obrigatório

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
    if(!preg_match($email_exp,$email_from)) {
        $error_message .= 'O e-mail inserido não parece ser válido.<br />';
    }
    $string_exp = "/^[A-Za-z .'-]+$/";
    if(!preg_match($string_exp,$nome)) {
        $error_message .= 'O nome inserido não parece ser válido.<br />';
    }
    if(strlen($story) < 2) {
        $error_message .= 'A história inserida não parece ser válida.<br />';
    }

    if(strlen($error_message) > 0) {
        died($error_message);
    }

    // Monta a mensagem de e-mail
    $email_message = "Detalhes do formulário abaixo.\n\n";
    $email_message .= "Nome: " . $nome . "\n";
    $email_message .= "Email: " . $email_from . "\n";
    $email_message .= "Telefone/WhatsApp: " . $telefone . "\n";
    $email_message .= "Rede Social: " . $rede_social . "\n";
    $email_message .= "Conte a sua história: " . $story . "\n";

    // Cria o cabeçalho do e-mail
    $headers = 'From: ' . $email_from . "\r\n" .
               'Reply-To: ' . $email_from . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    // Envia o e-mail
    if(mail($email_to, $email_subject, $email_message, $headers)) {
        echo "Mensagem enviada com sucesso!";
    } else {
        echo "Erro ao enviar mensagem. Por favor, tente novamente mais tarde.";
    }
}
?>
