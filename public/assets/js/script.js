document.addEventListener('DOMContentLoaded', function(){
    const nav = document.querySelector('.nav');
    const scrollThreshold = 100;

    window.addEventListener('scroll', function(){
        if(window.scrollY > scrollThreshold){
            nav.classList.add('scrolled');
        } else{
            nav.classList.remove('scrolled');
        }
    });
});