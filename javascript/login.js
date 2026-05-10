const form = document.querySelector(".login form"),
continueBtn = form.querySelector(".button input"),
errorTxt = form.querySelector(".error-txt");

// Prevent default form submission (we use AJAX instead)
form.onsubmit = (e) => {
    e.preventDefault();
}

// Handle login button click
continueBtn.onclick = () => {
    let xhr = new XMLHttpRequest();
    xhr.open("Post", "php/login.php", true);
    xhr.onload = () => {
        if(xhr.readyState === xhr.DONE){
            if(xhr.status === 200){
                let data = xhr.response;

                // If login successful, redirect to users page
                if(data === "success"){
                    location.href = "users.php";
                }

                // Otherwise show error message
                else{
                    errorTxt.textContent = data;
                    errorTxt.style.display = "block";
                }
            }
        }
    }

    // Collect form data and send it to server (email + password)
    let formData = new FormData(form);
    xhr.send(formData);
}

