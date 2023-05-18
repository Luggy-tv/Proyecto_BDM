chatList = document.querySelector("#chatbox");
userList = document.querySelector("#user-list");
searchBar = document.querySelector("#searchBar");

form = document.querySelector("#typing-Area");
inputField =form.querySelector("#InputField");
sendBtn =form.querySelector("#button-addon2");


function showConvo(id) {

  var xhr = new XMLHttpRequest();

  xhr.open("POST", "scripts/chatMessages.php", true);
  xhr.onload = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        chatList.innerHTML = data;
      }
    }
  };

 xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("id=" + id);
}

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
