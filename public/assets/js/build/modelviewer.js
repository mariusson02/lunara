import * as THREE from "three";
import { GLTFLoader } from "three/addons/loaders/GLTFLoader.js";

export class ModelViewer {
    constructor(canvasId) {
        this.referenceScale = 3.356206572005804;
        this.canvas = document.getElementById(canvasId);
        this.renderer = new THREE.WebGLRenderer({ canvas: this.canvas, antialias: true });
        this.scene = new THREE.Scene();
        this.camera = new THREE.PerspectiveCamera(75, this.canvas.clientWidth / this.canvas.clientHeight, 0.1, 1000);
        this.scale = this.canvas.dataset.scale;

        this.animationStates = [
            { position: { x: 0, y: -0.6, z: 1.2 }, lookAt: { x: 0, y: 4, z: 0 } },
            { position: { x: 0, y: 0, z: 3 }, lookAt: { x: -1.5, y: 0, z: 0 } },
            { position: { x: 0, y: 0, z: 1.1 }, lookAt: { x: 0, y: 0, z: 0 } },
            { position: { x: 0, y: 0, z: 4 }, lookAt: { x: 3, y: 0, z: -0.5 } }
        ];

        if (window.innerWidth < 900) {
            this.animationStates[3].lookAt.x = 0;
            this.animationStates[3].lookAt.z = 0;
        }

        this.mesh = null;
        this.scrollProgress = 0;
        this.init();
    }

    init() {
        this.renderer.setSize(this.canvas.clientWidth, this.canvas.clientHeight);
        this.renderer.setClearColor(0x000000);
        this.renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        this.renderer.shadowMap.enabled = true;
        this.renderer.shadowMap.type = THREE.PCFSoftShadowMap;

        this.camera.position.set(
            this.animationStates[0].position.x,
            this.animationStates[0].position.y,
            this.animationStates[0].position.z
        );
        this.camera.lookAt(
            this.animationStates[0].lookAt.x,
            this.animationStates[0].lookAt.y,
            this.animationStates[0].lookAt.z
        );

        const ambient = new THREE.AmbientLight(0xffffff, 0.05);
        this.scene.add(ambient);

        const light = new THREE.DirectionalLight(0xffffff, 1);
        light.position.set(15, 5, 10);
        this.scene.add(light);

        const pointLight = new THREE.PointLight(0xffffff, 0.8);
        pointLight.position.set(5, 5, 5);
        this.scene.add(pointLight);

        const hemisphereLight = new THREE.HemisphereLight(0xffffff, 0x444444, 0.5);
        this.scene.add(hemisphereLight);

        window.addEventListener('resize', () => this.resize());
        window.addEventListener('scroll', () => {
            this.updateScrollProgress();
            this.updateCanvasPosition();
        });
        this.animate();
    }

    resize() {
        const width = this.canvas.clientWidth;
        const height = this.canvas.clientHeight;

        this.camera.aspect = width / height;
        this.camera.updateProjectionMatrix();
        this.renderer.setSize(width, height);
    }

    loadModel(path) {
        const loader = new GLTFLoader().setPath(path);
        loader.load(
            "scene.gltf",
            (gltf) => {
                this.mesh = gltf.scene;

                this.mesh.traverse((child) => {
                    if (child.isMesh) {
                        child.castShadow = true;
                        child.receiveShadow = true;
                    }
                });

                this.mesh.scale.set(this.scale, this.scale, this.scale);
                this.scene.add(this.mesh);
            },
            (xhr) => {
                console.log(`Loading model: ${(xhr.loaded / xhr.total) * 100}%`);
            },
            (error) => {
                console.error("Error loading model:", error);
            }
        );
    }

    updateScrollProgress() {
        const main = document.querySelector('main');
        const footer = document.querySelector('footer');
        const mainRect = main.getBoundingClientRect();
        const footerRect = footer.getBoundingClientRect();

        const scrollY = -mainRect.top;
        const mainHeight = mainRect.height - window.innerHeight;

        const isFooterVisible = footerRect.top <= window.innerHeight;

        if (isFooterVisible) {
            this.scrollProgress = 1;
        } else {
            this.scrollProgress = Math.min(Math.max(scrollY / mainHeight, 0), 1);
        }
    }

    updateCanvasPosition() {
        const footer = document.querySelector('footer');
        const footerRect = footer.getBoundingClientRect();

        if (footerRect.top <= window.innerHeight) {
            if (this.canvas.style.position !== 'absolute') {
                this.canvas.style.position = 'absolute';
                this.canvas.style.top = `${window.scrollY}px`;
            }
        } else {
            this.canvas.style.position = 'fixed';
            this.canvas.style.top = '0';
        }
    }

    interpolateCamera(progress) {
        const numStates = this.animationStates.length - 1;
        const currentIndex = Math.floor(progress * numStates);
        const t = (progress * numStates) % 1;

        const state1 = this.animationStates[currentIndex];
        const state2 = this.animationStates[Math.min(currentIndex + 1, numStates)];

        const position = {
            x: this.lerp(state1.position.x, state2.position.x, t),
            y: this.lerp(state1.position.y, state2.position.y, t),
            z: this.lerp(state1.position.z, state2.position.z, t)
        };
        const lookAt = {
            x: this.lerp(state1.lookAt.x, state2.lookAt.x, t),
            y: this.lerp(state1.lookAt.y, state2.lookAt.y, t),
            z: this.lerp(state1.lookAt.z, state2.lookAt.z, t)
        };

        this.camera.position.set(position.x, position.y, position.z);
        this.camera.lookAt(lookAt.x, lookAt.y, lookAt.z);
    }

    animate() {
        requestAnimationFrame(() => this.animate());
        if (this.mesh) {
            this.mesh.rotation.y += 0.002;
        }

        this.interpolateCamera(this.scrollProgress);
        this.renderer.render(this.scene, this.camera);
    }

    lerp(start, end, t) {
        return start + (end - start) * t;
    }
}