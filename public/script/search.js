var searchText = "";
var total_pages = 1;

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
});
