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

        var errorElement = 
        Array.from(document.getElementById("filter_contact").getElementsByClassName("error"));

        // console.log(errorElement);

        errorElement.forEach((element) => {
            element.innerHTML = "";
        });

        var successElement = 
        Array.from(document.getElementById("filter_contact").getElementsByClassName("success"));

        // console.log(successElement);

        successElement.forEach((element) => {
            element.innerHTML = "";
        });

        var contact_data_div = document.getElementById("contact_data");
        var resultdiv = document.getElementById("result");
        var table_with_contacts = document.getElementById("table_with_contacts");

        if(data.status == 'error')
        {
            filter_contact_error_div.innerHTML = data.data;
            table_with_contacts.classList.add("hide");
        }
        else if(data.status == 'validationError')
        {
            filter_contact_error_div.innerHTML = "Please check respective validation error below";
            table_with_contacts.classList.add("hide");

            if(data.data.firstname)
            {
                var firstname_error_div = document.getElementById("firstname_error");
                for(const x of data.data.firstname)
                {
                    firstname_error_div.innerHTML += x + "<br>";
                }
            }

            if(data.data.middlename)
            {
                var middlename_error_div = document.getElementById("middlename_error");
                for(const x of data.data.middlename)
                {
                    middlename_error_div.innerHTML += x + "<br>";
                }
            }

            if(data.data.lastname)
            {
                var lastname_error_div = document.getElementById("lastname_error");
                for(const x of data.data.lastname)
                {
                    lastname_error_div.innerHTML += x + "<br>";
                }
            }

            if(data.data.nickname)
            {
                var nickname_error_div = document.getElementById("nickname_error");
                for(const x of data.data.nickname)
                {
                    nickname_error_div.innerHTML += x + "<br>";
                }
            }

            if(data.data.gender)
            {
                var gender_error_div = document.getElementById("gender_error");
                for(const x of data.data.gender)
                {
                    gender_error_div.innerHTML += x + "<br>";
                }
            }

            if(data.data.mobile)
            {
                var mobile_error_div = document.getElementById("mobile_error");
                for(const x of data.data.mobile)
                {
                    mobile_error_div.innerHTML += x + "<br>";
                }
            }

            if(data.data.landline)
            {
                var landline_error_div = document.getElementById("landline_error");
                for(const x of data.data.landline)
                {
                    landline_error_div.innerHTML += x + "<br>";
                }
            }

            if(data.data.address)
            {
                var address_error_div = document.getElementById("address_error");
                for(const x of data.data.address)
                {
                    address_error_div.innerHTML += x + "<br>";
                }
            }

            if(data.data.relationship)
            {
                var relationship_error_div = document.getElementById("relationship_error");
                for(const x of data.data.relationship)
                {
                    relationship_error_div.innerHTML += x + "<br>";
                }
            }
        }
        else if(data.status == 'success')
        {          
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

        filterData = "";
    }
    xhttp.open("POST", "filter",true);
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
