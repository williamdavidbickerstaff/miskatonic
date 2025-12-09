/**
 * Invert filter animation on hover
 * Creates a dramatic invert + grayscale effect for images/elements
 */

import { EASE } from "./config.js";

const INVERT_DURATION = 0.22;

/**
 * Initialize invert-on-hover effect for selected elements
 * @param {string} selector - CSS selector for target elements
 */
export function initInvertOnHover(selector = ".invert-on-hover") {
    if (typeof gsap === "undefined") return;

    document.querySelectorAll(selector).forEach((el) => {
        el.style.willChange = "filter, opacity";

        const enter = () =>
            gsap.to(el, {
                filter: "invert(1) grayscale(1)",
                duration: INVERT_DURATION,
                ease: EASE.smooth,
            });

        const leave = () =>
            gsap.to(el, {
                filter: "invert(0) grayscale(0)",
                duration: INVERT_DURATION,
                ease: EASE.smooth,
            });

        // Mouse events
        el.addEventListener("mouseenter", enter);
        el.addEventListener("mouseleave", leave);

        // Keyboard accessibility
        el.addEventListener("focusin", enter);
        el.addEventListener("focusout", leave);

        // Cleanup hook for dynamic removal
        el._invertOnHoverCleanup = () => {
            el.removeEventListener("mouseenter", enter);
            el.removeEventListener("mouseleave", leave);
            el.removeEventListener("focusin", enter);
            el.removeEventListener("focusout", leave);
        };
    });
}
