var total_pages = 1;

import { get_edit_contact_buttons } from "../script/edit.js";
import { get_delete_contact_buttons } from "../script/delete.js";
import { get_additional_fields_buttons } from "../script/additional_fields.js";

function get_user_contacts(pageNumber = 1)
{
    var xhttp = new XMLHttpRequest();
    var resultdiv = document.getElementById("result");
    var table_with_contacts = document.getElementById("table_with_contacts");

    xhttp.onload = function() {
        var data = JSON.parse(this.responseText);

        if(data.status == 'error')
        {
            table_with_contacts.classList.add("hide");
            
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
            table_with_contacts.classList.remove("hide");

            var tbody = table_with_contacts.querySelector("table tbody");
            tbody.innerHTML = data.data;

            total_pages = Math.ceil(data.total_records / 10);
            //console.log(total_pages);

            if(total_pages > 1)
            {
                var paginationDiv = document.getElementById("pagination");
                paginationDiv.style.display = "flex";
            }

            get_delete_contact_buttons();
            get_edit_contact_buttons();
            get_additional_fields_buttons();
        }
    }
    xhttp.open("GET", "get_user_contacts?page=" + pageNumber, true);
    xhttp.send();
}

window.addEventListener("DOMContentLoaded", function() {
    get_user_contacts(1);
});

window.addEventListener("DOMContentLoaded", function() {
    var previous_page_button = document.getElementById("previous_page");
    var next_page_button = document.getElementById("next_page");

    var page_number = document.getElementById("page_number");

    previous_page_button.addEventListener("click", function() {
        if(Math.floor(Number(page_number.value)) <= 1)
        {
            page_number.value = 1;
        }
        else
        {
            page_number.value = Math.floor(Number(page_number.value)) - 1;
        }

        get_user_contacts(page_number.value);
    });

    next_page_button.addEventListener("click", function() {
        if(Math.floor(Number(page_number.value)) >= total_pages)
        {
            page_number.value = total_pages;
        }
        else
        {
            page_number.value = Math.floor(Number(page_number.value)) + 1;
        }

        get_user_contacts(page_number.value);
    });
});
