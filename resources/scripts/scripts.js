/**
 * Embla Carousel initialization
 * Uses globally loaded EmblaCarousel from CDN
 */

(function () {
    "use strict";

    const OPTIONS = {
        align: "start",
        loop: true,
        slidesToScroll: "auto",
        duration: 30,
        watchDrag: false,
    };

    const emblaNode = document.querySelector(".embla");

    // Only initialize if carousel exists on page
    if (!emblaNode) return;

    const viewportNode = emblaNode.querySelector(".embla__viewport");
    const dotsNode = emblaNode.querySelector(".embla__dots");
    const prevBtn = emblaNode.querySelector(".embla__button--prev");
    const nextBtn = emblaNode.querySelector(".embla__button--next");

    // Use globally loaded EmblaCarousel and EmblaCarouselFade from CDN
    const emblaApi = EmblaCarousel(viewportNode, OPTIONS, [
        EmblaCarouselFade(),
    ]);

    // Dot buttons functionality
    function addDotBtnsAndClickHandlers(emblaApi, dotsNode) {
        let dotNodes = [];

        const addDotBtnsWithClickHandlers = () => {
            dotsNode.innerHTML = emblaApi
                .scrollSnapList()
                .map(() => '<button class="embla__dot" type="button"></button>')
                .join("");

            const scrollTo = (index) => {
                emblaApi.scrollTo(index);
            };

            dotNodes = Array.from(dotsNode.querySelectorAll(".embla__dot"));
            dotNodes.forEach((dotNode, index) => {
                dotNode.addEventListener("click", () => scrollTo(index), false);
            });
        };

        const toggleDotBtnsActive = () => {
            const previous = emblaApi.previousScrollSnap();
            const selected = emblaApi.selectedScrollSnap();
            dotNodes[previous].classList.remove("embla__dot--selected");
            dotNodes[selected].classList.add("embla__dot--selected");
        };

        emblaApi
            .on("init", addDotBtnsWithClickHandlers)
            .on("reInit", addDotBtnsWithClickHandlers)
            .on("init", toggleDotBtnsActive)
            .on("reInit", toggleDotBtnsActive)
            .on("select", toggleDotBtnsActive);

        return () => {
            dotsNode.innerHTML = "";
        };
    }

    // Arrow buttons functionality
    function addPrevNextBtnsClickHandlers(emblaApi, prevBtn, nextBtn) {
        const scrollPrev = () => emblaApi.scrollPrev();
        const scrollNext = () => emblaApi.scrollNext();

        const togglePrevNextBtnsState = () => {
            if (emblaApi.canScrollPrev()) {
                prevBtn.removeAttribute("disabled");
            } else {
                prevBtn.setAttribute("disabled", "disabled");
            }

            if (emblaApi.canScrollNext()) {
                nextBtn.removeAttribute("disabled");
            } else {
                nextBtn.setAttribute("disabled", "disabled");
            }
        };

        prevBtn.addEventListener("click", scrollPrev, false);
        nextBtn.addEventListener("click", scrollNext, false);

        emblaApi
            .on("init", togglePrevNextBtnsState)
            .on("select", togglePrevNextBtnsState)
            .on("reInit", togglePrevNextBtnsState);

        return () => {
            prevBtn.removeEventListener("click", scrollPrev, false);
            nextBtn.removeEventListener("click", scrollNext, false);
        };
    }

    // Initialize dots
    const removeDotBtnsAndClickHandlers = addDotBtnsAndClickHandlers(
        emblaApi,
        dotsNode
    );

    // Initialize arrow buttons
    const removePrevNextBtnsClickHandlers = addPrevNextBtnsClickHandlers(
        emblaApi,
        prevBtn,
        nextBtn
    );

    // Cleanup on destroy
    emblaApi.on("destroy", () => {
        removeDotBtnsAndClickHandlers();
        removePrevNextBtnsClickHandlers();
    });
})();
