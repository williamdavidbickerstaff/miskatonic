document.addEventListener("DOMContentLoaded", function (event) {
    console.log("DOM loaded");

    //wait until images, links, fonts, stylesheets, and js is loaded
    window.addEventListener(
        "load",
        function (e) {
            //custom GSAP code goes here
            // This tween will rotate an element with a class of .my-element
            gsap.to(".my-element", {
                rotation: 360,
                duration: 2,
                ease: "bounce.out",
            });

            console.log("window loaded");
        },
        false
    );
});
