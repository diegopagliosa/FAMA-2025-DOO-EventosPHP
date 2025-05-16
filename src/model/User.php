<?php

class User
{

    public $id;
    public $nome;
    public $senha;

    /**
     * @param int $id
     * @return User
     */
    public function getById($id)
    {
        $user = false;
        $conexao = new Conexao();
        $conn = $conexao->conecta();
        if (!$conn) {
            die('Erro Ao conectar no banco de dados');
        }
        $select = "SELECT * from users where id = {$id}";
        $result = mysqli_query($conn, $select);
        if ($row = mysqli_fetch_assoc($result)) {
            $user = new User();
            $user->id = $row['id'];
            $user->nome = $row['nome'];
            $user->senha = $row['senha'];
        }
        $conn->close();
        return $user;
    }

    /**
     * @return Users[]
     */
    public function getAll()
    {
        $lista_users = [];
        $conn = new Conexao();
        $conn = $conn->conecta();
        if (!$conn) {
            die('Erro Ao conectar no banco de dados');
        }
        $select = 'SELECT * from users';
        $result = mysqli_query($conn, $select);
        while ($row = mysqli_fetch_assoc($result)) {
            $user = new User();
            $user->id = $row['id'];
            $user->nome = $row['nome'];
            //$user->senha = $row['senha'];
            $lista_users[] = $user;
        }
        $conn->close();
        return $lista_users;
    }

    /**
     * @return User
     */
    public function save()
    {
        $conexao = new Conexao();
        $conn = $conexao->conecta();
        if (!$conn) {
            die('Erro Ao conectar no banco de dados');
        }
        $sql = "INSERT into users(nome, senha)
         values(?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "ss",
            $this->nome,
            $this->senha
        );
        if ($stmt->execute()) {
            $this->id = $conn->insert_id;
            $conn->close();
            return true;
        } else {
            $conn->close();
            return false;
        }
    }

    /**
     * @return boolean
     */
    public function update()
    {
        $conexao = new Conexao();
        $conn = $conexao->conecta();
        if (!$conn) {
            die('Erro Ao conectar no banco de dados');
        }
        $sql = "UPDATE users set nome=?
         where id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "si",
            $this->nome,
            $this->id
        );
        if ($stmt->execute()) {
            $conn->close();
            return true;
        } else {
            $conn->close();
            return false;
        }
    }

    /**
     * @param int $id
     * @return boolean
     */
    public function delete()
    {
        $conexao = new Conexao();
        $conn = $conexao->conecta();
        if (!$conn) {
            die('Erro Ao conectar no banco de dados');
        }
        $sql = "DELETE from users 
         where id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "i",
            $this->id
        );
        if ($stmt->execute()) {
            $conn->close();
            return true;
        } else {
            $conn->close();
            return false;
        }
    }


    /**
     * @return Evento[]
     */
    public function getEventos()
    {
        $lista_eventos = [];
        $conn = new Conexao();
        $conn = $conn->conecta();
        if (!$conn) {
            die('Erro Ao conectar no banco de dados');
        }
        $select = "SELECT * from eventos where user_id = {$this->id}";
        error_log($select);
        $result = mysqli_query($conn, $select);
        while ($row = mysqli_fetch_assoc($result)) {
            $evento = new Evento();
            $evento->id_evento = $row['id_evento'];
            $evento->nome = $row['nome'];
            $evento->data_evento = $row['data_evento'];
            $evento->endereco = $row['endereco'];
            $evento->descricao = $row['descricao'];
            $evento->max_vagas = $row['max_vagas'];
            $evento->user_id = $row['user_id'];
            $lista_eventos[] = $evento;
        }
        $conn->close();
        return $lista_eventos;
    }
}
