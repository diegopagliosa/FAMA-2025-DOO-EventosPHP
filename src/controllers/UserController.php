<?php

class UserController
{

    public function retornaUsuarios()
    {
        if (isset($_GET["id_evento"])) {
            $user = $this->retornaUser($_GET["id_user"]);
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
        unset($user->senha);
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

    public function atualizaUser()
    {
        $jsonEntrada = file_get_contents("php://input");
        $objJson = json_decode($jsonEntrada);
        $user = $this->retornaUser($objJson->id);
        $user->nome = $objJson->nome;
        if ($user->update()) {
            unset($user->senha);
            echo json_encode($user);
            http_response_code(202);
        } else {
            echo "Erro ao Atualizar os dados";
            http_response_code(400);
            exit;
        }
    }


    public function excluiUser()
    {
        if (isset($_GET["id_user"])) {
            $user = $this->retornaUser($_GET["id_user"]);
            $eventos = $user->getEventos();
            if (sizeof($eventos) == 0) {
                User::delete($_GET["id_user"]);
            } else {
                http_response_code(400);
                die("Usuário ainda tem Eventos Cadastrados.");
            }
        }
    }
}
