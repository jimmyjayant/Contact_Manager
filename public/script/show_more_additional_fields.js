export function get_show_more_additional_fields_buttons()
{
    var show_more_additional_fields_button = 
    Array.from(document.getElementsByClassName("show_more_additional_fields_btn"));
    console.log(show_more_additional_fields_button);

    show_more_additional_fields_button.forEach(function(button) {
        button.addEventListener("click", function(event) {

            var additional_fields_page = Number(event.target.dataset.additionalpage);
            console.log(additional_fields_page);

            var form_number = Number(event.target.dataset.form);
            console.log(form_number);

            var xhttp = new XMLHttpRequest();

            var additional_fields_table = document.getElementById("additional_fields_table");

            xhttp.onload = function() {
                var data = JSON.parse(this.responseText);
                //console.log(data.data);

                if(data.status == 'error')
                {
                    // code here
                }
                else if(data.status == 'success')
                {                    
                    var additional_fields_tbody = additional_fields_table.querySelector("table tbody");
                    var additional_fields_tbody_last_row = additional_fields_tbody.lastChild;
                    //console.log(additional_fields_tbody_last_row);

                    // Remove the last child of the additional fields table
                    additional_fields_tbody.removeChild(additional_fields_tbody_last_row);

                    // Append the data to the tbody element of the additional fields table
                    additional_fields_tbody.innerHTML += data.data;

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
