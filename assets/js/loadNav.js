fetch('./templates/nav.php')
.then(response => response.text())
.then(data => {
    document.getElementById('navContainer').innerHTML = data;
});