import { Starfield } from "./dist/starfield.js";

const starfield = new Starfield({
    canvasId: "browse__bg",
    velocity: 0.1,
    acceleration: 0,
    rotationFactor: 0
});

starfield.setupScrollEffect();