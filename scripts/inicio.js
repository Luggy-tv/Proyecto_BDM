courseList = document.querySelector("#cuadroBusqueda");
searchBar = document.querySelector("#searchBar");

searchBar.onkeyup=()=>{
    let searchTerm=searchBar.value;

    if (searchTerm != "") {
        courseList.style.display = "block";
        var xhr = new XMLHttpRequest();
    
        xhr.open("POST", "scripts/inicioSearch.php", true);
        xhr.onload = function () {
          if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
              let data = xhr.response;
              // console.log(xhr.response);
              courseList.innerHTML = data;
            }
          }
        };
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("searchTerm=" + searchTerm);
    }
}