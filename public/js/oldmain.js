/*<!-- Create a container for the 3D scene
<div id="neoWScene" style="width: 100%; height: 500px;"></div>-->

<!-- Embed NeoW data as a JSON object -->
{{--<script type="application/json" id="neoWData">
    {!! json_encode($data) !!}
</script>--}}

{{--<script type="module" src="{{ asset('js/main.js') }}"></script>--}}*/

import * as THREE from 'three';

// Create a scene
const scene = new THREE.Scene();

// Create a camera
const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
camera.position.z = 15;

// Create a renderer
const renderer = new THREE.WebGLRenderer();
renderer.setSize(window.innerWidth, window.innerHeight);
document.body.appendChild(renderer.domElement);
// Specify the rendering container
//const container = document.getElementById('neoWScene');
//container.appendChild(renderer.domElement);

// Create a blue material for the Earth
const earthGeometry = new THREE.SphereGeometry(3, 64, 64); // Smaller Earth sphere
const earthMaterial = new THREE.MeshPhongMaterial({ color: 0x0077ff, shininess: 20 });
const earthSphere = new THREE.Mesh(earthGeometry, earthMaterial);
scene.add(earthSphere);

// Create orbiting objects (smaller and white) with elliptical orbits
const numOrbitObjects = 300;
const orbitingObjects = [];

for (let i = 0; i < numOrbitObjects; i++) {
    const orbitObjectGeometry = new THREE.SphereGeometry(0.05, 16, 16); // Smaller size (0.05)
    const orbitObjectMaterial = new THREE.MeshPhongMaterial({ color: 0xffffff, shininess: 10 });
    const orbitObject = new THREE.Mesh(orbitObjectGeometry, orbitObjectMaterial);

    // Set orbital parameters for elliptical orbits
    const semiMajorAxis = 6 + Math.random() * 3; // Adjust the orbit radius
    const semiMinorAxis = 2 + Math.random() * 1; // Adjust the minor axis for an elliptical orbit
    const inclination = Math.random() * Math.PI * 2;
    const ascendingNode = Math.random() * Math.PI * 2;
    const argumentOfPerihelion = Math.random() * Math.PI * 2;
    const orbitalSpeed = 0.01 / semiMajorAxis;
    const angle = Math.random() * Math.PI * 2;

    const x = semiMajorAxis * Math.cos(ascendingNode) * Math.cos(argumentOfPerihelion + angle) -
        semiMinorAxis * Math.sin(ascendingNode) * Math.sin(argumentOfPerihelion + angle);
    const y = semiMajorAxis * Math.sin(ascendingNode) * Math.cos(argumentOfPerihelion + angle) +
        semiMinorAxis * Math.cos(ascendingNode) * Math.sin(argumentOfPerihelion + angle);
    const z = semiMajorAxis * Math.sin(argumentOfPerihelion + angle) * Math.cos(inclination);

    orbitObject.position.set(x, y, z);

    orbitObject.userData = { orbitalSpeed, semiMajorAxis, semiMinorAxis, inclination, ascendingNode, argumentOfPerihelion, meanAnomaly: Math.random() * Math.PI * 2 };
    orbitingObjects.push(orbitObject);
    scene.add(orbitObject);
}

// Add ambient light
const ambientLight = new THREE.AmbientLight(0x404040);
scene.add(ambientLight);

// Add a directional light
const directionalLight = new THREE.DirectionalLight(0xffffff, 0.5);
directionalLight.position.set(1, 1, 1);
scene.add(directionalLight);

// Animation loop
function animate() {
    requestAnimationFrame(animate);

    // Rotate the Earth sphere
    if (earthSphere) {
        earthSphere.rotation.y += 0.001;
    }

    // Update the positions of orbiting objects
    orbitingObjects.forEach((orbitObject) => {
        const { orbitalSpeed, semiMajorAxis, semiMinorAxis, inclination, ascendingNode, argumentOfPerihelion } = orbitObject.userData;
        const meanAnomaly = (orbitObject.userData.meanAnomaly || 0) + orbitalSpeed;

        const cosMA = Math.cos(meanAnomaly);
        const sinMA = Math.sin(meanAnomaly);

        const minRadius = 1; // Minimum radius to prevent objects from getting too close
        const r = Math.max(minRadius, (semiMajorAxis * semiMinorAxis) / Math.sqrt((semiMinorAxis * cosMA) ** 2 + (semiMajorAxis * sinMA) ** 2));

        const x = r * (Math.cos(ascendingNode) * Math.cos(argumentOfPerihelion + meanAnomaly) - Math.sin(ascendingNode) * Math.sin(argumentOfPerihelion + meanAnomaly) * Math.cos(inclination));
        const y = r * (Math.sin(ascendingNode) * Math.cos(argumentOfPerihelion + meanAnomaly) + Math.cos(ascendingNode) * Math.sin(argumentOfPerihelion + meanAnomaly) * Math.cos(inclination));
        const z = r * (Math.sin(argumentOfPerihelion + meanAnomaly) * Math.sin(inclination));

        orbitObject.position.set(x, y, z);
        orbitObject.userData.meanAnomaly = meanAnomaly;
    });

    renderer.render(scene, camera);
}

animate();
