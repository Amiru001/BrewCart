// Select the navbar (header) and the "About Us" section
const navbar = document.querySelector("header");
const aboutSection = document.querySelector("#about");

// Change navbar background based on scroll position
window.onscroll = function () {
  // Check if the page has scrolled to the "About Us" section
  if (window.scrollY >= aboutSection.offsetTop) {
    navbar.style.backgroundColor = "#220B03"; // Set navbar background to brown
  } else {
    navbar.style.backgroundColor = "transparent"; // Reset to transparent
  }
};

// Get all navigation links
const navLinks = document.querySelectorAll(".navbar li a");

// Add an event listener to update the active link
window.addEventListener("scroll", () => {
  navLinks.forEach((link) => {
    // Get the section corresponding to the link
    const section = document.querySelector(link.getAttribute("href"));
    const scrollPosition = window.scrollY;

    // Check if the section is currently in view
    if (
      scrollPosition >= section.offsetTop - 90 && // Section is near top
      scrollPosition < section.offsetTop + section.offsetHeight // Section is not scrolled past
    ) {
      // Add the "active" class to the current link
      navLinks.forEach((link) => link.classList.remove("active"));
      link.classList.add("active");
    }
  });
});

let navbarr = document.querySelector('.navbar');
document.querySelector('.icon1').onclick = () =>{
  navbarr.classList.toggle('active')
}
