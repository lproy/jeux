document.getElementById("overlay-link").addEventListener("click", function(event) {
    event.preventDefault();
    document.getElementById("overlay").classList.add("show");
});

document.getElementById("overlay-close").addEventListener("click", function() {
    document.getElementById("overlay").classList.remove("show");
});