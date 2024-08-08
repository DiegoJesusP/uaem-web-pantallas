fetch('./../templates/footerevadoc.php')
.then(response => response.text())
.then(data => {
    document.getElementById('footerEvaContainer').innerHTML = data;
});