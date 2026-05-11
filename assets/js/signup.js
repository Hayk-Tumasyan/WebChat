const form = document.querySelector(".signup form"),
continueBtn = form.querySelector(".button input"),
errorTxt = form.querySelector(".error-txt");

form.onsubmit = (e) => {
    e.preventDefault();
}

// Handle signup button click
continueBtn.onclick = () => {
    let xhr = new XMLHttpRequest();
    xhr.open("Post", "php/signup.php", true);
    xhr.onload = () => {
        if(xhr.readyState === xhr.DONE){
            if(xhr.status === 200){
                let data = xhr.response;

                // if signup was successful, redirect to users page
                if(data == "success"){
                    location.href = "users.php"
                } else{ // otherwise display error message
                    errorTxt.textContent = data;
                    errorTxt.style.display = "block";
                }
            }
        }
    }
    
    // Collect form data (username, email, password, etc.)
    let formData = new FormData(form)
    xhr.send(formData);
}