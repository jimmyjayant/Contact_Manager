
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
    // Validate and Sanitize data









    // AJAX Request
    var xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        //console.log(this.responseText);
        var data = JSON.parse(this.responseText);
        if(data.status == 'error')
        {
            alert(data.data);
            filterActive = 0;
        }
        else if(data.status == 'success')
        {
            var resultdiv = document.getElementById("result");
            resultdiv.innerHTML = "";
            resultdiv.innerHTML = data.data;
            total_pages = Math.ceil(data.total_records / 10);
            filterActive = 1;
            console.log(filterActive);
        }
    }
    xhttp.open("GET", 
                    "filter_user_contacts?filterText=" + filterText + "&page=" + page, 
                    true);
    xhttp.send();
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
        else
        {
            get_user_contacts(page_number.value);
        }
    });
});
