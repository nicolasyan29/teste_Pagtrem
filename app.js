// assets/app.js - small helpers
document.addEventListener('DOMContentLoaded', function(){
  const s = document.getElementById('searchInput');
  if (s) {
    let t;
    s.addEventListener('input', ()=> {
      clearTimeout(t);
      t = setTimeout(()=> {
        const q = encodeURIComponent(s.value.trim());
        location.href = `index.php?q=${q}`;
      }, 300);
    });
  }
});
