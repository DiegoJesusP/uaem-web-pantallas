fetch('http://localhost/ejemplo/uaem-web-pantallas/templates/nav.html')
.then(response => response.text())
.then(data => {
    document.getElementById('navContainer').innerHTML = data;
});