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



