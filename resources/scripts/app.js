/**
 * Main application entry point
 * Initializes all GSAP animations and interactions
 * Uses globally loaded GSAP from CDN
 */

(function () {
    "use strict";

    // ============================================
    // CONFIGURATION
    // ============================================

    const TIMING = {
        fast: 0.2,
        normal: 0.3,
        medium: 0.4,
        slow: 0.5,
        slower: 0.6,
    };

    const EASE = {
        out: "power2.out",
        in: "power2.in",
        inOut: "power2.inOut",
        smooth: "power1.out",
    };

    const SELECTORS = {
        wordmark: "[data-wordmark]",
        wordmarkTitle: "h1[data-wordmark].title-style",
        menuItem: "[data-menu-item]",
        mainContainer: ".mx-auto",
        gridContent: ".grid > div:not([data-wordmark])",
    };

    const INTERNAL_LINK_SELECTOR =
        'a[href^="/"], a[href^="' + window.location.origin + '"]';
    const WORDMARK_PATTERN = ["MIS", "KA", "TON", "IC"];

    // ============================================
    // HELPER FUNCTIONS
    // ============================================

    function findWordmarkContainers() {
        const allLinks = document.querySelectorAll("a");

        return Array.from(allLinks).filter(function (link) {
            const letterGroups = link.querySelectorAll(SELECTORS.wordmarkTitle);
            if (letterGroups.length !== 4) return false;

            const texts = Array.from(letterGroups).map(function (el) {
                return el.textContent.trim();
            });
            return (
                texts[0].includes(WORDMARK_PATTERN[0]) &&
                texts[1].includes(WORDMARK_PATTERN[1]) &&
                texts[2].includes(WORDMARK_PATTERN[2]) &&
                texts[3].includes(WORDMARK_PATTERN[3])
            );
        });
    }

    function getInternalLinks() {
        return document.querySelectorAll(INTERNAL_LINK_SELECTOR);
    }

    function shouldSkipTransition(e, link) {
        const href = link.getAttribute("href");
        return (
            href.startsWith("#") ||
            link.target === "_blank" ||
            e.ctrlKey ||
            e.metaKey ||
            e.shiftKey
        );
    }

    // ============================================
    // PAGE FADE IN
    // ============================================

    function initContentFadeIn() {
        gsap.set("html", { visibility: "hidden", opacity: 0 });
        gsap.set("body", { opacity: 0 });
        gsap.set(SELECTORS.mainContainer, { opacity: 0 });

        const tl = gsap.timeline({ immediateRender: false });

        tl.set("html", { visibility: "visible" });
        tl.to("html", {
            opacity: 1,
            duration: TIMING.normal,
            ease: EASE.out,
            immediateRender: true,
        });
        tl.to(
            "body",
            {
                opacity: 1,
                duration: TIMING.normal,
                ease: EASE.out,
                immediateRender: true,
            },
            "-=0.3"
        );

        tl.to(
            SELECTORS.mainContainer,
            {
                opacity: 1,
                duration: TIMING.medium,
                ease: EASE.out,
            },
            "-=0.2"
        );

        tl.from(
            SELECTORS.wordmark,
            {
                opacity: 0,
                y: 20,
                duration: TIMING.slow,
                stagger: 0.1,
                ease: EASE.out,
            },
            "-=0.3"
        );

        tl.from(
            SELECTORS.gridContent,
            {
                opacity: 0,
                y: 15,
                duration: TIMING.slower,
                stagger: 0.08,
                ease: EASE.out,
            },
            "-=0.4"
        );
    }

    function initSimplePageTransitions() {
        const internalLinks = getInternalLinks();

        internalLinks.forEach(function (link) {
            link.addEventListener("click", function (e) {
                if (shouldSkipTransition(e, this)) return;

                e.preventDefault();
                const href = this.getAttribute("href");

                gsap.timeline({
                    onComplete: function () {
                        gsap.set("html", { visibility: "hidden", opacity: 0 });
                        window.location.href = href;
                    },
                }).to("body", {
                    opacity: 0,
                    duration: TIMING.medium,
                    ease: EASE.in,
                });
            });
        });
    }

    // ============================================
    // MENU ANIMATIONS
    // ============================================

    const DARK_CLASSES = ["theme-dark", "dark", "is-dark"];
    const LIGHT_CLASSES = ["theme-light", "light", "is-light"];

    function isDarkMode(el) {
        if (!el) return false;

        const dataTheme = el.getAttribute && el.getAttribute("data-theme");
        if (dataTheme) return dataTheme === "dark";

        if (
            DARK_CLASSES.some(function (cls) {
                return el.classList && el.classList.contains(cls);
            })
        )
            return true;
        if (
            LIGHT_CLASSES.some(function (cls) {
                return el.classList && el.classList.contains(cls);
            })
        )
            return false;

        const ancestor =
            el.closest &&
            el.closest(
                "[data-theme], .theme-dark, .theme-light, .dark, .light, .is-dark, .is-light"
            );
        if (ancestor) {
            const ancTheme =
                ancestor.getAttribute && ancestor.getAttribute("data-theme");
            if (ancTheme) return ancTheme === "dark";
            if (
                DARK_CLASSES.some(function (cls) {
                    return (
                        ancestor.classList && ancestor.classList.contains(cls)
                    );
                })
            )
                return true;
            if (
                LIGHT_CLASSES.some(function (cls) {
                    return (
                        ancestor.classList && ancestor.classList.contains(cls)
                    );
                })
            )
                return false;
        }

        const bodyTheme =
            document.body &&
            document.body.getAttribute &&
            document.body.getAttribute("data-theme");
        if (bodyTheme) return bodyTheme === "dark";

        return window.menuColorScheme === "dark";
    }

    function getMenuColors(el) {
        const dark = isDarkMode(el);
        return {
            text: dark ? "rgba(255, 255, 255, 0.8)" : "rgba(0, 0, 0, 0.8)",
            textHover: dark ? "rgba(255, 255, 255, 1)" : "rgba(0, 0, 0, 1)",
            bg: dark ? "rgba(255, 255, 255)" : "rgba(0, 0, 0)",
        };
    }

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

    function initMenuAnimations() {
        const menuItems = document.querySelectorAll(SELECTORS.menuItem);

        menuItems.forEach(function (item) {
            const colors = getMenuColors(item);
            const bg = createMenuBackground(colors.bg);
            const label = item.querySelector("label");

            item.style.position = "relative";
            item.insertBefore(bg, item.firstChild);

            gsap.set(label, { color: colors.text });

            item.addEventListener("mouseenter", function () {
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

            item.addEventListener("mouseleave", function () {
                gsap.to(bg, {
                    opacity: 0,
                    duration: TIMING.normal,
                    ease: EASE.in,
                });
                gsap.to(label, {
                    color: colors.text,
                    duration: TIMING.normal,
                    ease: EASE.out,
                });
            });
        });
    }

    // ============================================
    // WORDMARK ANIMATIONS
    // ============================================

    const SCRAMBLE_CHARS = "MISKATONIC";
    const SCRAMBLE_INTERVAL_MS = 80;

    function generateScrambledText(text, chars) {
        chars = chars || SCRAMBLE_CHARS;
        return text
            .split("")
            .map(function (char) {
                if (char === " " || /[^A-Za-z0-9]/.test(char)) return char;
                return chars[Math.floor(Math.random() * chars.length)];
            })
            .join("");
    }

    function initWordmarkAnimations() {
        const wordmarkElements = document.querySelectorAll(SELECTORS.wordmark);

        gsap.set(wordmarkElements, { opacity: 0 });
        gsap.to(wordmarkElements, {
            opacity: 1,
            duration: TIMING.slow,
            stagger: 0.2,
            ease: EASE.out,
        });

        initWordmarkScramble();
    }

    function initWordmarkScramble() {
        const containers = findWordmarkContainers();

        containers.forEach(function (container) {
            const letterGroups = container.querySelectorAll(
                SELECTORS.wordmarkTitle
            );
            if (letterGroups.length !== 4) return;

            const originalTexts = Array.from(letterGroups).map(function (el) {
                return el.textContent.trim();
            });

            var scrambleInterval = null;

            container.addEventListener("mouseenter", function () {
                if (scrambleInterval) clearInterval(scrambleInterval);

                letterGroups.forEach(function (group, i) {
                    group.textContent = generateScrambledText(originalTexts[i]);
                });

                scrambleInterval = setInterval(function () {
                    letterGroups.forEach(function (group, i) {
                        group.textContent = generateScrambledText(
                            originalTexts[i]
                        );
                    });
                }, SCRAMBLE_INTERVAL_MS);
            });

            container.addEventListener("mouseleave", function () {
                if (scrambleInterval) {
                    clearInterval(scrambleInterval);
                    scrambleInterval = null;
                }

                letterGroups.forEach(function (group, index) {
                    const original = originalTexts[index];

                    gsap.to(
                        {},
                        {
                            duration: TIMING.medium,
                            ease: EASE.out,
                            delay: index * 0.06,
                            onUpdate: function () {
                                const progress = this.progress();
                                const revealLength = Math.floor(
                                    original.length * progress
                                );
                                const revealed = original.substring(
                                    0,
                                    revealLength
                                );
                                const remaining =
                                    original.substring(revealLength);
                                group.textContent =
                                    revealed + generateScrambledText(remaining);
                            },
                            onComplete: function () {
                                group.textContent = original;
                            },
                        }
                    );
                });
            });
        });
    }

    // ============================================
    // INVERT ON HOVER
    // ============================================

    const INVERT_DURATION = 0.22;

    function initInvertOnHover(selector) {
        selector = selector || ".invert-on-hover";
        if (typeof gsap === "undefined") return;

        document.querySelectorAll(selector).forEach(function (el) {
            el.style.willChange = "filter, opacity";

            var enter = function () {
                gsap.to(el, {
                    filter: "invert(1) grayscale(1)",
                    duration: INVERT_DURATION,
                    ease: EASE.smooth,
                });
            };

            var leave = function () {
                gsap.to(el, {
                    filter: "invert(0) grayscale(0)",
                    duration: INVERT_DURATION,
                    ease: EASE.smooth,
                });
            };

            el.addEventListener("mouseenter", enter);
            el.addEventListener("mouseleave", leave);
            el.addEventListener("focusin", enter);
            el.addEventListener("focusout", leave);

            el._invertOnHoverCleanup = function () {
                el.removeEventListener("mouseenter", enter);
                el.removeEventListener("mouseleave", leave);
                el.removeEventListener("focusin", enter);
                el.removeEventListener("focusout", leave);
            };
        });
    }

    // ============================================
    // INITIALIZATION
    // ============================================

    function initializeApp() {
        // Page transitions - must run first to prevent FOUC
        initContentFadeIn();
        initSimplePageTransitions();

        // Interactive animations
        initMenuAnimations();
        initWordmarkAnimations();
        initInvertOnHover();
    }

    // Run immediately if DOM is ready, otherwise wait for DOMContentLoaded
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initializeApp);
    } else {
        initializeApp();
    }
})();
