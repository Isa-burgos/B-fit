const contactName = document.getElementById("name");
const contactEmail = document.getElementById("email");
const contactPhone = document.getElementById("phone");
const contactMessage = document.getElementById("message");
const contactBtn = document.getElementById("btn-send");
const messageSuccess = document.querySelector(".message-sent-email");

if(contactName) contactName.addEventListener("keyup", validateForm);
if(contactEmail) contactEmail.addEventListener("keyup", validateForm);
if(contactPhone) contactPhone.addEventListener("keyup", validateForm);
if(contactMessage) contactMessage.addEventListener("keyup", validateForm);

function validateForm(){
    const nameOk = validateName(contactName);
    const emailOk = validateEmail(contactEmail);
    const phoneOk = validatePhone(contactPhone);
    const messageOk = validateMessage(contactMessage);

    if(nameOk && emailOk && phoneOk && messageOk){
        contactBtn.disabled = false;
    } else{
        contactBtn.disabled = true;
    }
}

function validateName(input){
    if(contactName !== "" && contactName.value.length >=3){
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    } else{
        input.classList.remove("is-valid");
        input.classList.add("is-invalid");
        return false;
    }
}

function validatePhone(input){
    const phoneRegex = /^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/g
    const phoneContact = contactPhone.value.trim();

    if(phoneContact !== "" && phoneContact.match(phoneRegex)){
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    } else{
        input.classList.remove("is-valid");
        input.classList.add("is-invalid");
        return false;
    }
}

function validateMessage(input){
    if(contactMessage.value !== "" && contactMessage.value.length >= 20){
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    } else{
        input.classList.remove("is-valid");
        input.classList.add("is-invalid");
        return false;
    }
}

function validateEmail(input){
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const emailContact = contactEmail.value.trim();

    if(emailContact.match(emailRegex)){
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    } else{
        input.classList.remove("is-valid");
        input.classList.add("is-invalid");
        return false;
    }
}