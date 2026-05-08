const $form = document.querySelector(".chat-area .typing-area"),
$inputField = $form.querySelector(".input-field"),
$sendBtn = $form.querySelector("button"),
$fileInput = document.getElementById("fileInput"),
$indicator = document.querySelector(".file-indicator"),
$chatBox = document.querySelector(".chat-area .chat-box");

$form.onsubmit = (e) => {
    e.preventDefault();
}

// console.log("hello");

if ($fileInput && $indicator) {
    $fileInput.addEventListener("change", () => {
        $indicator.classList.toggle("active", $fileInput.files.length > 0);
    });
}

$sendBtn.onclick = () => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/insert-chat.php", true);
    xhr.onload = () => {
        if(xhr.readyState === xhr.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                $inputField.value = "";
                $fileInput.value = "";           
                $indicator.classList.remove("active");
                setTimeout(scrollToBottom, 5);
            }
        }
    }

    let formData = new FormData($form);
    xhr.send(formData);
}


let firstLoad = true;
setInterval(() => {
	let xhr = new XMLHttpRequest();
		xhr.open("POST", "php/get-chat.php", true);
		xhr.onload = () => {
			if(xhr.readyState === xhr.DONE){
				if(xhr.status === 200){
					let data = xhr.response;
					$chatBox.innerHTML = data;

                    if(firstLoad && $chatBox.innerHTML != ""){
                        scrollToBottom();
                        setTimeout(scrollToBottom, 50);
                        firstLoad = false;
                    }
				}
			}
		}

    let formData = new FormData($form) //creating a new formData Object
    xhr.send(formData); //sending the form data to php
}, 500);

function scrollToBottom(){
    $chatBox.scrollTop = $chatBox.scrollHeight;
}
