fetch('http://localhost/ejemplo/uaem-web-pantallas/templates/footer-evadoc.html')
.then(response => response.text())
.then(data => {
    document.getElementById('footerEvaContainer').innerHTML = data;
});