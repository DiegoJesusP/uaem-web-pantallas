fetch('./templates/footer.php')
.then(response => response.text())
.then(data => {
    document.getElementById('footerContainer').innerHTML = data;
});