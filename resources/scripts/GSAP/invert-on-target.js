export function initInvertOnTarget(selector = ".invert-on-hover") {
    const gsapRef = window.gsap || (typeof gsap !== "undefined" && gsap);
    if (!gsapRef) return;

    document.querySelectorAll(selector).forEach((parent) => {
        // find the child we actually want to affect
        const target = parent.querySelector(".invert-target");
        if (!target) return;

        target.style.willChange = "filter, opacity";

        const enter = () =>
            gsapRef.to(target, {
                filter: "invert(1) grayscale(1)",
                duration: 0.22,
                ease: "power1.out",
            });

        const leave = () =>
            gsapRef.to(target, {
                filter: "invert(0) grayscale(0)",
                duration: 0.22,
                ease: "power1.out",
            });

        parent.addEventListener("mouseenter", enter);
        parent.addEventListener("mouseleave", leave);
        parent.addEventListener("focusin", enter);
        parent.addEventListener("focusout", leave);

        parent._invertOnHoverCleanup = () => {
            parent.removeEventListener("mouseenter", enter);
            parent.removeEventListener("mouseleave", leave);
            parent.removeEventListener("focusin", enter);
            parent.removeEventListener("focusout", leave);
        };
    });
}
