/**
 * Embla Carousel initialization
 */

import EmblaCarousel from "embla-carousel";
import Fade from "embla-carousel-fade";
import { addDotBtnsAndClickHandlers } from "./EmblaCarouselDotButton";
import { addPrevNextBtnsClickHandlers } from "./EmblaCarouselArrowButtons";

const OPTIONS = {
    align: "start",
    loop: true,
    slidesToScroll: "auto",
    duration: 30,
    watchDrag: false,
};

const emblaNode = document.querySelector(".embla");

// Only initialize if carousel exists on page
if (emblaNode) {
    const viewportNode = emblaNode.querySelector(".embla__viewport");
    const dotsNode = emblaNode.querySelector(".embla__dots");
    const prevBtn = emblaNode.querySelector(".embla__button--prev");
    const nextBtn = emblaNode.querySelector(".embla__button--next");

    const emblaApi = EmblaCarousel(viewportNode, OPTIONS, [Fade()]);

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
}
