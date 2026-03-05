<?php
header("Content-Type: text/html; charset=utf-8", true);
$dados = $_POST;
require_once("../Controle/ControleCliente.php");

$objControleCliente = new ControleCliente;
$retorno = $objControleCliente->alterar($dados);

if ($retorno == true)
    echo '
	<script language="javascript" type="text/javascript">
			alert("Cliente alterado com Sucesso!!");
			location.href = "../Telas/listCliente.php"; 
	</script>';
else
    echo '
	<script language="javascript" type="text/javascript">
			alert("O cliente não pôde ser alterado!");
			location.href = "../Telas/listMovProdutoServico.php"; 
	</script>';
?>