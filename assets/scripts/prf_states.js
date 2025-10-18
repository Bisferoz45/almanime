const edit_button = document.getElementById("edit");
const stats_button = document.getElementById("stats");
const stats_panel = document.getElementById("resAniSearch");
const edit_panel = document.getElementById("prfEdit");
const profile_text = document.getElementById("prfTittle");

edit_button.addEventListener("click", () => {
    stats_panel.style.display = "none";
    edit_button.style.display = "none";
    edit_panel.style.display = "flex";
    stats_button.style.display = "inline";
    profile_text.textContent = "Editar perfil";
});

stats_button.addEventListener("click", () =>{
    stats_panel.style.display = "flex";
    edit_button.style.display = "inline";
    edit_panel.style.display = "none";
    stats_button.style.display = "none";
    profile_text.textContent = "Anime stats";
});