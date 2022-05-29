function checkName(event) {
    const input = event.currentTarget;
    const pattern= /^[A-Za-z ]{1,30}$/;
    
    if ( pattern.test(input.value)) {
        formStatus[input.name] =true;
        const span=input.parentNode.parentNode.querySelector("span");
        span.classList.remove("errore");
    } else {
        formStatus[input.name] =false;
        const span=input.parentNode.parentNode.querySelector("span");
        span.classList.add("errore");
    }
    
    checkForm();
}

function onJsonCheckUsername(json) {
    // Controllo il campo exists ritornato dal JSON
    if (!json.exists) {
        formStatus.username=true;
        document.querySelector(".username span").classList.remove("errore");
    } else {
        const error=document.querySelector('.username span');
        error.textContent = "Nome utente già in uso";
        error.classList.add("errore");
        formStatus.username=false;
    }
    checkForm();
}

function onJsonCheckEmail(json) {
    // Controllo il campo exists ritornato dal JSON
    if (!json.exists) {
        formStatus.email = true;
        document.querySelector('.email span').classList.remove("errore");
    } else {
        const error=document.querySelector('.email span');
        error.textContent = "Email già in uso";
        error.classList.add("errore");
        formStatus.email = false;
    }
    checkForm();
}

function onResponse(response) {
    if (!response.ok) return null;
    return response.json();
}

function checkUsername(event) {
    const input = document.querySelector('.username input');
    const pattern=/^[a-zA-Z0-9_]{1,16}$/;
    if(!pattern.test(input.value)) {
        document.querySelector(".username span").classList.add("errore");
        formStatus.username = false;
        checkForm();
    } else {
        fetch("check_username.php?q="+encodeURIComponent(input.value)).then(onResponse).then(onJsonCheckUsername);
    }    
}

function checkEmail(event) {
    const emailInput = document.querySelector('.email input');
    const pattern=/^[A-z0-9\.\+_-]+@[A-z0-9\._-]+\.[A-z]{2,6}$/;
    if(!pattern.test(emailInput.value)) {
        document.querySelector('.email span').classList.add("errore");
        formStatus.email = false;
        checkForm();
    } else {
        fetch("check_email.php?q="+encodeURIComponent(emailInput.value)).then(onResponse).then(onJsonCheckEmail);
    }
}

function checkPassword(event) {
    const passwordInput = document.querySelector('.password input');
    const pattern=/^[A-Za-z0-9_!%&?]{8,20}$/;
    if ( pattern.test(passwordInput.value)) {
        const span=document.querySelector('.password span');
        formStatus.password =true;
        span.classList.remove("errore");
    } else {
        const span=document.querySelector('.password span');
        span.classList.add("errore");
        formStatus.password =false;
    }
    checkForm();
}

function checkConfirmPassword(event) {
    const confirmPasswordInput = document.querySelector('.confirm_password input');
    const span=document.querySelector('.confirm_password span');
    if (confirmPasswordInput.value === document.querySelector('.password input').value) {
        formStatus.confirmpassword=true;
        span.classList.remove("errore");
    } else {
        formStatus.confirmpassword =false;
        span.classList.add("errore");
    }
    checkForm();
}

function checkForm(){
    console.log(formStatus);
    if(Object.keys(formStatus).length === 6 && !Object.values(formStatus).includes(false))
        document.getElementById("submit").disabled=false;

}

function show_psw(event){
    const input=event.currentTarget.parentNode.parentNode.querySelector(".psw");
    if (input.type === "password") {
        input.type = "text";
      } else {
        input.type = "password";
      }
}


const buttons=document.querySelectorAll('.password_show');
for(let button of buttons){
    button.addEventListener('click',show_psw);;
}




const formStatus={};
document.querySelector('.name input').addEventListener('blur', checkName);
document.querySelector('.surname input').addEventListener('blur', checkName);
document.querySelector('.username input').addEventListener('blur', checkUsername);
document.querySelector('.email input').addEventListener('blur', checkEmail);
document.querySelector('.password input').addEventListener('blur', checkPassword);
document.querySelector('.confirm_password input').addEventListener('blur', checkConfirmPassword);