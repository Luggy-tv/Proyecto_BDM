class user{
    constructor(user,password){
        this.password=password;
        this.user=user;
    }
}

var nameRegex = new RegExp("^[A-Za-z]+$");
var passRegex = new RegExp("^((?=.*[A-Z])(?=.*[0-9])(?=.*[-¡!¿?:;@#_$%^&,.{}=+*[])(?=.{8,}))");

let formSignin = document.getElementById("form-signin");

formSignin.addEventListener("submit", (e)=>{


})