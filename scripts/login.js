


function show_psw(event){
    const input= document.getElementById('password');
    if (input.type === "password") {
        input.type = "text";
      } else {
        input.type = "password";
      }
}

button=document.getElementById('password_show');
button.addEventListener('click',show_psw);