window.addEventListener("DOMContentLoaded", function() {
    var preloaderContainerElements = 
    Array.from(document.getElementsByClassName("preloaderContainer"));
    console.log(preloaderContainerElements);

    // var preloaderElement = Array.from(document.getElementsByClassName("preloader"));
    // console.log(preloaderElement);

    preloaderContainerElements.forEach((element) => {
        element.addEventListener("click", function() {
            // var preloaderElement = element.getElementsByClassName("preloader")[0];
            // preloaderElement.classList.remove("hide");

            // var spanElement = element.querySelector("span");
            // spanElement.classList.add("hide");

            // New approach
            var innerText = "";
            // if(element.type == 'input')
            // {
            //     innerText = element.value;
            //     element.value = 
            // }
            // else
            // {
            //     innerText = element.innerText;
            //     element.innerHTML = 
            //     `<div class="preloader">
            //     <div></div>
            //     </div>`;
            // }

            innerText = element.innerText;
            element.innerHTML = 
            `<div class="preloader">
            <div></div>
            </div>`;

            // if(!Response.ok)
            // {
            //     element.innerHTML = "";
            //     element.innerText = innerText;
            // }
        });
    });
});
