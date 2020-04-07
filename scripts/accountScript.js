$(document).ready(function () {
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
  // Cerrar Modal
  $(".modal-background, .exit-modal").on("click", function () {
    $(".modal").removeClass("is-active");
  });

  // Abrir modal
  $(".about-us-btn").on("click", function () {
    $(".modal").addClass("is-active");
  });
});
