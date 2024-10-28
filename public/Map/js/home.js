
TweenMax.staggerFrom(".leFadeIn span", 1, {autoAlpha:0, ease: Power4.easeIn}, 0.9);

document.addEventListener("DOMContentLoaded", () => {
    const elementsToAnimate = document.querySelectorAll(
        ".logo-pantanal, .texto-descricao,.titulo-descricao, .about-content, .project-content, .box-figura, .texto-section1, .titulo-section1, .referenciaIMG, .team-member, .button, .tiuloTeam, .guavirinha"
    );

    const observerOptions = {
        root: null,
        threshold: 0.1 
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            let animationClass;
            if (entry.target.classList.contains("team-member") || entry.target.classList.contains("button") || entry.target.classList.contains("tiuloTeam")) {
                animationClass = "animated-intop";
            } else if (entry.target.classList.contains("guavirinha") ) {
                animationClass = "animate-scale";
            } 
             else  {
                animationClass = "animated-inleft";
            }
            
            if (entry.isIntersecting) {
                // Remove a animação para garantir que ela seja reiniciada
                entry.target.classList.remove(animationClass, "animated");

                // Adiciona um pequeno delay para reiniciar a animação
                setTimeout(() => {
                    entry.target.classList.add(animationClass, "animated");
                }, 50);
            } else {
                // Remove as classes quando o elemento sai do viewport
                entry.target.classList.remove(animationClass, "animated");
            }
        });
    }, observerOptions);

    elementsToAnimate.forEach(element => {
        observer.observe(element);
    });
});
