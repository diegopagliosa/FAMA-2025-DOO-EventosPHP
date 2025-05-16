<?php

class UserController
{
    static $secret_key = "batatinha123";

    public function retornaUsuarios()
    {
        if (isset($_GET["id_user"])) {
            $user = $this->retornaUser($_GET["id_user"]);
            unset($user->senha);
            echo json_encode($user);
        } else {
            $this->retornaTodosUsers();
        }
    }

    public function retornaUser(int $id)
    {
        $obj = new User();
        $user = $obj->getById($id);
        if (!$user) {
            http_response_code(404);
            die(json_encode(["error" => "User Não encontrado"]));
        }
        return $user;
    }

    public function retornaTodosUsers()
    {
        $obj = new User();
        $lista = $obj->getAll();
        echo json_encode($lista);
    }

    public function gravaUser()
    {
        $jsonEntrada = file_get_contents("php://input");
        $objJson = json_decode($jsonEntrada);
        //$this->validaEvento($objJson);
        $user = new User();
        $user->nome = $objJson->nome;
        $senhaCriptografada = password_hash($objJson->senha, PASSWORD_DEFAULT);
        $user->senha = $senhaCriptografada;
        if ($user->save($user)) {
            http_response_code(201);
            unset($user->senha);
            echo json_encode($user);
        } else {
            http_response_code(400);
            die("Erro ao gravar os dados");
        }
    }

    public function atualizaUser(User $user)
    {
        $jsonEntrada = file_get_contents("php://input");
        $objJson = json_decode($jsonEntrada);
        $userById = $this->retornaUser($objJson->id);

        if ($userById->id != $user->id) {
            http_response_code(403);
            die("Não é possivel atualizar outro usuário que não seja ocê mesmo.");
        }
        $userById->nome = $objJson->nome;
        if ($userById->update()) {
            unset($userById->senha);
            echo json_encode($userById);
            http_response_code(202);
        } else {
            echo "Erro ao Atualizar os dados";
            http_response_code(400);
            exit;
        }
    }


    public function excluiUser(User $user)
    {
        $eventos = $user->getEventos();
        if (sizeof($eventos) == 0) {
            $user->delete();
        } else {
            http_response_code(400);
            die("Usuário ainda tem Eventos Cadastrados.");
        }
    }


    public function login()
    {
        $jsonEntrada = file_get_contents("php://input");
        $obj = json_decode($jsonEntrada);
        if (isset($obj->id_user) && isset($obj->senha)) {
            $user = $this->retornaUser($obj->id_user);
            if ($user->id > 0) {
                if (password_verify($obj->senha, $user->senha)) {
                    http_response_code(200);
                    /**
                     * gero o token
                     */

                    $header = json_encode(["alg" => "HS256", "typ" => "JWT"]);
                    unset($user->senha);
                    $payload = json_encode($user);
                    $signature = hash_hmac(
                        'sha256',
                        $header . '.' . $payload,
                        UserController::$secret_key,
                        true
                    );
                    $header = base64_encode($header);
                    $payload = base64_encode($payload);
                    $signature = base64_encode($signature);
                    $token = $header . '.' . $payload . '.' . $signature;
                    die(json_encode(["token" => $token]));
                }
            }
        }
        http_response_code(401);
        die("Login ou Senha Incorretos.");
    }


    public function validaToken()
    {
        $headers = getallheaders();
        if (!isset($headers['Authorization'])) {
            http_response_code(401);
            die("Token Não encontrado");
        }
        $token = explode('.', $headers['Authorization']);
        $header = base64_decode($token[0]);
        $payload = base64_decode($token[1]);
        $signature = base64_decode($token[2]);
        $header_payload = $header . '.' . $payload;

        if (
            hash_hmac('sha256', $header_payload, UserController::$secret_key, true)
            !== $signature
        ) {
            http_response_code(401);
            die("Token Inválido");
        }
        $id_user = json_decode($payload)->id;
        $user = $this->retornaUser($id_user);
        if ($user->id <= 0) {
            http_response_code(401);
            die("Usuário Inválido.");
        }
        return $user;
    }


    public function retornaEventos(User $user)
    {
        error_log('123123');
        $meusEventos = $user->getEventos();
        echo json_encode($meusEventos);
    }
}
