export function get_delete_contact_buttons()
{
    var delete_contact_button = Array.from(document.getElementsByClassName("delete_contact_btn"));
    console.log(delete_contact_button);

    delete_contact_button.forEach(function(button) {
        button.addEventListener("click", function(event) {
            //console.log(event.srcElement.alt);

            var contact_id = Number(event.target.dataset.id);
            console.log(contact_id);

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
                    window.location.reload();
                }
            }
            xhttp.open("GET", "delete_user_contact?id=" + contact_id, true);
            xhttp.send();
        });
    });
}
