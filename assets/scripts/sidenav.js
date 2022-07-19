///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////// BURGER AND SIDENAV

const sidenav = document.getElementById("mySidenav");
const openBtn = document.getElementById("openBtn");
const closeBtn = document.getElementById("closeBtn");

openBtn.onclick = openNav;
closeBtn.onclick = closeNav;

/* Set the width of the side navigation to 250px */
function openNav() {
    sidenav.classList.toggle("active");
}

/* Set the width of the side navigation to 0 */
function closeNav() {
    sidenav.classList.toggle("active");
}
