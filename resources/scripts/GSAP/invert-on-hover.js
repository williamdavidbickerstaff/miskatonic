export function initInvertOnHover(selector = ".invert-on-hover") {
    const gsapRef = window.gsap || (typeof gsap !== "undefined" && gsap);
    if (!gsapRef) return;

    document.querySelectorAll(selector).forEach((el) => {
        // make the browser aware we'll animate filter
        el.style.willChange = "filter, opacity";

        const enter = () =>
            gsapRef.to(el, {
                filter: "invert(1) grayscale(1)",
                duration: 0.22,
                ease: "power1.out",
            });

        const leave = () =>
            gsapRef.to(el, {
                filter: "invert(0) grayscale(0)",
                duration: 0.22,
                ease: "power1.out",
            });

        el.addEventListener("mouseenter", enter);
        el.addEventListener("mouseleave", leave);

        // optional: support keyboard focus
        el.addEventListener("focusin", enter);
        el.addEventListener("focusout", leave);

        // clean up hook (if you ever remove node)
        el._invertOnHoverCleanup = () => {
            el.removeEventListener("mouseenter", enter);
            el.removeEventListener("mouseleave", leave);
            el.removeEventListener("focusin", enter);
            el.removeEventListener("focusout", leave);
        };
    });
}
