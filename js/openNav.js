function openNav() {
  var nav = document.getElementById("navigationResponsive");
  if (nav.className === "navig") {
    nav.className += " responsive";
  } else {
    nav.className = "navig";
  }
}