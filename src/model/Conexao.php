<?php

class Conexao
{
    private $host = "localhost";
    private $port = "3306";
    private $base = "Aula1202";
    private $user = "root";
    private $password = "123456";
    private $conexao = null;

    public function conecta()
    {
        if (!$this->conexao) {
            $this->conexao = mysqli_connect(
                $this->host,
                $this->user,
                $this->password,
                $this->base,
                $this->port
            );
        }
        return $this->conexao;
    }

    public function close()
    {
        mysqli_close($this->conexao);
    }
}
