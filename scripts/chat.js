userList = document.querySelector("#user-list");
searchBar =document.querySelector("#searchBar");

searchBar.onkeyup=()=>{
  let searchTerm= searchBar.value;
  if(searchTerm!=""){
    var xhr = new XMLHttpRequest();

    xhr.open("POST", "scripts/chatSearch.php", true);  
    xhr.onload = function () {
      if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status ===200){
          
          let data = xhr.response;
         console.log(data);
        }
      }
    };
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send("searchTerm=" +searchTerm);
  }
}

setInterval(()=>{
    
    //AJAX
    var xhr = new XMLHttpRequest();

    xhr.open("GET", "scripts/chatUsers.php", true);  
    xhr.onload = function () {
      if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status ===200){
          
          let data = xhr.response;
          userList.innerHTML =data;
        }
      }
    };
  
    xhr.send();
},500);