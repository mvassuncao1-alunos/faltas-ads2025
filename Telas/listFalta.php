<?php
// 1. Pegamos a data atual para calcular a regra dos 10 dias no histórico
$hoje = new DateTime();

// 2. Seu Banco de Dados (Array estático)
$faltas = [
    ["24/02/2026", "Edwarda Ingrid", "Capa Case", "14 pro max branca", "--", "para ter na loja", "1"],
    ["23/02/2026", "Josiane Fagundes", "Capa Case", "iphone 17 pro max", "lilas, cinza", "para ter na loja", "1 de cada"],
    ["24/02/2026", "Yasmin", "Capa Case", "poco f3", "vermelha, preta", "para ter na loja", "1 de cada"],
    ["24/02/2026", "Yasmin", "Capa Case", "poco x5", "lilas, roxa", "para ter na loja", "1 de cada"],
    ["12/02/2026", "Josiane Fagundes", "Capa Case", "SAMSUNG S26 FE", "todas as cores", "para ter na loja", "1 DE CADA"],
    ["23/02/2026", "Aline Pinheiro", "Outro", "cartão memoria 64 gb", "sandisk", "--", "3 UNIDADES"],
    // Item Entregue (Identificado pelo ✅)
    ["20/02/2026", "Edwarda Ingrid", "Outro", "CHAVEIRO ROSA", "CONSULTAR", "encomenda", "✅"],
    // Item antigo (Mais de 10 dias) - Esse não vai aparecer na tela por causa da regra do PHP!
    ["10/01/2026", "Sistema", "Outro", "Item Antigo (Sumiu)", "--", "--", "✅"]
];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Big Cell - Controle de Faltas</title>
    
    <link rel="stylesheet" href="lista.css">
    
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>

    <div class="fundo-fluxo"></div>

    <div class="container">
        
        <div class="painel-topo">
            <button class="btn btn-roxo-escuro" onclick="abrirModal()">
                <span class="material-icons">add_circle</span> Adicionar Item
            </button>

            <button class="btn btn-roxo-medio" onclick="entregarSelecionados()">
                <span class="material-icons">done_all</span> Concluir Selecionados
            </button>
            
            <button class="btn btn-cinza" onclick="forcarMobile()">
                <span class="material-icons">smartphone</span> Versão Móvel
            </button>

            <div class="divisor"></div>

            <button class="btn-aba ativo" onclick="filtrarAbas('pendente', this)">Pendentes</button>
            <button class="btn-aba" onclick="filtrarAbas('entregue', this)">Histórico Entregues</button>
        </div>

        <div class="tabela-container">
            <div class="grid-row header">
                <div class="center" style="width: 30px;">
                    <input type="checkbox" onchange="selecionarTodos(this)">
                </div>
                <div>Data</div>
                <div>Funcionário</div>
                <div>Depto.</div>
                <div>Aparelho</div>
                <div>Detalhe</div>
                <div>OBS Loja</div>
                <div>Qtd</div>
                <div class="center">Ações</div>
            </div>

            <div id="lista-corpo">
                <?php 
                foreach ($faltas as $index => $item): 
                    $isEntregue = strpos($item[6], '✅') !== false;
                    $classeStatus = $isEntregue ? "entregue" : "pendente";

                    // REGRA DOS 10 DIAS
                    if ($isEntregue) {
                        $dataItem = DateTime::createFromFormat('d/m/Y', $item[0]);
                        if ($dataItem) {
                            $diasPassados = $hoje->diff($dataItem)->days;
                            if ($diasPassados > 10) {
                                continue; // Pula este item se passou do prazo
                            }
                        }
                    }
                ?>
                    <div class="grid-row item <?php echo $classeStatus; ?>" id="linha-<?php echo $index; ?>">
                        <div class="center" data-label="Sel">
                            <?php if(!$isEntregue): ?>
                                <input type="checkbox" class="check-item">
                            <?php endif; ?>
                        </div>
                        <div data-label="Data"><?php echo $item[0]; ?></div>
                        <div data-label="Funcionário"><?php echo $item[1]; ?></div>
                        <div data-label="Depto."><?php echo $item[2]; ?></div>
                        <div data-label="Aparelho" class="destaque-texto"><?php echo $item[3]; ?></div>
                        <div data-label="Detalhe"><?php echo $item[4]; ?></div>
                        <div data-label="OBS"><?php echo $item[5]; ?></div>
                        <div data-label="Qtd"><?php echo $item[6]; ?></div>
                        
                        <div data-label="Ações" class="acoes center">
                            <?php if(!$isEntregue): ?>
                                <button class="btn-icon icone-roxo" onclick="marcarComoEntregue(this)" title="Marcar Entregue">
                                    <span class="material-icons">check_circle</span>
                                </button>
                            <?php else: ?>
                                <span style="color: #5B2A86; font-weight: bold; font-size: 12px;">✅</span>
                            <?php endif; ?>

                            <button class="btn-icon icone-excluir" onclick="deletarLinha(this)" title="Excluir">
                                <span class="material-icons">delete</span>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div id="modal-adicionar" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-header">
                <h2>Adicionar Pedido</h2>
                <span class="close-btn" onclick="fecharModal()">&times;</span>
            </div>
            
            <div class="form-grid">
                <div class="campo-full">
                    <label>Data</label>
                    <input type="date" id="inp-data" class="input-form">
                </div>
                
                <div class="campo-full">
                    <label>Funcionário</label>
                    <select id="inp-func" class="input-form">
                        <option value="">Selecione...</option>
                        <option value="Edwarda Ingrid">Edwarda Ingrid</option>
                        <option value="Josiane Fagundes">Josiane Fagundes</option>
                        <option value="Yasmin">Yasmin</option>
                        <option value="Aline Pinheiro">Aline Pinheiro</option>
                    </select>
                </div>

                <div class="campo-full">
                    <label>Departamento</label>
                    <select id="inp-depto" class="input-form">
                        <option value="Capa Case">Capa Case</option>
                        <option value="Pelicula">Pelicula</option>
                        <option value="Outro">Outro</option>
                        <option value="Eletrônicos">Eletrônicos</option>
                    </select>
                </div>

                <div class="campo-full">
                    <label>Aparelho</label>
                    <input type="text" id="inp-aparelho" placeholder="Ex: iPhone 13 Pro Max" class="input-form">
                </div>

                <div class="campo-duplo">
                    <div>
                        <label>Detalhe</label>
                        <input type="text" id="inp-detalhe" placeholder="Cor, Tipo..." class="input-form">
                    </div>
                    <div>
                        <label>Qtd</label>
                        <input type="number" id="inp-qtd" value="1" min="1" class="input-form">
                    </div>
                </div>

                <div class="campo-full">
                    <label>OBS Loja</label>
                    <input type="text" id="inp-obs" value="para ter na loja" class="input-form">
                </div>
            </div>

            <div class="modal-buttons">
                <button class="btn btn-cinza" onclick="fecharModal()">Cancelar</button>
                <button class="btn btn-roxo-escuro" onclick="salvarNovoItem()">Salvar</button>
            </div>
        </div>
    </div>

    <script src="listfalta.js"></script>
</body>
</html><?php
// 1. Pegamos a data atual para calcular a regra dos 10 dias no histórico
$hoje = new DateTime();

// 2. Seu Banco de Dados (Array estático)
$faltas = [
    ["24/02/2026", "Edwarda Ingrid", "Capa Case", "14 pro max branca", "--", "para ter na loja", "1"],
    ["23/02/2026", "Josiane Fagundes", "Capa Case", "iphone 17 pro max", "lilas, cinza", "para ter na loja", "1 de cada"],
    ["24/02/2026", "Yasmin", "Capa Case", "poco f3", "vermelha, preta", "para ter na loja", "1 de cada"],
    ["24/02/2026", "Yasmin", "Capa Case", "poco x5", "lilas, roxa", "para ter na loja", "1 de cada"],
    ["12/02/2026", "Josiane Fagundes", "Capa Case", "SAMSUNG S26 FE", "todas as cores", "para ter na loja", "1 DE CADA"],
    ["23/02/2026", "Aline Pinheiro", "Outro", "cartão memoria 64 gb", "sandisk", "--", "3 UNIDADES"],
    // Item Entregue (Identificado pelo ✅)
    ["20/02/2026", "Edwarda Ingrid", "Outro", "CHAVEIRO ROSA", "CONSULTAR", "encomenda", "✅"],
    // Item antigo (Mais de 10 dias) - Esse não vai aparecer na tela por causa da regra do PHP!
    ["10/01/2026", "Sistema", "Outro", "Item Antigo (Sumiu)", "--", "--", "✅"]
];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Big Cell - Controle de Faltas</title>
    
    <link rel="stylesheet" href="lista.css">
    
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>

    <div class="fundo-fluxo"></div>

    <div class="container">
        
        <div class="painel-topo">
            <button class="btn btn-roxo-escuro" onclick="abrirModal()">
                <span class="material-icons">add_circle</span> Adicionar Item
            </button>

            <button class="btn btn-roxo-medio" onclick="entregarSelecionados()">
                <span class="material-icons">done_all</span> Concluir Selecionados
            </button>
            
            <button class="btn btn-cinza" onclick="forcarMobile()">
                <span class="material-icons">smartphone</span> Versão Móvel
            </button>

            <div class="divisor"></div>

            <button class="btn-aba ativo" onclick="filtrarAbas('pendente', this)">Pendentes</button>
            <button class="btn-aba" onclick="filtrarAbas('entregue', this)">Histórico Entregues</button>
        </div>

        <div class="tabela-container">
            <div class="grid-row header">
                <div class="center" style="width: 30px;">
                    <input type="checkbox" onchange="selecionarTodos(this)">
                </div>
                <div>Data</div>
                <div>Funcionário</div>
                <div>Depto.</div>
                <div>Aparelho</div>
                <div>Detalhe</div>
                <div>OBS Loja</div>
                <div>Qtd</div>
                <div class="center">Ações</div>
            </div>

            <div id="lista-corpo">
                <?php 
                foreach ($faltas as $index => $item): 
                    $isEntregue = strpos($item[6], '✅') !== false;
                    $classeStatus = $isEntregue ? "entregue" : "pendente";

                    // REGRA DOS 10 DIAS
                    if ($isEntregue) {
                        $dataItem = DateTime::createFromFormat('d/m/Y', $item[0]);
                        if ($dataItem) {
                            $diasPassados = $hoje->diff($dataItem)->days;
                            if ($diasPassados > 10) {
                                continue; // Pula este item se passou do prazo
                            }
                        }
                    }
                ?>
                    <div class="grid-row item <?php echo $classeStatus; ?>" id="linha-<?php echo $index; ?>">
                        <div class="center" data-label="Sel">
                            <?php if(!$isEntregue): ?>
                                <input type="checkbox" class="check-item">
                            <?php endif; ?>
                        </div>
                        <div data-label="Data"><?php echo $item[0]; ?></div>
                        <div data-label="Funcionário"><?php echo $item[1]; ?></div>
                        <div data-label="Depto."><?php echo $item[2]; ?></div>
                        <div data-label="Aparelho" class="destaque-texto"><?php echo $item[3]; ?></div>
                        <div data-label="Detalhe"><?php echo $item[4]; ?></div>
                        <div data-label="OBS"><?php echo $item[5]; ?></div>
                        <div data-label="Qtd"><?php echo $item[6]; ?></div>
                        
                        <div data-label="Ações" class="acoes center">
                            <?php if(!$isEntregue): ?>
                                <button class="btn-icon icone-roxo" onclick="marcarComoEntregue(this)" title="Marcar Entregue">
                                    <span class="material-icons">check_circle</span>
                                </button>
                            <?php else: ?>
                                <span style="color: #5B2A86; font-weight: bold; font-size: 12px;">✅</span>
                            <?php endif; ?>

                            <button class="btn-icon icone-excluir" onclick="deletarLinha(this)" title="Excluir">
                                <span class="material-icons">delete</span>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div id="modal-adicionar" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-header">
                <h2>Adicionar Pedido</h2>
                <span class="close-btn" onclick="fecharModal()">&times;</span>
            </div>
            
            <div class="form-grid">
                <div class="campo-full">
                    <label>Data</label>
                    <input type="date" id="inp-data" class="input-form">
                </div>
                
                <div class="campo-full">
                    <label>Funcionário</label>
                    <select id="inp-func" class="input-form">
                        <option value="">Selecione...</option>
                        <option value="Edwarda Ingrid">Edwarda Ingrid</option>
                        <option value="Josiane Fagundes">Josiane Fagundes</option>
                        <option value="Yasmin">Yasmin</option>
                        <option value="Aline Pinheiro">Aline Pinheiro</option>
                    </select>
                </div>

                <div class="campo-full">
                    <label>Departamento</label>
                    <select id="inp-depto" class="input-form">
                        <option value="Capa Case">Capa Case</option>
                        <option value="Pelicula">Pelicula</option>
                        <option value="Outro">Outro</option>
                        <option value="Eletrônicos">Eletrônicos</option>
                    </select>
                </div>

                <div class="campo-full">
                    <label>Aparelho</label>
                    <input type="text" id="inp-aparelho" placeholder="Ex: iPhone 13 Pro Max" class="input-form">
                </div>

                <div class="campo-duplo">
                    <div>
                        <label>Detalhe</label>
                        <input type="text" id="inp-detalhe" placeholder="Cor, Tipo..." class="input-form">
                    </div>
                    <div>
                        <label>Qtd</label>
                        <input type="number" id="inp-qtd" value="1" min="1" class="input-form">
                    </div>
                </div>

                <div class="campo-full">
                    <label>OBS Loja</label>
                    <input type="text" id="inp-obs" value="para ter na loja" class="input-form">
                </div>
            </div>

            <div class="modal-buttons">
                <button class="btn btn-cinza" onclick="fecharModal()">Cancelar</button>
                <button class="btn btn-roxo-escuro" onclick="salvarNovoItem()">Salvar</button>
            </div>
        </div>
    </div>

    <script src="listfalta.js"></script>
</body>
</html>