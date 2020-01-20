<?php


$password = "lösenord";

echo $password . "<br>";

$hashed = password_hash($password, PASSWORD_DEFAULT);

echo $hashed ."<br>";

$verified = password_verify($password, $hashed);

if ($verified){
    echo "Logged In!";
} else {
    echo "Oof";
}