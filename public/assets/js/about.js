import { Starfield } from "./dist/starfield.js";

const starfield = new Starfield({
    canvasId: "aboutCanvas",
    amountOfStars: 1000,
    velocity: 0.1,
    acceleration: 0,
    rotationFactor: 0
});

document.addEventListener("DOMContentLoaded", () => {
    const videoElement = document.querySelector(".about__media");
    const sections = document.querySelectorAll("section");

    const videoPositions = {
        about: { transform: "translateX(15rem) translateY(7.5rem) scale(0.55)", justify: "flex-end" },
        mission: { transform: "translateX(-5rem) translateY(5rem) scale(0.65)", justify: "flex-start" },
        chooseUs: { transform: "translateX(0px) translateY(10rem) scale(0.5)", justify: "center" },
    };

    const updateVideoPositions = () => {
        if (window.innerWidth < 900) {
            videoPositions.about.transform = "translateX(7.5rem) translateY(12rem) scale(0.3)";
            videoPositions.mission.transform = "translateX(-10rem) translateY(7.5rem) scale(0.4)";
            videoPositions.chooseUs.transform = "translateX(7rem) translateY(10rem) scale(0.35)";
        } else {
            videoPositions.about.transform = "translateX(15rem) translateY(7.5rem) scale(0.55)";
            videoPositions.mission.transform = "translateX(-5rem) translateY(5rem) scale(0.65)";
            videoPositions.chooseUs.transform = "translateX(0px) translateY(10rem) scale(0.5)";
        }
    };

    const updateVideoForSection = (sectionId, sectionOffsetTop) => {
        videoElement.style.opacity = 0;
        videoElement.style.transform = videoPositions[sectionId].transform;
        videoElement.style.justifyContent = videoPositions[sectionId].justify;
        videoElement.style.top = `${sectionOffsetTop - 100}px`;

        // Reintroduce opacity with a fade effect
        setTimeout(() => (videoElement.style.opacity = 1), 500);
    };

    // Intersection Observer for section visibility
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const sectionId = entry.target.id;
                    updateVideoForSection(sectionId, entry.target.offsetTop);
                }
            });
        },
        {
            threshold: 0.2,
        }
    );

    sections.forEach((section) => observer.observe(section));

    // Handle window resize events
    window.addEventListener("resize", () => {
        updateVideoPositions(); // Update the videoPositions for the new viewport size

        // Update the video for the currently visible section
        const activeSection = Array.from(sections).find((section) => {
            const rect = section.getBoundingClientRect();
            return rect.top >= 0 && rect.top < window.innerHeight;
        });

        if (activeSection) {
            updateVideoForSection(activeSection.id, activeSection.offsetTop);
        }
    });

    // Initialize positions for the first load
    updateVideoPositions();
});
