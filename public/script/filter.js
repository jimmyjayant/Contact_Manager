var total_pages = 1;
var filterData = "";

import { get_edit_contact_buttons } from "../script/edit.js";
import { get_delete_contact_buttons } from "../script/delete.js";
import { get_additional_fields_buttons } from "../script/additional_fields.js";

function filter_user_contacts(filterData, page = 1)
{
    filterData = JSON.parse(filterData);
    filterData.page = page;
    filterData = JSON.stringify(filterData);

    //console.log(filterData);

    // AJAX Request
    var xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        //console.log(this.responseText);
        var data = JSON.parse(this.responseText);
        var filter_contact_error_div = document.getElementById("filter_contact_error");
        var filter_contact_success_div = document.getElementById("filter_contact_success");
        var contact_data_div = document.getElementById("contact_data");
        var resultdiv = document.getElementById("result");
        var table_with_contacts = document.getElementById("table_with_contacts");

        if(data.status == 'error')
        {
            filter_contact_success_div.innerHTML = "";
            filter_contact_error_div.innerHTML = data.data;
            filterData = "";
            table_with_contacts.classList.add("hide");
        }
        else if(data.status == 'success')
        {
            filter_contact_error_div.innerHTML = "";
            filter_contact_success_div.innerHTML = "Data filtered successfully!";
            contact_data_div.classList.remove("hide");

            table_with_contacts.classList.remove("hide");
            
            var tbody = table_with_contacts.querySelector("table tbody");
            tbody.innerHTML = data.data;

            total_pages = Math.ceil(data.total_pages / 10);
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
    xhttp.open("POST", "filter_user_contact",true);
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.send(filterData);
}

window.addEventListener("DOMContentLoaded", function() {
    var filter_form = document.getElementById("filter_form");
    filter_form.addEventListener("submit", function(e) {
        // Prevent Normal form submission
        e.preventDefault();

        // Using FormData API to collect all form values
        const formData = new FormData(filter_form);

        // Convert form data to a javascript object
        const filter_data = Object.fromEntries(formData.entries());

        //console.log(filter_data);

        filterData = JSON.stringify(filter_data);

        filter_user_contacts(filterData, page_number.value);
    });  
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

        filter_user_contacts(filterData, page_number.value);
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

        filter_user_contacts(filterData, page_number.value);
    });
});
