const menu_button = document.getElementById("img_prf");
const menu_panel = document.getElementById("prf_menu");

menu_button.addEventListener("click", () => {
    menu_panel.style.visibility = (menu_panel.style.visibility === "hidden") ? "visible" : "hidden";
});