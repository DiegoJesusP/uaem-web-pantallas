fetch('./../templates/header.php')
.then(response => response.text())
.then(data => {
    document.getElementById('headerContainer').innerHTML = data;
});