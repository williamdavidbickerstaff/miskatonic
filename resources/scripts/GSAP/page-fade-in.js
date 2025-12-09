// resources/scripts/GSAP/page-fade-in.js

export function initPageFadeIn() {
    // Set initial state - hide all content
    gsap.set("body", { opacity: 0 });

    // Fade in the entire page
    gsap.to("body", {
        opacity: 1,
        duration: 0.6,
        ease: "power2.out",
        delay: 0.1,
    });
}

// Alternative: Fade in specific sections with stagger
export function initSectionFadeIn() {
    // Target main content sections
    const sections = document.querySelectorAll(".grid, .mx-auto > div");

    gsap.set(sections, { opacity: 0, y: 20 });

    gsap.to(sections, {
        opacity: 1,
        y: 0,
        duration: 0.8,
        stagger: 0.15,
        ease: "power2.out",
    });
}

// Option 3: Fade in with more granular control
export function initContentFadeIn() {
    // Ensure page is hidden initially (header.php already sets this, but we ensure it)
    // Use visibility on html to prevent rendering, opacity on body for fade effect
    gsap.set("html", {
        visibility: "hidden",
        opacity: 0,
    });
    gsap.set("body", {
        opacity: 0,
    });
    gsap.set(".mx-auto", { opacity: 0 });

    // Create a timeline for sequential animations - start immediately
    const tl = gsap.timeline({ immediateRender: false });

    // First make the page visible and fade in both html and body
    // Start animation immediately with no delay
    tl.set("html", { visibility: "visible" });
    tl.to("html", {
        opacity: 1,
        duration: 0.3,
        ease: "power2.out",
        immediateRender: true,
    });
    tl.to(
        "body",
        {
            opacity: 1,
            duration: 0.3,
            ease: "power2.out",
            immediateRender: true,
        },
        "-=0.3"
    );

    // Then fade in the main container
    tl.to(
        ".mx-auto",
        {
            opacity: 1,
            duration: 0.4,
            ease: "power2.out",
        },
        "-=0.2"
    );

    // Then animate wordmark elements
    tl.from(
        "[data-wordmark]",
        {
            opacity: 0,
            y: 20,
            duration: 0.5,
            stagger: 0.1,
            ease: "power2.out",
        },
        "-=0.3"
    );

    // Finally animate the rest of the content
    tl.from(
        ".grid > div:not([data-wordmark])",
        {
            opacity: 0,
            y: 15,
            duration: 0.6,
            stagger: 0.08,
            ease: "power2.out",
        },
        "-=0.4"
    );
}

// Fade out animation for page transitions
export function initPageTransitions() {
    // Get all internal links
    const internalLinks = document.querySelectorAll(
        'a[href^="/"], a[href^="' + window.location.origin + '"]'
    );

    internalLinks.forEach((link) => {
        link.addEventListener("click", function (e) {
            const href = this.getAttribute("href");

            // Skip if it's a hash link (anchor on same page)
            if (href.startsWith("#")) return;

            // Skip if opening in new tab
            if (this.target === "_blank") return;

            // Skip if it's a modifier click (ctrl, cmd, shift)
            if (e.ctrlKey || e.metaKey || e.shiftKey) return;

            // Prevent default navigation
            e.preventDefault();

            // Create fade-out timeline
            const tl = gsap.timeline({
                onComplete: () => {
                    // Navigate to the new page after animation completes
                    window.location.href = href;
                },
            });

            // Fade out content in reverse order
            tl.to(".grid > div:not([data-wordmark])", {
                opacity: 0,
                y: -15,
                duration: 0.3,
                stagger: 0.05,
                ease: "power2.in",
            });

            tl.to(
                "[data-wordmark]",
                {
                    opacity: 0,
                    y: -10,
                    duration: 0.3,
                    stagger: 0.05,
                    ease: "power2.in",
                },
                "-=0.2"
            );

            tl.to(
                ".mx-auto",
                {
                    opacity: 0,
                    duration: 0.3,
                    ease: "power2.in",
                },
                "-=0.2"
            );
        });
    });
}

// Alternative: Simpler fade-out (faster)
export function initSimplePageTransitions() {
    const internalLinks = document.querySelectorAll(
        'a[href^="/"], a[href^="' + window.location.origin + '"]'
    );

    internalLinks.forEach((link) => {
        link.addEventListener("click", function (e) {
            const href = this.getAttribute("href");

            // Skip if it's a hash link, new tab, or modifier click
            if (
                href.startsWith("#") ||
                this.target === "_blank" ||
                e.ctrlKey ||
                e.metaKey ||
                e.shiftKey
            )
                return;

            e.preventDefault();

            // Fade out everything using both opacity and visibility
            // This ensures complete hiding before navigation
            const tl = gsap.timeline({
                onComplete: () => {
                    // Ensure html is hidden before navigation
                    gsap.set("html", { visibility: "hidden", opacity: 0 });
                    window.location.href = href;
                },
            });

            tl.to("body", {
                opacity: 0,
                duration: 0.4,
                ease: "power2.in",
            });
        });
    });
}
