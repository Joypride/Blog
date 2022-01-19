const toggler = document.getElementById("menu-toggler");
const sublistToggler = document.getElementById("menu-list");

const sublistToggle = (e) => {
  document.getElementsByClassName("submenu-container")[0].classList.toggle("open");
};
sublistToggler.addEventListener("click", (e) => sublistToggle(e));
toggler.addEventListener("click", () => toggler.classList.toggle("open"));