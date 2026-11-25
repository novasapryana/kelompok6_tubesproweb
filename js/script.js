

var tema = localStorage.getItem("tema");
if (tema == null) {
  tema = "light";
}

document.documentElement.setAttribute("data-tema", tema);
document.documentElement.setAttribute("data-bs-theme", tema);

var tombolTema = document.querySelectorAll("[data-pilih-tema]");

for (var i = 0; i < tombolTema.length; i++) {
  if (tombolTema[i].dataset.pilihTema == tema) {
    tombolTema[i].classList.add("btn-hijau");
    tombolTema[i].classList.remove("btn-outline-success");
  }

  tombolTema[i].addEventListener("click", function() {
    localStorage.setItem("tema", this.dataset.pilihTema);
    location.reload();
  });
}
