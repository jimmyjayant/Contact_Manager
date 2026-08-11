var searchText = "";
var total_pages = 1;

import { get_edit_contact_buttons } from "../script/edit.js";
import {get_delete_contact_buttons} from "../script/delete.js";

function search_user_contacts(searchText, page = 1)
{
    searchText = "firstname=" + searchText + "&page=" + page;
    //searchText = encodeURIComponent(searchText);
    console.log(searchText);

    var xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        //console.log(this.responseText);
        var data = JSON.parse(this.responseText);
        var search_contact_error_div = document.getElementById("search_contact_error");
        var contact_data_div = document.getElementById("contact_data");

        if(data.status == 'error')
        {
            contact_data_div.classList.add("hide");
            search_contact_error_div.innerHTML = data.data;
        }
        else if(data.status == 'success')
        {
            contact_data_div.classList.remove("hide");
            search_contact_error_div.innerHTML = "";

            var resultdiv = document.getElementById("result");
            resultdiv.innerHTML = "";
            resultdiv.innerHTML = data.data;
            total_pages = Math.ceil(data.total_records / 10);

            get_delete_contact_buttons();
            get_edit_contact_buttons();
        }
    }
    xhttp.open("POST", "search_user_contacts", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send(searchText);
}

window.addEventListener("DOMContentLoaded", function() {
    // JS Code related to searching of input firstname in input field
    var searchButton = document.getElementById("search");
    var search_contact_error_div = document.getElementById("search_contact_error");
    var searchInputField = document.getElementById("searchtext");

    searchButton.addEventListener("click", function() {
        searchText = searchInputField.value.trim();
        //console.log(searchText);

        if(searchText == '')
        {
            search_contact_error_div.innerHTML = "Please enter firstname!";
        }
        else if(searchText.length > 100)
        {
            search_contact_error_div.innerHTML = "Firstname cannot be more than 100 characters!";
        }
        else
        {
            search_user_contacts(searchText, 1);
        }
    });

    // JS Code related to pagination of search results
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

        search_user_contacts(searchText, page_number.value);
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

        search_user_contacts(searchText, page_number.value);
    });

    // JS code related to showing and hiding of X button in input search field
    var clearSearchButton = document.getElementById("clearSearch");

    searchInputField.addEventListener("change", function() {
        if(searchInputField.value.trim() !== '')
        {
            clearSearchButton.classList.remove("hide");
        }
        else
        {
            clearSearchButton.classList.add("hide");
        }
    });

    // JS code related to X button in input search field
    clearSearchButton.addEventListener("click", function() {
        searchInputField.value = "";
        searchInputField.focus();
    });
});
