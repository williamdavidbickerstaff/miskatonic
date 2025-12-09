/**
 * Shared GSAP animation configuration
 * Centralizes timing, easing, and selectors for consistency
 */

// Animation timing (in seconds)
export const TIMING = {
    fast: 0.2,
    normal: 0.3,
    medium: 0.4,
    slow: 0.5,
    slower: 0.6,
};

// Easing functions
export const EASE = {
    out: "power2.out",
    in: "power2.in",
    inOut: "power2.inOut",
    smooth: "power1.out",
};

// Common selectors
export const SELECTORS = {
    wordmark: "[data-wordmark]",
    wordmarkTitle: "h1[data-wordmark].title-style",
    menuItem: "[data-menu-item]",
    mainContainer: ".mx-auto",
    gridContent: ".grid > div:not([data-wordmark])",
};

// Internal link selector (for page transitions)
export const INTERNAL_LINK_SELECTOR = `a[href^="/"], a[href^="${window.location.origin}"]`;

// Wordmark pattern for detection
export const WORDMARK_PATTERN = ["MIS", "KA", "TON", "IC"];

/**
 * Find all wordmark containers (links containing MIS/KA/TON/IC pattern)
 * @returns {Element[]} Array of container elements
 */
export function findWordmarkContainers() {
    const allLinks = document.querySelectorAll("a");

    return Array.from(allLinks).filter((link) => {
        const letterGroups = link.querySelectorAll(SELECTORS.wordmarkTitle);
        if (letterGroups.length !== 4) return false;

        const texts = Array.from(letterGroups).map((el) =>
            el.textContent.trim()
        );
        return (
            texts[0].includes(WORDMARK_PATTERN[0]) &&
            texts[1].includes(WORDMARK_PATTERN[1]) &&
            texts[2].includes(WORDMARK_PATTERN[2]) &&
            texts[3].includes(WORDMARK_PATTERN[3])
        );
    });
}

/**
 * Get all internal links (for page transitions)
 * @returns {NodeList} Internal link elements
 */
export function getInternalLinks() {
    return document.querySelectorAll(INTERNAL_LINK_SELECTOR);
}

/**
 * Check if a click event should skip transition handling
 * @param {Event} e - Click event
 * @param {Element} link - Link element
 * @returns {boolean} True if should skip
 */
export function shouldSkipTransition(e, link) {
    const href = link.getAttribute("href");
    return (
        href.startsWith("#") ||
        link.target === "_blank" ||
        e.ctrlKey ||
        e.metaKey ||
        e.shiftKey
    );
}
