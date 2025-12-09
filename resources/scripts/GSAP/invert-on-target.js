/**
 * Invert filter animation targeting a child element
 * Hover on parent, effect applies to .invert-target child
 */

import { EASE } from "./config.js";

const INVERT_DURATION = 0.22;

/**
 * Initialize invert effect on child target when parent is hovered
 * @param {string} selector - CSS selector for parent elements
 */
export function initInvertOnTarget(selector = ".invert-on-hover") {
    if (typeof gsap === "undefined") return;

    document.querySelectorAll(selector).forEach((parent) => {
        const target = parent.querySelector(".invert-target");
        if (!target) return;

        target.style.willChange = "filter, opacity";

        const enter = () =>
            gsap.to(target, {
                filter: "invert(1) grayscale(1)",
                duration: INVERT_DURATION,
                ease: EASE.smooth,
            });

        const leave = () =>
            gsap.to(target, {
                filter: "invert(0) grayscale(0)",
                duration: INVERT_DURATION,
                ease: EASE.smooth,
            });

        // Mouse events on parent
        parent.addEventListener("mouseenter", enter);
        parent.addEventListener("mouseleave", leave);

        // Keyboard accessibility
        parent.addEventListener("focusin", enter);
        parent.addEventListener("focusout", leave);

        // Cleanup hook
        parent._invertOnHoverCleanup = () => {
            parent.removeEventListener("mouseenter", enter);
            parent.removeEventListener("mouseleave", leave);
            parent.removeEventListener("focusin", enter);
            parent.removeEventListener("focusout", leave);
        };
    });
}
