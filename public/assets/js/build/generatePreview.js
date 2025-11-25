import * as THREE from 'three';
import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';

const saveBtn = document.getElementById('save-btn');
const input = document.getElementById('inputPath');
const scaleInput = document.getElementById('inputScale');

const ASSETS_PATH = '../public/assets/models';

// Helper function to round a value to three decimal places.
function floorToThreeDecimals(value) {
    return Math.floor(value * 1000) / 1000;
}

// WebGL Renderer for rendering the scene.
const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
renderer.setSize(500, 500);
renderer.setClearColor(0x000000, 0);
document.body.appendChild(renderer.domElement);

const scene = new THREE.Scene();
const camera = new THREE.PerspectiveCamera(75, 1, 0.1, 1000);
camera.position.set(0, 0, 2); // Adjusted for better framing.

const ambient = new THREE.AmbientLight(0xffffff, 0.5);
scene.add(ambient);

const light = new THREE.DirectionalLight(0xffffff, 1.5);
light.position.set(15, 10, 10);
scene.add(light);

const loader = new GLTFLoader();

// Function to clear old objects from the scene (except camera and lights).
function clearScene() {
    while (scene.children.length > 2) { // Keep lights and camera.
        scene.remove(scene.children[2]);
    }
}

// Function to normalize and center the model with custom scaling.
function normalizeAndCenter(mesh, scale = 1) {
    const box = new THREE.Box3().setFromObject(mesh);
    const size = new THREE.Vector3();
    box.getSize(size);

    const center = new THREE.Vector3();
    box.getCenter(center);

    const maxDimension = Math.max(size.x, size.y, size.z);
    const normalizedScale = floorToThreeDecimals(scale / maxDimension);

    mesh.scale.set(normalizedScale, normalizedScale, normalizedScale);
    mesh.position.sub(center.multiplyScalar(normalizedScale));

    return mesh;
}

// Function to load and prepare a model for rendering.
function loadModel(path, scale = 1) {
    clearScene();

    loader.setPath(`${ASSETS_PATH}/${path}/`);
    loader.load(
        'scene.gltf',
        (gltf) => {
            const mesh = gltf.scene;

            // Normalize and center the model using the provided scale.
            const normalizedMesh = normalizeAndCenter(mesh, scale);

            scene.add(normalizedMesh);

            console.log('Model loaded and normalized successfully');
        },
        (xhr) => {
            console.log(`Loading: ${Math.round((xhr.loaded / xhr.total) * 100)}%`);
        },
        (error) => {
            console.error('Error loading model:', error);
        }
    );
}

// Function to continuously render the scene.
function render() {
    requestAnimationFrame(render);
    renderer.render(scene, camera);
}

render();

// Input event listener to load the model when the path changes.
input.addEventListener('change', () => {
    const modelPath = input.value.trim();
    const scaleValue = parseFloat(scaleInput.value) || 1;
    if (modelPath !== '') {
        loadModel(modelPath, scaleValue);
    } else {
        console.log('Please provide a valid directory name');
    }
});

// Input event listener for scale changes.
scaleInput.addEventListener('input', () => {
    const modelPath = input.value.trim();
    const scaleValue = parseFloat(scaleInput.value) || 1;
    if (modelPath !== '') {
        loadModel(modelPath, scaleValue); // Reload model with updated scale.
    } else {
        console.log('Please provide a valid directory name');
    }
});

// Save button event listener to save the rendered scene as an image.
saveBtn.addEventListener('click', () => {
    if (input.value.trim() === '') {
        console.log('Please provide a directory name');
        return;
    }
    renderer.render(scene, camera);
    const dataURL = renderer.domElement.toDataURL('image/png');

    const link = document.createElement('a');
    link.href = dataURL;
    link.download = 'thumbnail.png';
    link.click();

    const img = document.createElement('img');
    img.src = dataURL;
    document.body.appendChild(img);
});
