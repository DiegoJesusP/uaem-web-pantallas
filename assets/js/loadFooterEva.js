fetch('http://localhost/ejemplo/uaem-web-pantallas/templates/footerevadoc.html')
.then(response => response.text())
.then(data => {
    document.getElementById('footerEvaContainer').innerHTML = data;
});