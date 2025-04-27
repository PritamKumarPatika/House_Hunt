'use strict';

document.addEventListener("DOMContentLoaded", function () {

  const elemToggleFunc = function (elem) {
    elem.classList.toggle("active");
  };

  const navbar = document.querySelector("[data-navbar]");
  const overlay = document.querySelector("[data-overlay]");
  const navCloseBtn = document.querySelector("[data-nav-close-btn]");
  const navOpenBtn = document.querySelector("[data-nav-open-btn]");
  const navbarLinks = document.querySelectorAll("[data-nav-link]");

  const navElemArr = [overlay, navCloseBtn, navOpenBtn];

  navbarLinks.forEach(link => navElemArr.push(link));

  navElemArr.forEach(elem => {
    elem.addEventListener("click", () => {
      elemToggleFunc(navbar);
      elemToggleFunc(overlay);
    });
  });

  const header = document.querySelector("[data-header]");

  window.addEventListener("scroll", () => {
    if (window.scrollY >= 400) {
      header.classList.add("active");
    } else {
      header.classList.remove("active");
    }
  });

});

function ListingPage(){
  window.location.href = 'listing.php','_blank'
}


