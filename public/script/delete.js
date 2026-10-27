export function get_delete_contact_buttons(onDeleteSuccess)
{
    var delete_contact_button = Array.from(document.getElementsByClassName("delete_contact_btn"));
    // console.log(delete_contact_button);

    delete_contact_button.forEach(function(button) {
        button.addEventListener("click", function(event) {
            //console.log(event.srcElement.alt);

            var contact_id = Number(event.target.dataset.id);
            // console.log(contact_id);

            var xhttp = new XMLHttpRequest();
            var resultdiv = document.getElementById("result");

            xhttp.onload = function() {
                var data = JSON.parse(this.responseText);

                if(data.status == 'error')
                {
                    var newDivElement = document.createElement("div");
                    newDivElement.classList.add("error");
                    newDivElement.innerHTML = data.data;
                    resultdiv.insertBefore(newDivElement, table_with_contacts);
                }
                else if(data.status == 'success')
                {
                    onDeleteSuccess(1,1);
                }
            }
            xhttp.open("GET", "delete/" + contact_id, true);
            xhttp.send();
        });
    });
}
