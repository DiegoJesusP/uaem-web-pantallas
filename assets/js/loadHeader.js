fetch('http://localhost/uaem-web-pantallas/templates/header.php')
.then(response => response.text())
.then(data => {
    document.getElementById('headerContainer').innerHTML = data;
});