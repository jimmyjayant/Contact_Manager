window.addEventListener("DOMContentLoaded", function() {
    var removeCustomInputElement = Array.from(document.querySelectorAll(".dropCustomElement span"));
    console.log(removeCustomInputElement);

    removeCustomInputElement.forEach((button) => {
        button.addEventListener("click", function() {
            // console.log(button.parentElement.parentElement);
            var rowDiv = button.parentElement.parentElement;
            rowDiv.remove();

            var custom_fields_number = document.getElementById("custom_fields_number");
            if(custom_fields_number.value == 1)
            {
                document.getElementById("custom_fields_present").value = '0';
            }
            custom_fields_number.value -= 1;
        });
    });
});
