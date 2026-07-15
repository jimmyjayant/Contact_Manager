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
