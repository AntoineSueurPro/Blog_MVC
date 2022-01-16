let open = document.getElementById('open-menu');
let menu = document.getElementById('menu');
let close = document.getElementById('close-menu')

open.addEventListener('click', function (){
    menu.classList.remove('animate__fadeOutDown')
    menu.classList.add('animate__fadeInUp')
    menu.classList.remove('d-none');
    open.classList.add('d-none');
    close.classList.remove('d-none');

})

close.addEventListener('click', function (){
    menu.classList.remove('animate__fadeInUp')
    menu.classList.add('animate__fadeOutDown')
    close.classList.add('d-none');
    open.classList.remove('d-none')
})
