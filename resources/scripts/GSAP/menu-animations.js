/**
 * Menu hover animations
 * Handles background highlight and text color changes on menu items
 */

import { TIMING, EASE, SELECTORS } from "./config.js";

const DARK_CLASSES = ["theme-dark", "dark", "is-dark"];
const LIGHT_CLASSES = ["theme-light", "light", "is-light"];

/**
 * Detect if element is in dark mode context
 * @param {Element} el - Element to check
 * @returns {boolean} True if dark mode
 */
function isDarkMode(el) {
    if (!el) return false;

    // Check data-theme attribute
    const dataTheme = el.getAttribute?.("data-theme");
    if (dataTheme) return dataTheme === "dark";

    // Check element classes
    if (DARK_CLASSES.some((cls) => el.classList?.contains(cls))) return true;
    if (LIGHT_CLASSES.some((cls) => el.classList?.contains(cls))) return false;

    // Check ancestors
    const ancestor = el.closest?.(
        "[data-theme], .theme-dark, .theme-light, .dark, .light, .is-dark, .is-light"
    );
    if (ancestor) {
        const ancTheme = ancestor.getAttribute?.("data-theme");
        if (ancTheme) return ancTheme === "dark";
        if (DARK_CLASSES.some((cls) => ancestor.classList?.contains(cls)))
            return true;
        if (LIGHT_CLASSES.some((cls) => ancestor.classList?.contains(cls)))
            return false;
    }

    // Fallback to body or global
    const bodyTheme = document.body?.getAttribute?.("data-theme");
    if (bodyTheme) return bodyTheme === "dark";

    return window.menuColorScheme === "dark";
}

/**
 * Get menu colors based on theme
 * @param {Element} el - Element to check theme for
 * @returns {Object} Color configuration
 */
function getMenuColors(el) {
    const dark = isDarkMode(el);
    return {
        text: dark ? "rgba(255, 255, 255, 0.8)" : "rgba(0, 0, 0, 0.8)",
        textHover: dark ? "rgba(255, 255, 255, 1)" : "rgba(0, 0, 0, 1)",
        bg: dark ? "rgba(255, 255, 255)" : "rgba(0, 0, 0)",
    };
}

/**
 * Create background element for menu item
 * @param {string} bgColor - Background color
 * @returns {HTMLDivElement} Background element
 */
function createMenuBackground(bgColor) {
    const bg = document.createElement("div");
    bg.className = "menu-bg";
    Object.assign(bg.style, {
        position: "absolute",
        top: "0",
        left: "0",
        width: "100%",
        height: "100%",
        backgroundColor: bgColor,
        opacity: "0",
    });
    return bg;
}

/**
 * Initialize menu item hover animations
 */
export function initMenuAnimations() {
    const menuItems = document.querySelectorAll(SELECTORS.menuItem);

    menuItems.forEach((item) => {
        const colors = getMenuColors(item);
        const bg = createMenuBackground(colors.bg);
        const label = item.querySelector("label");

        item.style.position = "relative";
        item.insertBefore(bg, item.firstChild);

        gsap.set(label, { color: colors.text });

        item.addEventListener("mouseenter", () => {
            gsap.to(bg, {
                opacity: 0.3,
                duration: TIMING.normal,
                ease: EASE.out,
            });
            gsap.to(label, {
                color: colors.textHover,
                duration: TIMING.normal,
                ease: EASE.out,
            });
        });

        item.addEventListener("mouseleave", () => {
            gsap.to(bg, { opacity: 0, duration: TIMING.normal, ease: EASE.in });
            gsap.to(label, {
                color: colors.text,
                duration: TIMING.normal,
                ease: EASE.out,
            });
        });
    });
}
