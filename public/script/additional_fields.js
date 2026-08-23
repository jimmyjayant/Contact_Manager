import { get_show_more_additional_fields_buttons } from "../script/show_more_additional_fields.js";

export function get_additional_fields_buttons()
{
    var additional_fields_button = Array.from(document.getElementsByClassName("additional_fields_btn"));
    console.log(additional_fields_button);

    additional_fields_button.forEach(function(button) {
        button.addEventListener("click", function(event) {
            //console.log(event.srcElement.alt);
/*
            var main_page = Number(event.target.dataset.mainpage);
            console.log(main_page);
*/
            var additional_fields_page = 1/*Number(event.target.dataset.additionalpage)*/;
            console.log(additional_fields_page);

            //var additional_fields_row = Number(event.target.dataset.row);
            //console.log(additional_fields_row);

            var form_number = Number(event.target.dataset.form);
            console.log(form_number);

            var xhttp = new XMLHttpRequest();

            //var target_row = document.querySelector(`table tr:nth-child(${additional_fields_row})`);
            //console.log(target_row);

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

                    /*
                    var newDivElement = document.createElement("div");
                    newDivElement.classList.add("center");
                    var newSpanElement = document.createElement("span");
                    newSpanElement.classList.add("red_font");
                    newSpanElement.innerHTML = data.data;
                    newDivElement.appendChild(newSpanElement);
                    resultdiv.appendChild(newDivElement);
                    */
                }
                else if(data.status == 'success')
                {
                    
                    //resultdiv.innerHTML += data.data;

                    additional_fields_table.classList.remove("hide");
                    
                    var additional_fields_tbody = additional_fields_table.querySelector("table tbody");
                    additional_fields_tbody.innerHTML = data.data;

                    var close_additional_fields_table_button = document.getElementById("close_additional_fields_table");
                    close_additional_fields_table_button.addEventListener("click", function() {
                        additional_fields_table.classList.add("hide");
                    });

                    get_show_more_additional_fields_buttons();

                    /*
                   var newthElement = document.createElement("th");
                   newthElement.dataset.id = "hidden";
                   newthElement.innerHTML = "";
                   */
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
