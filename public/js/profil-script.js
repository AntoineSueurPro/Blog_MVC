function supprimer() {
    let ask = window.confirm('Voulez-vous vraiment supprimer votre compte ? Cette action est irréversible.')
    if(ask) {
        window.alert('Compte supprimé')
        window.location.href= 'index.php?route=profil&action=deleteAccount'
    }
}

let suppr = document.getElementById('suppr')
suppr.addEventListener('click', supprimer)