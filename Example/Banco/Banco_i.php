<?php
date_default_timezone_set('America/Sao_Paulo');

class Banco_i {

    var $nomeBanco;
    var $nomeUsuario;
    var $senha;
    var $localBanco;
    var $conexao;

    function __construct() {
        if (empty($_REQUEST)) {
            $this->nomeBanco = "";
            $this->nomeUsuario = "";
            $this->senha = "";
            $this->localBanco = "localhost";
        } else {
            if (($_SERVER['SERVER_NAME'] == "www.bigcell.com.br") or ( $_SERVER['SERVER_NAME'] == "bigcell.com.br")) {
                $this->nomeBanco = "";
                $this->nomeUsuario = "";
                $this->senha = "";
                $this->localBanco = "localhost";
            } else {
                $this->nomeBanco = "";
                $this->nomeUsuario = "";
                $this->senha = "";
                $this->localBanco = "localhost";
            }
        }
        $this->conexao = new mysqli($this->localBanco, $this->nomeUsuario, $this->senha, $this->nomeBanco);
    }

    function executar($sql) {
        $result = $this->conexao->query($sql);
        //echo mysqli_insert_id($this->conexao);
        $_SESSION['SQL'] = $sql;
        $_SESSION['retornoMySQL'] = mysqli_insert_id($this->conexao);
        $this->conexao->close();
        return $result;
    }
}

?>