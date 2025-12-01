// assets/cep.js
async function buscarCEPCliente() {
  const cepEl = document.getElementById('cep');
  if (!cepEl) return;
  const cep = cepEl.value.replace(/\D/g,'').slice(0,8);
  cepEl.value = cep;
  if (cep.length !== 8) return;
  try {
    const resp = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
    const data = await resp.json();
    if (data.erro) { alert('CEP não encontrado'); return; }
    document.getElementById('rua').value = data.logradouro || '';
    document.getElementById('bairro').value = data.bairro || '';
    document.getElementById('cidade').value = data.localidade || '';
    document.getElementById('estado').value = data.uf || '';
  } catch(e){ console.error(e); alert('Erro consultar CEP'); }
}
document.addEventListener('DOMContentLoaded', function(){
  const cep = document.getElementById('cep');
  if (cep) {
    cep.addEventListener('blur', buscarCEPCliente);
    cep.addEventListener('input', e=> e.target.value = e.target.value.replace(/\D/g,'').slice(0,8));
  }
});
