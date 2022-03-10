let vueMembres = document.getElementById('vueMembres')
let vueEnsemble = document.getElementById('vueEnsemble')
let vueCategories = document.getElementById('vueCategories')
let vueArticles = document.getElementById('vueArticles')

let overview = document.getElementById('overview')
let sectionArticles = document.getElementById('sectionArticles')
let sectionCategories = document.getElementById('sectionCategories')
let sectionMembres = document.getElementById('sectionMembres')

let onglet = document.getElementById('onglet')


vueMembres.addEventListener('click', showMembres)
vueEnsemble.addEventListener('click', showOverview)
vueCategories.addEventListener('click', showCategories)
vueArticles.addEventListener('click', showArticles)

if(onglet.value === 'membres') {
    showMembres()
}

if(onglet.value === 'article') {
    showArticles()
}

if(onglet.value === 'categorie') {
    showCategories()
}


function showArticles() {
    overview.classList.add('d-none')
    sectionCategories.classList.add('d-none')
    sectionMembres.classList.add('d-none')
    sectionArticles.classList.remove('d-none')
}

function showOverview() {
    overview.classList.remove('d-none')
    sectionCategories.classList.add('d-none')
    sectionMembres.classList.add('d-none')
    sectionArticles.classList.add('d-none')

}

function showCategories() {
    overview.classList.add('d-none')
    sectionCategories.classList.remove('d-none')
    sectionMembres.classList.add('d-none')
    sectionArticles.classList.add('d-none')
}

function showMembres(){
    overview.classList.add('d-none')
    sectionCategories.classList.add('d-none')
    sectionMembres.classList.remove('d-none')
    sectionArticles.classList.add('d-none')
}