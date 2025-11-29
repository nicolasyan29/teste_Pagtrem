// assets/app.js - UI helpers (search + simple notifications)
document.addEventListener('DOMContentLoaded', function(){
  const search = document.getElementById('searchInput');
  if (search){
    let t;
    search.addEventListener('input', function(){
      clearTimeout(t);
      t = setTimeout(()=> {
        const q = encodeURIComponent(search.value.trim());
        location.href = `index.php?q=${q}`;
      }, 350);
    });
  }
});
