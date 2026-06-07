/*
document.getElementById("closebutton").addEventListener("click", function() {
    document.getElementById("navbar").style.display = "none";
});
*/

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("closebutton").addEventListener("click", function() {
        document.getElementById("navbar").style.display = "none";
    });

    document.getElementById("hambergurmenu").addEventListener("click", function() {
        document.getElementById("navbar").style.display = "flex";
        document.getElementById("navbar").style.width = "70%";
    });
});
/*
window.addEventListener("resize", function() {
    document.getElementById("navbar").style.display = "flex";
});
*/