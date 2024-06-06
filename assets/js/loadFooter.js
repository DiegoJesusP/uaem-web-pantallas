fetch('http://localhost/ejemplo/uaem-web-pantallas/templates/footer.html')
.then(response => response.text())
.then(data => {
    document.getElementById('footerContainer').innerHTML = data;
});