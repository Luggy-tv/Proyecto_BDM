class user{
    constructor(user,password){
        this.password=password;
        this.user=user;
    }
}

let formLogin =document.getElementById("form-login");

formLogin.addEventListener("submit", (e)=>{
    e.preventDefault();
    let inputEmail = document.getElementById("email");
    let inputContraseña =document.getElementById("password");

    if(validatePassword(inputContraseña) && validateMail(inputEmail)){

    }

})

function validatePassword(password){
    
}

function validateMail(user){

}

//(¡”#$%&/=’?¡¿:;,.-_+*{][})