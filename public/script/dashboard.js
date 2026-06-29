
var counter = 1;
var total_pages = 1;
var searchActive = 0;
var filterActive = 0;
var searchText = "";
var filterText = "";

function get_user_contacts(pageNumber = 1)
{
    var xhttp = new XMLHttpRequest();
    var resultdiv = document.getElementById("result");
    xhttp.onload = function() {
        var data = JSON.parse(this.responseText);
        if(data.status == 'error')
        {
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
            resultdiv.innerHTML = data.data;
            total_pages = Math.ceil(data.total_records / 10);
        }
    }
    xhttp.open("GET", "get_user_contacts?page=" + pageNumber, true);
    xhttp.send();
}


function search_user_contacts(searchText, page = 1)
{
    var xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        //console.log(this.responseText);
        var data = JSON.parse(this.responseText);
        if(data.status == 'error')
        {
            alert(data.data);
            searchActive = 0;
        }
        else if(data.status == 'success')
        {
            var resultdiv = document.getElementById("result");
            resultdiv.innerHTML = "";
            resultdiv.innerHTML = data.data;
            total_pages = Math.ceil(data.total_records / 10);
            searchActive = 1;
            console.log(searchActive);
        }
    }
    xhttp.open("GET", 
                    "search_user_contacts?searchText=" + searchText + "&page=" + page, 
                    true);
    xhttp.send();
}

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
    get_user_contacts(1);
});

window.addEventListener("DOMContentLoaded", function() {
    var searchButton = document.getElementById("search");
    searchButton.addEventListener("click", function() {
        searchText = document.getElementById("searchtext");

        searchText = searchText.value.trim();
        console.log(searchText);
        if(searchText == '')
        {
            alert("Please enter firstname!");
        }
        else if(searchText.length > 100)
        {
            alert("Firstname cannot be more than 100 characters!");
        }
        else
        {
            search_user_contacts(searchText, 1);
        }
    });
});

window.addEventListener("DOMContentLoaded", function() {
    var add_contact_button = document.getElementById("add");
    var add_contact_div = document.getElementById("add_contact");
    //console.log(display_add_contact_div);
    
    if(display_add_contact_div == 0)
    {
        add_contact_div.classList.add("hide");
    }
    else
    {
        add_contact_div.classList.remove("hide");
    }
    
    add_contact_button.addEventListener("click", function() {
        add_contact_div.classList.remove("hide");       
    });

    var add_cross_button = document.getElementById("add_cross_button");

    add_cross_button.addEventListener("click", function() {
        add_contact_div.classList.add("hide");
    });

    var add_custom_fields_button = document.getElementById("add_custom_fields");

    add_custom_fields_button.addEventListener("click", function() {
        var newRowDiv = document.createElement("div");
        newRowDiv.classList.add("row");
        var newCol25Div = document.createElement("div");
        newCol25Div.classList.add("col25");

        var newInputElement = document.createElement("input");
        newInputElement.type = "text";
        newInputElement.name = "customInputElement" + counter;
        newInputElement.maxLength = "100";
        newInputElement.placeholder = "Enter field name here";
        newInputElement.required = "true";

        newCol25Div.appendChild(newInputElement);

        console.log(newInputElement);
        var newCol75Div = document.createElement("div");
        newCol75Div.classList.add("col75");

        var newInputElement1 = document.createElement("input");
        newInputElement1.type = "text";
        newInputElement1.name = "customInputElement" + (counter + 1);
        newInputElement1.maxLength = "500";
        newInputElement1.placeholder = "Enter field value here";
        newInputElement1.required = "true";

        newCol75Div.appendChild(newInputElement1);

        newRowDiv.appendChild(newCol25Div);
        newRowDiv.appendChild(newCol75Div);

        var arr = document.querySelector("#add_custom_fields_div");
        //console.log(arr);

        var parentDiv = document.querySelector("#add_contact form");
        //console.log(parentDiv);

        var custom_fields_present = document.getElementById("custom_fields_present");
        custom_fields_present.value = "1";

        var custom_fields_number = document.getElementById("custom_fields_number");
        custom_fields_number.value++;

        parentDiv.insertBefore(newRowDiv, arr);
        counter = counter + 2;
        //console.log(counter);
    });
});

window.addEventListener("DOMContentLoaded", function() {
    var filter_contact_button = document.getElementById("filter");
    var filter_contact_div = document.getElementById("filter_contact");

    if(display_filter_contact_div == 0)
    {
        filter_contact_div.classList.add("hide");
    }
    else
    {
        filter_contact_div.classList.remove("hide");
    }
    
    filter_contact_button.addEventListener("click", function() {
        filter_contact_div.classList.remove("hide");       
    });

    var filter_cross_button = document.getElementById("filter_cross_button");

    filter_cross_button.addEventListener("click", function() {
        filter_contact_div.classList.add("hide");
    });

    var submit_filter_data_button = document.getElementById("submit_filter_data_button");

    submit_filter_data_button.addEventListener("click", function(e) {
        e.preventDefault();
        filter_user_contacts(filterText, 1);
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

        if(searchActive == 1)
        {
            search_user_contacts(searchText, page_number.value);
        }
        else if(filterActive == 1)
        {
            filter_user_contacts(filterText, page_number.value);
        }
        else
        {
            get_user_contacts(page_number.value);
        }
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

        if(searchActive == 1)
        {
            search_user_contacts(searchText, page_number.value);
        }
        else if(filterActive == 1)
        {
            filter_user_contacts(filterText, page_number.value);
        }
        else
        {
            get_user_contacts(page_number.value);
        }
    });
});
