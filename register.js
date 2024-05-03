var form = document.form
var message = document.getElementById("message");

const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

form.onsubmit = (e) => {
    e.preventDefault()
        if (form.name.value == "" || form.email.value == "" || form.password.value == "" || form.cPassword.value == "") 
        {
            message.innerHTML = "All Fields are required"
            message.style.transform = "translate(0%)";
        } 
        else if (form.name.value.length < 5) 
        {
            message.innerHTML = "Name must be greater or equal to 5 characters"
            message.style.transform = "translate(0%)";
        } 
        else if (!emailRegex.test(form.email.value))
        {
            message.innerHTML = "Invalid Email Address"
            message.style.transform = "translate(0%)";
        } 
        else if (form.password.value.length !== 4) {
            message.innerHTML = "Password must be 4 characters"
            message.style.transform = "translate(0%)";
        } 
        else if (form.password.value !== form.cPassword.value) 
        {
            message.innerHTML = "Password does not match"
            message.style.transform = "translate(0%)";
        } 
        else 
        {
            message.innerHTML = "You've registered succesfully"
            message.style.transform = "translate(0%)";
            message.style.color= "green"
            setTimeout(() => {
                form.submit()
            }, 1000)
        }
    removeMessage();
}

function removeMessage() {
    setTimeout(() => {
        message.style.transform = "translate(-120%)";
        message.style.color= "red"
    }, 2000)
}


form.name.addEventListener("focus", function () {
    form.name.previousElementSibling.style.display = "block"
})
form.email.addEventListener("focus", function () {
    form.email.previousElementSibling.style.display = "block"
})
form.password.addEventListener("focus", function () {
    form.password.previousElementSibling.style.display = "block"
})
form.cPassword.addEventListener("focus", function () {
    form.cPassword.previousElementSibling.style.display = "block"
})

