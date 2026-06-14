window.addEventListener("DOMContentLoaded", function() {
    var xhttp = new XMLHttpRequest();
    var resultdiv = document.getElementById("result");
    xhttp.onload = function() {
        var newDivElement = document.createElement("div");
        newDivElement.classList.add("center");
        var newSpanElement = document.createElement("span");
        newSpanElement.classList.add("red_font");
        newSpanElement.innerHTML = JSON.parse(this.responseText);
        newDivElement.appendChild(newSpanElement);
        resultdiv.appendChild(newDivElement);
    }
    xhttp.open("GET", "get_user_contacts", true);
    xhttp.send();    
});
