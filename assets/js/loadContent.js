document.addEventListener("DOMContentLoaded", function() {
    // Cargar el contenido del header
    fetch("./templates/header.html")
        .then(response => response.text())
        .then(data => {
            document.querySelector("head").insertAdjacentHTML("beforeend", data);
        });

    // Cargar el contenido del footer
    fetch("./templates/footer.html")
        .then(response => response.text())
        .then(data => {
            document.querySelector("body").insertAdjacentHTML("beforeend", data);
        });
});
