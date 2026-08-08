var total_pages = 1;
var filterData = "";

import { get_edit_contact_buttons } from "../script/edit.js";
import {get_delete_contact_buttons} from "../script/delete.js";

function filter_user_contacts(filterData, page = 1)
{
    /*
    var filter_contact_error = document.getElementById("filter_contact_error");
    var filter_contact_success = document.getElementById("filter_contact_success");

    var filter_firstname = document.getElementById("filter_firstname");
    var filter_firstname_error = document.getElementById("filter_firstname_error");

    var filter_middlename = document.getElementById("filter_middlename");
    var filter_middlename_error = document.getElementById("filter_middlename_error");

    var filter_lastname = document.getElementById("filter_lastname");
    var filter_lastname_error = document.getElementById("filter_lastname_error");

    var filter_nickname = document.getElementById("filter_nickname");
    var filter_nickname_error = document.getElementById("filter_nickname_error");

    var filter_gender = document.querySelector("input[name=filter_gender]:checked");
    var filter_gender_error = document.getElementById("filter_gender_error");

    var filter_mobnum = document.getElementById("filter_mobnum");
    var filter_mobnum_error = document.getElementById("filter_mobnum_error");

    var filter_landnum = document.getElementById("filter_landnum");
    var filter_landnum_error = document.getElementById("filter_landnum_error");

    var filter_address = document.getElementById("filter_address");
    var filter_address_error = document.getElementById("filter_address_error");

    var filter_relationship = document.getElementById("filter_relationship");
    var filter_relationship_error = document.getElementById("filter_relationship_error");

    // Get the filterText variable data
    if(filterText == '')
    {
        filterText = "filter_firstname=" + filter_firstname.value + 
                     "&filter_middlename=" + filter_middlename.value + 
                     "&filter_lastname=" + filter_lastname.value + 
                     "&filter_nickname=" + filter_nickname.value + 
                     "&filter_gender=" + filter_gender.value + 
                     "&filter_mobile=" + filter_mobile.value + 
                     "&filter_landline=" + filter_landline.value + 
                     "&filter_address=" + filter_address.value + 
                     "&filter_relationship=" + filter_relationship.value;
        
    }
    
    console.log(filterText);
    var filterData = "";
    filterData += filterText;
    */
    //filterData = encodeURIComponent(filterData);

    //page = JSON.stringify(page);
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

        if(data.status == 'error')
        {
            filter_contact_error_div.innerHTML = data.data;
            filterData = "";
        }
        else if(data.status == 'success')
        {
            filter_contact_error_div.innerHTML = "";
            filter_contact_success_div.innerHTML = data.data;
            contact_data_div.classList.remove("hide");

            resultdiv.innerHTML = "";
            resultdiv.innerHTML = data.data;
            total_pages = data.total_pages;
            //console.log(total_pages);

            get_delete_contact_buttons();
            get_edit_contact_buttons();
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
