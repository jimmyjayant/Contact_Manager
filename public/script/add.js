// This add.js script is used by add.php and edit.php webpage


import { get_custom_elements } from "../script/dropCustomElement.js";

var counter = 1;

window.addEventListener("DOMContentLoaded", function() {
    // var add_contact_div = document.getElementById("add_contact");

    var add_custom_fields_button = document.getElementById("add_custom_fields");

    add_custom_fields_button.addEventListener("click", function() {

        let argument = '';
        if(window.location.href.includes("add"))
        {
            argument = '#addForm';
        }
        else
        {
            argument = '#editForm';
        }

        // Get all the input type hidden field having name='fieldNameX' where X = natural number
        var hiddenInputFields = 
        Array.from(document.querySelectorAll(`${argument} input[type=hidden]`));

        // console.log(hiddenInputFields);

        hiddenInputFields.forEach((field) => {
            if(field.name.includes('fieldName'))
            {
                let nameOfField = field.name;
                let numberOfField = nameOfField.replace('fieldName', '');
                counter = numberOfField;
                counter++;
            }
        });

        var newRowDiv = document.createElement("div");
        newRowDiv.classList.add("row");

        var newDropCustomElement = document.createElement("div");
        newDropCustomElement.classList.add("dropCustomElement");

        var newSpanElement = document.createElement("span");
        newSpanElement.title = "Remove the custom field";
        newSpanElement.innerHTML = "X";

        newDropCustomElement.appendChild(newSpanElement);

        newRowDiv.appendChild(newDropCustomElement);

        var newCol25Div = document.createElement("div");
        newCol25Div.classList.add("col25");

        var newHiddenInputElement = document.createElement("input");
        newHiddenInputElement.type = "hidden";
        newHiddenInputElement.name = "fieldName" + counter;

        var newInputElement = document.createElement("input");
        newInputElement.type = "text";
        newInputElement.name = `customInputElement${(counter*2)-1}`;
        newInputElement.maxLength = "100";
        newInputElement.placeholder = "Enter field name here";
        newInputElement.required = "true";

        newCol25Div.appendChild(newHiddenInputElement);
        newCol25Div.appendChild(newInputElement);

        // console.log(newInputElement);
        var newCol75Div = document.createElement("div");
        newCol75Div.classList.add("col75");

        var newInputElement1 = document.createElement("input");
        newInputElement1.type = "text";
        newInputElement1.name = `customInputElement${(counter*2)}`;
        newInputElement1.maxLength = "500";
        newInputElement1.placeholder = "Enter field value here";
        newInputElement1.required = "true";

        newCol75Div.appendChild(newInputElement1);

        newRowDiv.appendChild(newCol25Div);
        newRowDiv.appendChild(newCol75Div);

        var arr = document.querySelector("#add_custom_fields_div");
        //console.log(arr);
        

        var parentDiv = document.querySelector(argument);
        //console.log(parentDiv);

        var custom_fields_present = document.getElementById("custom_fields_present");
        custom_fields_present.value = "1";

        var custom_fields_number = document.getElementById("custom_fields_number");
        custom_fields_number.value = Number(custom_fields_number.value) + 1;

        parentDiv.insertBefore(newRowDiv, arr);
        // counter++;
        //console.log(counter);

        get_custom_elements();
    });
});
