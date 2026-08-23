import { get_show_more_additional_fields_buttons } from "../script/show_more_additional_fields.js";

export function get_additional_fields_buttons()
{
    var additional_fields_button = Array.from(document.getElementsByClassName("additional_fields_btn"));
    console.log(additional_fields_button);

    additional_fields_button.forEach(function(button) {
        button.addEventListener("click", function(event) {
            //console.log(event.srcElement.alt);

            var additional_fields_page = 1;
            console.log(additional_fields_page);

            var form_number = Number(event.target.dataset.form);
            console.log(form_number);

            var xhttp = new XMLHttpRequest();

            var resultdiv = document.getElementById("result");

            var additional_fields_table = document.getElementById("additional_fields_table");

            xhttp.onload = function() {
                var data = JSON.parse(this.responseText);
                console.log(data);

                if(data.status == 'error')
                {
                    var newTableElement = document.createElement("table");
                    newTableElement.classList.add("additional_fields");
                    var newRowElement = document.createElement("tr");
                    var newDataElement = document.createElement("td");
                    newDataElement.classList.add("red_font");
                    newDataElement.innerHTML = data.data;
                    newRowElement.appendChild(newDataElement);
                    newTableElement.appendChild(newRowElement);
                }
                else if(data.status == 'success')
                {
                    additional_fields_table.classList.remove("hide");
                    
                    var additional_fields_tbody = additional_fields_table.querySelector("table tbody");
                    additional_fields_tbody.innerHTML = data.data;

                    var close_additional_fields_table_button = document.getElementById("close_additional_fields_table");
                    close_additional_fields_table_button.addEventListener("click", function() {
                        additional_fields_table.classList.add("hide");
                    });

                    get_show_more_additional_fields_buttons();
                }
            }

            xhttp.open("GET", 
        "get_additional_fields?additional_fields_page=" + additional_fields_page + 
        "&form_number=" + form_number
        , true);
            xhttp.send();
        });
    });
}
