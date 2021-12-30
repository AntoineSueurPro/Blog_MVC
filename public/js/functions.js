function req(url) {
    let req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (this.status === 200 && this.readyState === 4) {
            let res = this.response
            if(res.length > 0) {
                content.innerHTML = ''
            for (let article of res) {
                addContent(article)
            }
            } else {
                noArticle();
            }
        }
    }
    req.open('GET', url, true)
    req.responseType = "json"
    req.send()
}

function addContent(content) {
    let container = document.getElementById('content');
    let myElement = document.createElement('div');
    content['created_at'] = content['created_at'].split("-")
    content['created_at'] = content['created_at'].reverse()
    content['created_at'] = content['created_at'].join("-")
    myElement.className = 'animate__animated animate__fadeIn item-article'
    myElement.innerHTML +=
        '<img  class="card-img-top round" alt="image du post" src="public/img/' + content['image'] +'"></div>' +
        '<div class="mt-2">' +
            '<p class="hero-date">'+ content['created_at'] +'</p>' +
            '<h5 class="card-title"><a class="titre-md" href="index.php?route=article&articleId=' + content['id_article'] + '">' + content['titre'] + '</a></h5>' +
            '<div>' + (content['categorie'] === null ? 'Sans categorie' : content['categorie']) + '</div>' +
            '<p class="card-text">' + content['contenu'].substr(0, 150) + '...' + '</p>' + '</p>' +
            '<a href="index.php?route=article&articleId=' + content['id_article'] + '" class="bouton">Lire l\'article</a>' +
        '</div>'
    container.append(myElement);
}

function noArticle() {
    let container = document.getElementById('content');
    content.innerHTML = '';
    container.innerHTML = '<p class="animate__animated animate__fadeIn m-auto test">Désolé, aucun article dans cette catégorie.</p>'
}

function supprimer() {
    let ask = window.confirm('Voulez-vous vraiment supprimer votre compte ? Cette action est irréversible.')
    if(ask) {
        window.alert('Compte supprimé')
        window.location.href= 'index.php?route=profil&action=deleteAccount'
    }
}
