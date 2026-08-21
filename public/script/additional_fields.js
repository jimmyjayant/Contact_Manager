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
                    var resultdiv = document.getElementById("result");
                    resultdiv.innerHTML += data.data;
                    
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
