var total_pages = 1;
var filterText = "";

function filter_user_contacts(filterText, page = 1)
{
    // Get the filterText variable data
    if(filterText == '')
    {
        // Get Elements

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

        var filter_gender = document.querySelector("input[name=gender]:checked");
        var filter_gender_error = document.getElementById("filter_gender_error");

        var filter_mobile = document.getElementById("filter_mobnum");
        var filter_mobile_error = document.getElementById("filter_mobile_error");

        var filter_landline = document.getElementById("filter_landnum");
        var filter_landline_error = document.getElementById("filter_landline_error");

        var filter_address = document.getElementById("filter_address");
        var filter_address_error = document.getElementById("filter_address_error");

        var filter_relationship = document.getElementById("filter_relationship");
        var filter_relationship_error = document.getElementById("filter_relationship_error");

        // Validate and Sanitize data

        filter_firstname.value = filter_firstname.value.trim();

        if(filter_firstname.value.length > 100)
        {
            filter_firstname_error.innerHTML = "Firstname cannot be more than 100 characters!";
            return;
        }

        filter_middlename.value = filter_middlename.value.trim();

        if(filter_middlename.value.length > 100)
        {
            filter_middlename_error.innerHTML = "Middlename cannot be more than 100 characters!";
            return;
        }

        filter_lastname.value = filter_lastname.value.trim();

        if(filter_lastname.value.length > 100)
        {
            filter_lastname_error.innerHTML = "Lastname cannot be more than 100 characters!";
            return;
        }

        filter_nickname.value = filter_nickname.value.trim();

        if(filter_nickname.value.length > 100)
        {
            filter_nickname_error.innerHTML = "Nickname cannot be more than 100 characters!";
            return;
        }

        filter_gender.value = filter_gender.value.trim();

        if(filter_gender.value != 'male' && filter_gender.value != 'female')
        {
            filter_gender_error.innerHTML = "Gender must be either male or female!";
            return;
        }

        filter_mobile.value = filter_mobile.value.trim();

        if(filter_mobile.value.length != 0)
        {
            if(filter_mobile.value.length != 10)
            {
                filter_mobile_error.innerHTML = "Mobile Number must be of exact 10 digits!";
                return;
            }
        }

        filter_landline.value = filter_landline.value.trim();

        if(filter_landline.value.length != 0)
        {
            if(filter_landline.value.length != 8)
            {
                filter_landline_error.innerHTML = "Landline Number must be of exact 8 digits!";
                return;
            }
        }

        filter_address.value = filter_address.value.trim();

        if(filter_address.value.length > 500)
        {
            filter_address_error.innerHTML = "Address cannot be more than 500 characters!";
            return;
        }

        filter_relationship.value = filter_relationship.value.trim();

        if(filter_relationship.value.length > 100)
        {
            filter_relationship_error.innerHTML = "Relationship cannot be more than 100 characters!";
            return;
        }

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
    filterData += filterText + "&page=" + page;

    filterData = encodeURIComponent(filterData);

    console.log(filterData);

    // AJAX Request
    var xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        //console.log(this.responseText);
        var data = JSON.parse(this.responseText);
        if(data.status == 'error')
        {
            alert(data.data);
            filterActive = 0;
            filterText = "";
        }
        else if(data.status == 'success')
        {
            var resultdiv = document.getElementById("result");
            resultdiv.innerHTML = "";
            resultdiv.innerHTML = data.data;
            total_pages = data.total_pages;
            console.log(total_pages);
            filterActive = 1;
            console.log(filterActive);
        }
    }
    xhttp.open("POST", "filter_user_contact",true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send("filterData =" + filterData);
}


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

        filter_user_contacts(filterText, page_number.value);
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

        filter_user_contacts(filterText, page_number.value);
    });
});
