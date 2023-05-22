chatList = document.querySelector("#chatlist");
userList = document.querySelector("#user-list");
searchBar = document.querySelector("#searchBar");

let form, inputField, sendBtn;

function showConvo(id) {
  var xhr = new XMLHttpRequest();

  xhr.open("POST", "scripts/chatMessages.php", true);
  xhr.onload = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        chatList.innerHTML = data;
        form = document.getElementById("typing-Area");
        inputField = document.getElementById("InputField");
        sendBtn = document.getElementById("button-addon2");
        reloadBtn = document.getElementById("button-addon3");
        messagelist = document.getElementById("getchat");
        

        form.addEventListener("submit", function (e) {
          e.preventDefault();

          var xhr = new XMLHttpRequest();

          xhr.open("POST", "scripts/chatMessagesSend.php", true);
          xhr.onload = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
              if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                  inputField.value = "";
                  reload();
                  
                } else {
                  mostrarError(response.message);
                }
              }
            }
          };

          let fromData = new FormData(form);
          xhr.send(fromData);


          function reload(){
            var xhr = new XMLHttpRequest();

            xhr.open("POST", "scripts/chatUpdate.php", true);
            xhr.onload = function () {
              if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                  let data = xhr.response;
                  messagelist.innerHTML="";
                  messagelist.innerHTML = data;
                }
              }
            };
          
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("id=" + id);
          }
        });

        reloadBtn.onclick=function() {

          var xhr = new XMLHttpRequest();

          xhr.open("POST", "scripts/chatUpdate.php", true);
          xhr.onload = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
              if (xhr.status === 200) {
                let data = xhr.response;
                messagelist.innerHTML="";
                messagelist.innerHTML = data;
              }
            }
          };
        
          xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xhr.send("id=" + id);
        }
      }
    }
  };

  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("id=" + id);
}

// function loadChatlist() {}

searchBar.onkeyup = () => {
  let searchTerm = searchBar.value;

  if (searchTerm != "") {
    searchBar.classList.add("active");
  } else {
    searchBar.classList.remove("active");
  }

  if (searchTerm != "") {
    var xhr = new XMLHttpRequest();

    xhr.open("POST", "scripts/chatSearch.php", true);
    xhr.onload = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          let data = xhr.response;
          userList.innerHTML = data;
        }
      }
    };
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("searchTerm=" + searchTerm);
  }
};

setInterval(() => {
  //AJAX
  var xhr = new XMLHttpRequest();

  xhr.open("GET", "scripts/chatUsers.php", true);
  xhr.onload = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        if (!searchBar.classList.contains("active")) {
          userList.innerHTML = data;
        }
      }
    }
  };

  xhr.send();
}, 500);
