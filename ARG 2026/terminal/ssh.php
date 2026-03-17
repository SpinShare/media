<?php
header('Content-Type: text/plain; charset=UTF-8');

$authorization = $_SERVER['HTTP_AUTHORIZATION'] ?? null;
$isAuthorized = $authorization === "star_gazer spinsofast";

if(!$isAuthorized) {
    $commands = [
        'help' => 'help',
        'login' => 'login',
        'whoami' => 'whoami'
    ];
} else {
    $commands = [
        'help' => 'help',
        'love' => 'love',
        'login' => 'login',
        'whoami' => 'whoami'
    ];
}

$input = $_POST['input'] ?? '';
if (!$input) {
    return;
}

$parts = explode(' ', $input);
$command = $parts[0];
$args = array_slice($parts, 1);

if (!isset($commands[$command])) {
    echo "$command: command not found. Type 'help' for a list of available commands.";
    return;
}

try {
    echo $commands[$command]($args);
} catch (Exception $e) {
    echo "§F44Error executing command: " . $e->getMessage();
}

function help($args) {
    global $isAuthorized;
    
    if(!$isAuthorized) {
        return  "§fffhelp                        §666Show this help message\n" .
                "§fffclear                       §666Clear the screen\n" .
                "§ffflogin [username] [password] §666Log in to the system\n" .
                "§fffwhoami                      §666Display the current user";
    } else {
        return  "§fffhelp                        §666Show this help message\n" .
                "§fffclear                       §666Clear the screen\n" .
                "§ffflove [your name]            §666Express your love\n" .
                "§ffflogin [username] [password] §666Log in to the system\n" .
                "§fffwhoami                      §666Display the current user";
    }
}

function whoami($args) {
    global $isAuthorized;

    if($isAuthorized) {
        return "You are §54Fstar_gazer§o.";
    } else {
        return "I don't know.";
    }
}

function love($args) {
    if(count($args) === 0) {
        return "Usage: love [your name]";
    }
    return "§F55I love you too, {$args[0]}!";
}

function login($args) {
    $username = $args[0] ?? null;
    $password = $args[1] ?? null;

    if(!$username || !$password) {
        return "Usage: login [username] [password]";
    }

    if($username === "star_gazer" && $password === "spinsofast") {
        return "§5F5Login successful! Welcome, star_gazer";
    } else {
        return "§F55Login failed: Invalid username or password.";
    }
}