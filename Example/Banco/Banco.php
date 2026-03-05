<?php

class Banco
{
    var $nomeBanco;
    var $nomeUsuario;
    var $senha;
    var $localBanco;
    var $conexao;

    function __construct()
    {
        if (($_SERVER['SERVER_NAME'] == "www.bigcell.com.br") or ($_SERVER['SERVER_NAME'] == "bigcell.com.br")) {
            $this->nomeBanco = "bigcellc_ads2025";
            $this->nomeUsuario = "bigcellc_ads2025";
            $this->senha = "Ads*2025_";
            $this->localBanco = "localhost";
        } else {
            $this->nomeBanco = "";
            $this->nomeUsuario = "";
            $this->senha = "";
            $this->localBanco = "localhost";
        }

        $this->conexao = mysql_connect($this->localBanco, $this->nomeUsuario, $this->senha);
        mysql_select_db($this->nomeBanco, $this->conexao);
    }

    function executar($sql)
    {
        @$retorno = mysql_query($sql, $this->conexao);
        if (!$retorno) {
            die('Erro na consulta: ' . mysql_error());
            mail("mvassuncao1@gmail.com", "Erro em consulta SQL www.bigcell.com.br", mysql_errno() . ": " . mysql_error());
            return $retorno;
        }
        mysql_close($this->conexao);
        return $retorno;
    }
    function backup($tabela, $codRegistro)
    {
        return 0;
    }
}
