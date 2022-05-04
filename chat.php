<?php
$requestedPath = explode('?', $_SERVER['REQUEST_URI'])[0];
$filePath = __DIR__ . '/messages.json';
$login = $_POST['login'];
$password = $_POST['password'];
$message = $_POST['message'];

    if (!empty($login) && !empty($password) && !empty($message))
    {
        $users = json_decode(file_get_contents(__DIR__ . "/users.json"), true);
        $input_password = $users[$login];

        if ($input_password === $password)
        {
            $json_message =
                [
                    "date" => date("Y-m-d h:i",time()),
                    "login" => $login,
                    "message" => $message
                ];
            LoadMessageToFile($json_message, $filePath);
        }
        else
        {
            echo("Введены неправильные данные");
        }

    }

function LoadMessageToFile($json_message, $filePath)
{
    $messages_file = json_decode(file_get_contents($filePath));
    $messages_file->messages[] = $json_message;
    file_put_contents($filePath, json_encode($messages_file));
}

    $messages_file = json_decode(file_get_contents($filePath));
    foreach($messages_file->messages as $message)
    {
        echo "<p>$message->date $message->login: $message->message</p>";
    }

?>

<style>
    body { font-family: 'Arial', sans-serif; }
    button:hover { background: blueviolet; }
    html {
        background: #e3c963;

        animation: background 3s ease-in 1s infinite reverse both running;

    }

    @keyframes background {
        50%
        {
            background: greenyellow;
        }
    }
</style>

<form action="/messenger/" method="POST">
    <input name="login", placeholder="Логин">
    <input name="password", placeholder="Пароль">
    <input name="message", placeholder="Сообщение">
    <button>Отправить сообщение</button>
</form>


