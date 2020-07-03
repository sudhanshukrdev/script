document.getElementById('select').onchange = function() {
  window.location = "/test/developer-test/index.php?search=" + this.value;
};