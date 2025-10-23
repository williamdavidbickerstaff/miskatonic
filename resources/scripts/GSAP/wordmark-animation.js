export function initWordmarkAnimations() {
    const wordmarkElements = document.querySelectorAll("[data-wordmark]");
    gsap.set(wordmarkElements, { opacity: 0 });
    gsap.to(wordmarkElements, {
        opacity: 1,
        duration: 0.5,
        stagger: 0.2,
        ease: "power2.out",
    });
}
