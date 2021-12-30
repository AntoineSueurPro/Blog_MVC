var categories = document.getElementsByClassName('categorie')
for (let categorie of categories) {
    categorie.addEventListener('click', function (e) {
        for (let categorie of categories) {
            categorie.classList.remove('selected')
        }
        this.classList.add('selected')
        req('index.php?route=ajax&categorie=' + this.textContent);

    })
}
req('index.php?route=ajax&categorie=Tout')
let content = document.getElementById('content');
let goUp = document.getElementById("goUp");

window.addEventListener("scroll", function() {

    if(window.scrollY > 300) {
        goUp.classList.remove('animate__fadeOut');
        goUp.style.display = 'block';
        goUp.classList.add("animate__animated");
        goUp.classList.add("animate__fadeIn");
    }
    else {
        goUp.classList.add('animate__fadeOut');
    }
})

let suppr = document.getElementById('suppr')
suppr.addEventListener('click', supprimer)
