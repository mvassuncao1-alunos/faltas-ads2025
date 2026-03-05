<?php
$hoje = new DateTime();

$faltas = [
    ["24/02/2026", "Edwarda Ingrid", "Capa Case", "14 pro max branca", "--", "para ter na loja", "1"],
    ["23/02/2026", "Josiane Fagundes", "Capa Case", "iphone 17 pro max", "lilas, cinza", "para ter na loja", "1 de cada"],
    ["24/02/2026", "Yasmin", "Capa Case", "poco f3", "vermelha, preta", "para ter na loja", "1 de cada"],
    ["12/02/2026", "Josiane Fagundes", "Capa Case", "SAMSUNG S26 FE", "todas as cores", "para ter na loja", "1 DE CADA"],
    ["23/02/2026", "Aline Pinheiro", "Outro", "cartão memoria 64 gb", "sandisk", "--", "3 UNIDADES"],
    ["20/02/2026", "Edwarda Ingrid", "Outro", "CHAVEIRO ROSA", "CONSULTAR", "encomenda", "✅"],
    ["10/01/2026", "Sistema", "Outro", "Item Antigo (Sumiu)", "--", "--", "✅"]
];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Big Cell - Controle</title>
    <link rel="stylesheet" href="../Source/style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>

    <div class="fundo-simples"></div>

    <div class="container">
        
        <div class="painel">
            <button class="btn btn-primario" onclick="abrirModal()">Adicionar Item</button>
            <button class="btn btn-secundario" onclick="entregarSelecionados()">Concluir Selecionados</button>
            <button class="btn btn-cinza" onclick="forcarMobile()">Versão Móvel</button>

            <div class="separador"></div>

            <button class="aba ativo" onclick="filtrar('pendente', this)">Pendentes</button>
            <button class="aba" onclick="filtrar('entregue', this)">Histórico</button>
        </div>

        <div class="tabela-box">
            <div class="linha cabecalho">
                <div class="centro"><input type="checkbox" onchange="selecionarTodos(this)"></div>
                <div>Data</div>
                <div>Funcionário</div>
                <div>Depto</div>
                <div>Aparelho</div>
                <div>Detalhe</div>
                <div>OBS</div>
                <div>Qtd</div>
                <div class="centro">Ações</div>
            </div>

            <div id="corpo-tabela">
                <?php 
                foreach ($faltas as $item): 
                    $entregue = strpos($item[6], '✅') !== false;
                    $status = $entregue ? "entregue" : "pendente";

                    // Regra de 10 dias
                    if ($entregue) {
                        $dataItem = DateTime::createFromFormat('d/m/Y', $item[0]);
                        if ($dataItem && $hoje->diff($dataItem)->days > 10) continue;
                    }
                ?>
                    <div class="linha item <?php echo $status; ?>">
                        <div class="centro" data-label="Sel">
                            <?php if(!$entregue): ?><input type="checkbox" class="chk-item"><?php endif; ?>
                        </div>
                        <div data-label="Data"><?php echo $item[0]; ?></div>
                        <div data-label="Func."><?php echo $item[1]; ?></div>
                        <div data-label="Depto"><?php echo $item[2]; ?></div>
                        <div data-label="Aparelho" class="negrito"><?php echo $item[3]; ?></div>
                        <div data-label="Detalhe"><?php echo $item[4]; ?></div>
                        <div data-label="OBS"><?php echo $item[5]; ?></div>
                        <div data-label="Qtd"><?php echo $item[6]; ?></div>
                        
                        <div class="acoes centro" data-label="Ações">
                            <?php if(!$entregue): ?>
                                <button class="icone check" onclick="marcarEntregue(this)"><span class="material-icons">check</span></button>
                            <?php else: ?>
                                <span class="texto-ok">✅</span>
                            <?php endif; ?>
                            <button class="icone del" onclick="excluirLinha(this)"><span class="material-icons">delete</span></button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div id="modal" class="modal-bg">
        <div class="modal-card">
            <h2>Adicionar Pedido</h2>
            
            <label>Data</label> <input type="date" id="m-data" class="input-box">
            <label>Funcionário</label>
            <select id="m-func" class="input-box">
                <option value="">Selecione...</option>
                <option>Edwarda Ingrid</option>
                <option>Josiane Fagundes</option>
                <option>Yasmin</option>
            </select>
            <label>Depto</label>
            <select id="m-depto" class="input-box">
                <option>Capa Case</option>
                <option>Pelicula</option>
                <option>Outro</option>
            </select>
            <label>Aparelho</label> <input type="text" id="m-aparelho" class="input-box">
            <label>Detalhe</label> <input type="text" id="m-detalhe" class="input-box">
            <label>Qtd</label> <input type="number" id="m-qtd" value="1" class="input-box">
            <label>OBS</label> <input type="text" id="m-obs" value="para ter na loja" class="input-box">

            <div class="modal-botoes">
                <button class="btn btn-cinza" onclick="fecharModal()">Cancelar</button>
                <button class="btn btn-primario" onclick="salvar()">Salvar</button>
            </div>
        </div>
    </div>

    <script src="listfalta.js"></script>
</body>
</html>