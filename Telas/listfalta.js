let abaAtual = 'pendente'; 

// --- 1. MODAL ---
function abrirModal() {
    document.getElementById('modal-adicionar').style.display = 'flex';
    document.getElementById('inp-data').value = new Date().toISOString().split('T')[0];
}

function fecharModal() {
    document.getElementById('modal-adicionar').style.display = 'none';
    document.getElementById('inp-aparelho').value = '';
    document.getElementById('inp-detalhe').value = '';
}

function salvarNovoItem() {
    let data = document.getElementById('inp-data').value;
    let func = document.getElementById('inp-func').value;
    let depto = document.getElementById('inp-depto').value;
    let aparelho = document.getElementById('inp-aparelho').value;
    let detalhe = document.getElementById('inp-detalhe').value || "--";
    let qtd = document.getElementById('inp-qtd').value;
    let obs = document.getElementById('inp-obs').value;

    if (aparelho === "" || func === "") {
        alert("Preencha o Funcionário e o Aparelho!");
        return;
    }

    let dataFormatada = data ? data.split('-').reverse().join('/') : "Hoje";

    const novaLinha = document.createElement('div');
    novaLinha.className = 'grid-row item pendente';
    
    novaLinha.innerHTML = `
        <div class="center" data-label="Sel"><input type="checkbox" class="check-item"></div>
        <div data-label="Data">${dataFormatada}</div>
        <div data-label="Funcionário">${func}</div>
        <div data-label="Depto.">${depto}</div>
        <div data-label="Aparelho" class="destaque-texto">${aparelho}</div>
        <div data-label="Detalhe">${detalhe}</div>
        <div data-label="OBS">${obs}</div>
        <div data-label="Qtd">${qtd}</div>
        <div data-label="Ações" class="acoes center">
            <button class="btn-icon icone-roxo" onclick="marcarComoEntregue(this)" title="Marcar Entregue">
                <span class="material-icons">check_circle</span>
            </button>
            <button class="btn-icon icone-excluir" onclick="deletarLinha(this)" title="Excluir">
                <span class="material-icons">delete</span>
            </button>
        </div>
    `;

    document.getElementById('lista-corpo').prepend(novaLinha);
    fecharModal();
    aplicarFiltro();
}

// --- 2. EXCLUSÃO E BAIXA ---
function deletarLinha(botao) {
    if(confirm("Deseja excluir este registro do sistema?")) {
        botao.closest('.grid-row').remove();
    }
}

function marcarComoEntregue(botao) {
    if(confirm("Confirmar a entrega deste item?")) {
        let linha = botao.closest('.grid-row');
        linha.classList.remove('pendente');
        linha.classList.add('entregue');
        
        let acoes = linha.querySelector('.acoes');
        acoes.innerHTML = `
            <span style="color: #5B2A86; font-weight: bold; font-size: 12px;">✅</span>
            <button class="btn-icon icone-excluir" onclick="deletarLinha(this)"><span class="material-icons">delete</span></button>
        `;
        linha.querySelector('input[type="checkbox"]').style.display = 'none';
        
        aplicarFiltro(); 
    }
}

// --- 3. SELEÇÃO EM MASSA ---
function selecionarTodos(chkMestre) {
    document.querySelectorAll('.check-item').forEach(c => c.checked = chkMestre.checked);
}

function entregarSelecionados() {
    const checks = document.querySelectorAll('.check-item:checked');
    if(checks.length > 0 && confirm(`Baixar ${checks.length} itens selecionados?`)) {
        checks.forEach(chk => {
            let btn = chk.closest('.grid-row').querySelector('.icone-roxo');
            if(btn) marcarComoEntregue(btn);
        });
    }
}

// --- 4. ABAS E MODO MOBILE ---
function filtrarAbas(tipo, botao) {
    abaAtual = tipo;
    document.querySelectorAll('.btn-aba').forEach(b => b.classList.remove('ativo'));
    botao.classList.add('ativo');
    aplicarFiltro();
}

function aplicarFiltro() {
    const linhas = document.querySelectorAll('.item');
    const isMobile = document.querySelector('.tabela-container').classList.contains('mobile-mode');

    linhas.forEach(linha => {
        if(linha.classList.contains(abaAtual)) {
            linha.style.display = isMobile ? 'flex' : 'grid';
        } else {
            linha.style.display = 'none';
        }
    });
}

function forcarMobile() {
    document.querySelector('.tabela-container').classList.toggle('mobile-mode');
    aplicarFiltro(); 
}

document.addEventListener('DOMContentLoaded', aplicarFiltro);