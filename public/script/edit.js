function get_edit_contact_buttons()
{
    var edit_contact_button = Array.from(document.getElementsByClassName("edit_contact_btn"));
    console.log(edit_contact_button);

    edit_contact_button.forEach(function(button) {
        button.addEventListener("click", function(event) {
            //console.log(event.srcElement.alt);

            var edit_id = Number(event.target.dataset.id);
            console.log(edit_id);

            var xhttp = new XMLHttpRequest();
            var resultdiv = document.getElementById("result");

            xhttp.onload = function() {
                var data = JSON.parse(this.responseText);

                if(data.status == 'error')
                {
                    var newDivElement = document.createElement("div");
                    newDivElement.classList.add("center");
                    var newSpanElement = document.createElement("span");
                    newSpanElement.classList.add("red_font");
                    newSpanElement.innerHTML = data.data;
                    newDivElement.appendChild(newSpanElement);
                    resultdiv.appendChild(newDivElement);
                }
                else if(data.status == 'success')
                {
                    var introDiv = document.getElementsByClassName("intro")[0];
                    var div = document.createElement("div");
                    div.innerHTML = data.data;
                    introDiv.appendChild(div);
                }
            }
            xhttp.open("GET", "get_particular_user_contact_data?id=" + edit_id, true);
            xhttp.send();
        });
    });
}
