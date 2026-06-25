// Session storage
//var display_add_contact_div = 0;
/*
if(sessionStorage.getItem("show"))
{
    display_add_contact_div = sessionStorage.getItem("add_div_active");
}
else
{
    sessionStorage.setItem("add_div_active", "0");
}
*/

var counter = 1;
var total_pages = 1;

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

window.addEventListener("DOMContentLoaded", function() {
    get_user_contacts(1);
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

    var cross_button = document.getElementById("cross_button");

    cross_button.addEventListener("click", function() {
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

        newCol25Div.appendChild(newInputElement);

        console.log(newInputElement);
        var newCol75Div = document.createElement("div");
        newCol75Div.classList.add("col75");

        var newInputElement1 = document.createElement("input");
        newInputElement1.type = "text";
        newInputElement1.name = "customInputElement" + (counter + 1);
        newInputElement1.maxLength = "500";
        newInputElement1.placeholder = "Enter field value here";

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
