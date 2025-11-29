// assets/cep.js - busca ViaCEP no cliente e preenche campos
async function buscarCEP() {
  const cepEl = document.getElementById('cep');
  if (!cepEl) return;
  const cep = cepEl.value.replace(/\D/g,'').slice(0,8);
  cepEl.value = cep;
  if (cep.length !== 8) {
    preencherEndereco({logradouro:'', bairro:'', localidade:'', uf:''});
    return;
  }
  try {
    const resp = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
    const data = await resp.json();
    if (data.erro) {
      alert('CEP não encontrado');
      preencherEndereco({logradouro:'', bairro:'', localidade:'', uf:''});
      return;
    }
    preencherEndereco(data);
  } catch (e) {
    console.error(e);
    alert('Erro ao consultar CEP');
  }
}

function preencherEndereco(d){
  const map = {rua: d.logradouro || '', bairro: d.bairro || '', cidade: d.localidade || '', estado: d.uf || ''};
  Object.keys(map).forEach(k=>{
    const el = document.getElementById(k);
    if (el) el.value = map[k];
  });
}

document.addEventListener('DOMContentLoaded', function(){
  const cep = document.getElementById('cep');
  if (cep) {
    cep.addEventListener('input', (e)=> e.target.value = e.target.value.replace(/\D/g,'').slice(0,8));
    cep.addEventListener('blur', buscarCEP);
  }
});
