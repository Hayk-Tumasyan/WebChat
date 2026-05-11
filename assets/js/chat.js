const form = document.querySelector(".chat-area .typing-area"),
inputField = form.querySelector(".input-field"),
sendBtn = form.querySelector("button"),
fileInput = document.getElementById("fileInput"),
indicator = document.querySelector(".file-indicator"),
chatBox = document.querySelector(".chat-area .chat-box");

// Prevent default form submission
form.onsubmit = (e) => {
    e.preventDefault();
}

// Show/hide file indicator when user selects a file
if (fileInput && indicator) {
    fileInput.addEventListener("change", () => {
        indicator.classList.toggle("active", fileInput.files.length > 0);
    });
}

// Send message when send button is clicked
let msgSent = false;
sendBtn.onclick = () => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/insert-chat.php", true);
    xhr.onload = () => {
        if(xhr.readyState === xhr.DONE){
            if(xhr.status === 200){
                let data = xhr.response;

                // Clear input fields after sending message
                inputField.value = "";
                fileInput.value = "";           
                indicator.classList.remove("active");

                // Mark that a message was just sent (used for scrolling)
                msgSent = true;

                // If server returns something (error or message), show it in input
                if(data != ""){
                    inputField.value = data;
                }
            }
        }
    }

    // Collect form data (text + file)
    let formData = new FormData(form);

    // Send data to PHP backend
    xhr.send(formData);
}

// First load flag (used to auto-scroll only once initially)
let firstLoad = true;

// Poll server every 500ms for new messages (basic live chat)
setInterval(() => {
	let xhr = new XMLHttpRequest();
		xhr.open("POST", "php/get-chat.php", true);
		xhr.onload = () => {
			if(xhr.readyState === xhr.DONE){
				if(xhr.status === 200){
					let data = xhr.response;

                    // Update chat box with latest messages
					chatBox.innerHTML = data;

                    // If a message was just sent, scroll to bottom quickly
                    if(msgSent == true){
                        setTimeout(scrollToBottom, 5);
                        msgSent = false;
                    }

                    // On first load, scroll to bottom if chat is not empty
                    if(firstLoad && chatBox.innerHTML != ""){
                        scrollToBottom();
                        setTimeout(scrollToBottom, 50);
                        firstLoad = false;
                    }
				}
			}
		}

    let formData = new FormData(form) //creating a new formData Object
    xhr.send(formData); //sending the form data to php
}, 500);


// Scroll chat container to bottom
function scrollToBottom(){
    chatBox.scrollTop = chatBox.scrollHeight;
}
