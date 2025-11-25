import { Starfield } from "./dist/starfield.js";

const starfield = new Starfield({ canvasId: "landing-page-canvas", amountOfStars: 10_000 });

let isSpeedingUp = false;

function fadeOutAndNavigate() {
  if (!isSpeedingUp) {
    isSpeedingUp = true;

    starfield.speedFactor = 35;

    const content = document.getElementById("landing-page__content");
    if (content) {
      content.style.transition = "opacity 1.5s";
      content.style.opacity = "0";
    }

    setTimeout(() => {
      window.location.href = "/browse";
    }, 1500);
  }
}

starfield.setupFadeOutEffect(fadeOutAndNavigate);

document.querySelector(".landing-page__scroll").addEventListener("click", fadeOutAndNavigate);