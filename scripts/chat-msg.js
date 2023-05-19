


setInterval(() => {
  //AJAX
  var xhr = new XMLHttpRequest();

  xhr.open("GET", "scripts/chatUpdate.php", true);
  xhr.onload = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        chatlist = document.getElementById("#getchat");
        chatlist.innerHTML="";
        chatlist.innerHTML = data;
      }
    }
  };

  xhr.send();
}, 500);
