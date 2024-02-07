const btnNav = document.querySelector(".btn-mobile-nav");
const header = document.getElementsByTagName("header").item(0);
console.log(header);
btnNav.addEventListener("click", function () {
  header.classList.toggle("nav-open");
});
