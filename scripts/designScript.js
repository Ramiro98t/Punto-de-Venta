$(document).ready(function () {
  // GENERALES
  /**
   * Metodos Menu hamburguesa
   */
  $(".navbar-burger").click(function () {
    // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
    $(".navbar-burger").toggleClass("is-active");
    $(".navbar-menu").toggleClass("is-active");
  });

  /**
   * Metodos para modal
   */
  // Abrir Modal
  $(".modal-click").on("click", function () {
    $(".modal").addClass("is-active");
  });

  // Cerrar Modal
  $(".modal-background, .exit-modal").on("click", function () {
    $(".modal").removeClass("is-active");
  });
  
});
