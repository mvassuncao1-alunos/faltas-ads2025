let abaAtual = 'pendente';

// --- Modal ---
function abrirModal() {
    document.getElementById('modal').style.display = 'flex';
    document.getElementById('m-data').value = new Date().toISOString().split('T')[0];
}
function fecharModal() { document.getElementById('modal').style.display = 'none'; }

// --- Salvar Novo Item ---
function salvar() {
    let data = document.getElementById('m-data').value;
    let func = document.getElementById('m-func').value;
    let depto = document.getElementById('m-depto').value;
    let aparelho = document.getElementById('m-aparelho').value;
    let detalhe = document.getElementById('m-detalhe').value || "--";
    let qtd = document.getElementById('m-qtd').value;
    let obs = document.getElementById('m-obs').value;

    if (!func || !aparelho) return alert("Preencha Funcionario e Aparelho!");

    let dataBR = data ? data.split('-').reverse().join('/') : "Hoje";

    let div = document.createElement('div');
    div.className = 'linha item pendente';
    div.innerHTML = `
        <div class="centro" data-label="Sel"><input type="checkbox" class="chk-item"></div>
        <div data-label="Data">${dataBR}</div>
        <div data-label="Func.">${func}</div>
        <div data-label="Depto">${depto}</div>
        <div data-label="Aparelho" class="negrito">${aparelho}</div>
        <div data-label="Detalhe">${detalhe}</div>
        <div data-label="OBS">${obs}</div>
        <div data-label="Qtd">${qtd}</div>
        <div class="acoes centro" data-label="Ações">
            <button class="icone check" onclick="marcarEntregue(this)"><span class="material-icons">check</span></button>
            <button class="icone del" onclick="excluirLinha(this)"><span class="material-icons">delete</span></button>
        </div>
    `;

    document.getElementById('corpo-tabela').prepend(div);
    fecharModal();
    aplicarFiltro();
}

// --- Ações ---
function excluirLinha(btn) {
    if(confirm("Excluir?")) btn.closest('.item').remove();
}

function marcarEntregue(btn) {
    if(confirm("Entregar?")) {
        let linha = btn.closest('.item');
        linha.classList.remove('pendente');
        linha.classList.add('entregue');
        linha.querySelector('.acoes').innerHTML = `<span class="texto-ok">✅</span><button class="icone del" onclick="excluirLinha(this)"><span class="material-icons">delete</span></button>`;
        linha.querySelector('input[type="checkbox"]').style.display = 'none';
        aplicarFiltro();
    }
}

// --- Seleção ---
function selecionarTodos(chkBox) {
    document.querySelectorAll('.chk-item').forEach(c => c.checked = chkBox.checked);
}
function entregarSelecionados() {
    document.querySelectorAll('.chk-item:checked').forEach(c => {
        let btn = c.closest('.item').querySelector('.check');
        if(btn) marcarEntregue(btn);
    });
}

// --- Filtros e Mobile ---
function filtrar(tipo, btnClicado) {
    abaAtual = tipo;
    document.querySelectorAll('.aba').forEach(b => b.classList.remove('ativo'));
    btnClicado.classList.add('ativo');
    aplicarFiltro();
}

function aplicarFiltro() {
    const isMobile = document.querySelector('.tabela-box').classList.contains('modo-celular');
    document.querySelectorAll('.item').forEach(linha => {
        if(linha.classList.contains(abaAtual)) {
            linha.style.display = isMobile ? 'flex' : 'grid';
        } else {
            linha.style.display = 'none';
        }
    });
}

function forcarMobile() {
    document.querySelector('.tabela-box').classList.toggle('modo-celular');
    aplicarFiltro();
}

// Inicia
document.addEventListener('DOMContentLoaded', aplicarFiltro);