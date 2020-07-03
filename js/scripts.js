document.getElementById('select').onchange = function() {
  window.location = "index.php?search=" + this.value;
};