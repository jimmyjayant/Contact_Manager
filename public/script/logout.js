function countDownTimer()
{
    var counter = 3;
    var id = setInterval(function() {
        if(counter == 0)
        {
            clearInterval(id);
            window.location.href = "login";
        }
        var time = document.getElementById("time");
        time.innerHTML = counter;
        counter--;
    }, 1000);
}


window.addEventListener("DOMContentLoaded", function() {
    var xhttp = new XMLHttpRequest();
    var statusDiv = document.getElementById("status");

    xhttp.onload = function() {
        var data = JSON.parse(this.responseText);

        if(data)
        {
            if(data.status == 'error')
            {
                statusDiv.classList.remove('success');
                statusDiv.classList.add('error');
                statusDiv.innerHTML = data.data;
            }
            else if(data.status == 'success')
            {
                statusDiv.classList.remove('error');
                statusDiv.classList.add('success');
                statusDiv.innerHTML = "User logged out successfully! Redirecting to login page in ";
                statusDiv.innerHTML += "<span id='time'>3</span> seconds.";
                countDownTimer();
            }
        }
        else
        {
            statusDiv.classList.remove('success');
            statusDiv.classList.add('error');
            statusDiv.innerHTML = data.data;
        }
    }

    xhttp.open('POST', "logout_user", true);
    xhttp.send();
});
