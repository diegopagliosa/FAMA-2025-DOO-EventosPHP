<?php

class Evento
{

    public $id_evento;
    public $nome;
    public $data_evento;
    public $endereco;
    public $descricao;
    public $max_vagas;
    public $user_id;

    /**
     * @param int $id_evento
     * @return Evento
     */
    public function getById($id_evento)
    {
        $evento = false;
        $conexao = new Conexao();
        $conn = $conexao->conecta();
        if (!$conn) {
            die('Erro Ao conectar no banco de dados');
        }
        $select = "SELECT * from eventos where id_evento = {$id_evento}";
        $result = mysqli_query($conn, $select);
        if ($row = mysqli_fetch_assoc($result)) {
            $evento = new Evento();
            $evento->id_evento = $row['id_evento'];
            $evento->nome = $row['nome'];
            $evento->data_evento = $row['data_evento'];
            $evento->endereco = $row['endereco'];
            $evento->descricao = $row['descricao'];
            $evento->max_vagas = $row['max_vagas'];
            $evento->user_id = $row['user_id'];
        }
        $conn->close();
        return $evento;
    }

    /**
     * @return Evento[]
     */
    public function getAll()
    {
        $lista_eventos = [];
        $conn = new Conexao();
        $conn = $conn->conecta();
        if (!$conn) {
            die('Erro Ao conectar no banco de dados');
        }
        $select = 'SELECT * from eventos';
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

    /**
     * @return Evento
     */
    public function save()
    {
        $conexao = new Conexao();
        $conn = $conexao->conecta();
        if (!$conn) {
            die('Erro Ao conectar no banco de dados');
        }
        $sql = "INSERT into eventos(nome, data_evento, endereco, descricao, max_vagas, user_id)
         values(?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "ssssii",
            $this->nome,
            $this->data_evento,
            $this->endereco,
            $this->descricao,
            $this->max_vagas,
            $this->user_id
        );
        if ($stmt->execute()) {
            $this->id_evento = $conn->insert_id;
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
        $sql = "UPDATE eventos set nome=?, data_evento=?, 
        endereco=?, descricao=?, max_vagas=?
         where id_evento = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "ssssii",
            $this->nome,
            $this->data_evento,
            $this->endereco,
            $this->descricao,
            $this->max_vagas,
            $this->id_evento
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
     * @param int $id_evento
     * @return boolean
     */
    public static function delete($id_evento)
    {
        $conexao = new Conexao();
        $conn = $conexao->conecta();
        if (!$conn) {
            die('Erro Ao conectar no banco de dados');
        }
        $sql = "DELETE from eventos 
         where id_evento = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "i",
            $id_evento
        );
        if ($stmt->execute()) {
            $conn->close();
            return true;
        } else {
            $conn->close();
            return false;
        }
    }

    public function jsonToEvento(stdClass $objJson)
    {
        $this->id_evento = (isset($objJson->id_evento)) ? $objJson->id_evento : null;
        $this->nome = $objJson->nome;
        $this->data_evento = $objJson->data_evento;
        $this->endereco = $objJson->endereco;
        $this->descricao = $objJson->descricao;
        $this->max_vagas = $objJson->max_vagas;
    }
}
