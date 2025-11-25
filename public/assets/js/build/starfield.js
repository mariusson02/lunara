import * as THREE from "three";

export class Starfield {
    constructor({
                    canvasId,
                    width = window.innerWidth,
                    height = window.innerHeight,
                    amountOfStars = 6_000,
                    velocity = 0.5,
                    acceleration = 0.005,
                    rotationFactor = 0.002,
                    decayFactor = 0.95,
                }) {
        this.canvas = document.getElementById(canvasId);
        if (!this.canvas) {
            console.error("Canvas with id " + canvasId + " not found");
            return;
        }

        this.renderer = new THREE.WebGLRenderer({ canvas: this.canvas, antialias: true });
        this.renderer.setSize(width, height);
        this.renderer.setClearColor(0x000000);
        this.renderer.setPixelRatio(window.devicePixelRatio);

        this.scene = new THREE.Scene();
        this.camera = new THREE.PerspectiveCamera(75, width / height, 10, 1000);
        this.camera.position.z = 5;
        this.camera.rotation.x = Math.PI / 2;

        this.starData = [];
        this.starGeo = null;
        this.stars = null;
        this.amountOfStars = amountOfStars;
        this.velocity = velocity;
        this.acceleration = acceleration;
        this.rotationFactor = rotationFactor;
        this.decayFactor = decayFactor;
        this.scrollVelocity = 0;
        this.lastScrollY = window.scrollY;
        this.speedFactor = 1;

        this.createStars();
        this.animate();

        window.addEventListener("resize", () => this.handleResize());
    }

    createStars() {
        const textureLoader = new THREE.TextureLoader();
        this.starGeo = new THREE.BufferGeometry();
        const starPositions = [];
        const starColors = [];
        const color = new THREE.Color();

        for (let i = 0; i < this.amountOfStars; i++) {
            const x = Math.random() * 600 - 300;
            const y = Math.random() * 600 - 300;
            const z = Math.random() * 600 - 300;
            starPositions.push(x, y, z);
            this.starData.push({
                velocity: this.velocity,
                acceleration: this.acceleration,
            });

            color.setHSL(Math.random(), 0.7, 0.8);
            starColors.push(color.r, color.g, color.b);
        }

        this.starGeo.setAttribute("position", new THREE.Float32BufferAttribute(starPositions, 3));
        this.starGeo.setAttribute("color", new THREE.Float32BufferAttribute(starColors, 3));

        const sprite = textureLoader.load(
            "assets/images/landing/circle.png",
            () => console.log("Texture loaded successfully"),
            undefined,
            (error) => console.error("Error loading texture:", error)
        );

        const starMaterial = new THREE.PointsMaterial({
            size: 0.3,
            vertexColors: true,
            transparent: true,
            blending: THREE.AdditiveBlending,
            map: sprite,
        });

        this.stars = new THREE.Points(this.starGeo, starMaterial);
        this.scene.add(this.stars);
    }

    animate() {
        const positions = this.starGeo.attributes.position.array;

        for (let i = 0; i < positions.length; i += 3) {
            const velocityIndex = i / 3;
            positions[i + 1] -= (this.starData[velocityIndex].velocity + this.scrollVelocity) * this.speedFactor;

            if (positions[i + 1] < -200) {
                positions[i + 1] = 200;
            }
        }

        this.scrollVelocity *= this.decayFactor;

        this.starGeo.attributes.position.needsUpdate = true;
        this.stars.rotation.y += this.rotationFactor;

        requestAnimationFrame(() => this.animate());
        this.renderer.render(this.scene, this.camera);
    }

    setupScrollEffect() {
        window.addEventListener("scroll", () => {
            const currentScrollY = window.scrollY;
            const scrollDelta = currentScrollY - this.lastScrollY;

            this.scrollVelocity += scrollDelta * 0.005;

            this.lastScrollY = currentScrollY;
        });
    }

    setupFadeOutEffect(onFadeOut) {
        window.addEventListener("scroll", () => {
            if (typeof onFadeOut === "function") {
                onFadeOut();
            }
        });
    }

    handleResize() {
        const width = window.innerWidth;
        const height = window.innerHeight;

        this.camera.aspect = width / height;
        this.camera.updateProjectionMatrix();
        this.renderer.setSize(width, height);
    }
}