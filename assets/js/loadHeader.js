fetch('http://localhost/ejemplo/uaem-web-pantallas/templates/header.html')
.then(response => response.text())
.then(data => {
    document.getElementById('headerContainer').innerHTML = data;
});