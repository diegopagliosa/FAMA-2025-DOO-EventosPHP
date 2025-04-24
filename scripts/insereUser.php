<?php

require_once(__DIR__ . '/../src/model/User.php');
require_once(__DIR__ . '/../src/model/Conexao.php');

$user = new User();
$user->nome = "Diego";
$senha = "123";
$senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);
$user->senha = $senhaCriptografada;
$user->save();

echo "\n";
echo "\n";

