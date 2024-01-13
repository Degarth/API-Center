
import * as THREE from 'three';
// Get the data from the script tag
var data = JSON.parse(document.getElementById("neoWData").innerHTML);

// Find the container element by its ID
const container = document.getElementById('neoWScene');
const containerWidth = container.clientWidth;
const containerHeight = container.clientHeight;
const aspectRatio = containerWidth / containerHeight;

// Create a scene, camera, and renderer
var scene = new THREE.Scene();
var camera = new THREE.PerspectiveCamera(75, aspectRatio, 0.1, 1000);




// Create a renderer and set its size to match the container's size
const renderer = new THREE.WebGLRenderer();
renderer.setSize(container.clientWidth, container.clientHeight);

// Append the renderer to the container
container.appendChild(renderer.domElement);

var earthScaleFactor = 0.05; // Adjust this value as needed
// The actual radius of the Earth in kilometers
var earthRadiusInKm = 6371;
// Create a sphere material for Earth with procedural texturing
/*const earthMaterial = new THREE.MeshPhongMaterial({
    map: createEarthTexture(), // Use a custom function to create a procedural Earth texture
    shininess: 25,             // Adjust shininess as needed
});

// Function to create a procedural Earth texture
function createEarthTexture() {
    const canvas = document.createElement('canvas');
    canvas.width = 1024;
    canvas.height = 512;
    const context = canvas.getContext('2d');

    // Create a gradient-based texture to simulate Earth's surface
    const gradient = context.createRadialGradient(
        canvas.width / 2,
        canvas.height / 2,
        0,
        canvas.width / 2,
        canvas.height / 2,
        canvas.width / 2
    );
    gradient.addColorStop(0.5, 'blue');  // Ocean color
    gradient.addColorStop(0.3, 'green'); // Land color
    gradient.addColorStop(0.05, 'white'); // Snow/ice color
    context.fillStyle = gradient;
    context.fillRect(0, 0, canvas.width, canvas.height);

    // Create a texture from the canvas
    const texture = new THREE.CanvasTexture(canvas);
    return texture;
}*/

// Load the Earth texture map
const textureLoader = new THREE.TextureLoader();
const earthTexture = textureLoader.load('../js/earth.png'); // Check the path

// Create a sphere material with the Earth texture
const earthMaterial = new THREE.MeshPhongMaterial({
    map: earthTexture,
    shininess: 20,
});

// Create a sphere to represent the earth
var earthGeometry = new THREE.SphereGeometry((earthRadiusInKm * earthScaleFactor)/200, 32, 32);
//var earthMaterial = new THREE.MeshBasicMaterial({color: 0x0000ff});
var earth = new THREE.Mesh(earthGeometry, earthMaterial);
scene.add(earth);

const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
directionalLight.position.set(1, -1, 3);
scene.add(directionalLight);

// Create an array to store the asteroids
var asteroids = [];

// Loop through the data and create a sphere for each asteroid
for (var i = 0; i < data.length; i++) {
    var asteroid = data[i];
    // Get the diameter and color of the asteroid
    var diameter = (parseFloat(asteroid.estimated_diameter_min) + parseFloat(asteroid.estimated_diameter_max)) / 2;
    var color = asteroid.is_potentially_hazardous_asteroid == "<span style=\"color:lightgreen\">NO</span>" ? 0xffffff : 0xff0000;
    // Create a sphere geometry and material for the asteroid
    var asteroidGeometry = new THREE.SphereGeometry(diameter/100, 16, 16);
    var asteroidMaterial = new THREE.MeshBasicMaterial({color: color});
    // Create a mesh for the asteroid and add it to the scene
    var asteroidMesh = new THREE.Mesh(asteroidGeometry, asteroidMaterial);
    scene.add(asteroidMesh);

    // Create an HTML element for the label
    var label = document.createElement('div');
    label.style.position = 'absolute';
    label.style.width = '100';
    label.style.height = '100';
    label.innerHTML = asteroid.name;
    label.style.display = 'none'; // Initially hide the labels
    label.style.left = '0px';     // Set an initial left position within the container
    label.style.top = '0px';
    document.body.appendChild(label);
    // Store the asteroid mesh and orbital data in the asteroids array
    asteroids.push({
        mesh: asteroidMesh,
        orbit_id: asteroid.orbital_data.orbit_id,
        eccentricity: asteroid.orbital_data.eccentricity,
        semi_major_axis: asteroid.orbital_data.semi_major_axis,
        inclination: asteroid.orbital_data.inclination,
        ascending_node_longitude: asteroid.orbital_data.ascending_node_longitude,
        orbital_period: asteroid.orbital_data.orbital_period,
        perihelion_distance: asteroid.orbital_data.perihelion_distance,
        perihelion_argument: asteroid.orbital_data.perihelion_argument,
        aphelion_distance: asteroid.orbital_data.aphelion_distance,
        perihelion_time: asteroid.orbital_data.perihelion_time,
        mean_anomaly: asteroid.orbital_data.mean_anomaly,
        mean_motion: asteroid.orbital_data.mean_motion,
        label: label,
    });
}

// Set the camera position and look at the earth
camera.position.z = 20;
camera.lookAt(earth.position);

// Create a function to update the position of each asteroid based on its orbital data
function updateAsteroids() {
    // Loop through the asteroids array
    for (var i = 0; i < asteroids.length; i++) {
        var asteroid = asteroids[i];
        // Get the current time in seconds since epoch
        var timeScale = 0.5;
        var time = Date.now() / 1000 * timeScale;
        // Calculate the mean anomaly at the current time using Kepler's equation
        var meanAnomaly = ((asteroid.mean_motion * (time - parseFloat(asteroid.perihelion_time))) + parseFloat(asteroid.mean_anomaly)) % (2 * Math.PI);
        //console.log(((asteroid.mean_motion * (time - asteroid.perihelion_time)) + parseFloat(asteroid.mean_anomaly)));
        // Use Newton's method to solve for the eccentric anomaly
        var eccentricAnomaly = meanAnomaly;
        for (var j = 0; j < 10; j++) {
            eccentricAnomaly = eccentricAnomaly - (eccentricAnomaly - parseFloat(asteroid.eccentricity) * Math.sin(eccentricAnomaly) - meanAnomaly) / (1 - parseFloat(asteroid.eccentricity) * Math.cos(eccentricAnomaly));
        }
        // Calculate the true anomaly using the eccentric anomaly
        var trueAnomaly = Math.atan2(Math.sqrt(1 - Math.pow(parseFloat(asteroid.eccentricity), 2)) * Math.sin(eccentricAnomaly), Math.cos(eccentricAnomaly) - parseFloat(asteroid.eccentricity));
        // Calculate the distance from the sun using the true anomaly and the semi-major axis
        var distance = asteroid.semi_major_axis * (1 - Math.pow(parseFloat(asteroid.eccentricity), 2)) / (1 + parseFloat(asteroid.eccentricity) * Math.cos(trueAnomaly));
        // Convert the polar coordinates to cartesian coordinates using the inclination, ascending node longitude, and perihelion argument
        var x = (distance*10) * (Math.cos(parseFloat(asteroid.ascending_node_longitude)) * Math.cos(trueAnomaly + parseFloat(asteroid.perihelion_argument)) - Math.sin(parseFloat(asteroid.ascending_node_longitude)) * Math.sin(trueAnomaly + parseFloat(asteroid.perihelion_argument)) * Math.cos(parseFloat(asteroid.inclination)));
        var y = (distance*10) * (Math.sin(parseFloat(asteroid.ascending_node_longitude)) * Math.cos(trueAnomaly + parseFloat(asteroid.perihelion_argument)) + Math.cos(parseFloat(asteroid.ascending_node_longitude)) * Math.sin(trueAnomaly + parseFloat(asteroid.perihelion_argument)) * Math.cos(parseFloat(asteroid.inclination)));
        var z = (distance*10) * (Math.sin(trueAnomaly + parseFloat(asteroid.perihelion_argument)) * Math.sin(parseFloat(asteroid.inclination)));
        console.log(Math.cos(parseFloat(asteroid.ascending_node_longitude)) * Math.cos(trueAnomaly + parseFloat(asteroid.perihelion_argument)));
        // Set the position of the asteroid mesh
        if (isNaN(x) || isNaN(y) || isNaN(z)) {
            console.log('Invalid position calculated for asteroid with orbit_id:', asteroid.orbit_id);
            console.log('Orbital data:', asteroid);
            console.log('Calculated variables: meanAnomaly', meanAnomaly, 'eccentricAnomaly', eccentricAnomaly, 'trueAnomaly', trueAnomaly, 'distance', distance);
        } else {
            asteroid.mesh.position.set(x, y, z);
        }

    }
}

// Create a function to animate the scene
function animate() {
    // Request the next animation frame
    requestAnimationFrame(animate);
    // Update the position of the asteroids
    updateAsteroids();

    // Update the position of each label
    for (var i = 0; i < asteroids.length; i++) {
        var asteroid = asteroids[i];
        var vector = new THREE.Vector3();

        // Get the position of the asteroid in screen coordinates
        vector.setFromMatrixPosition(asteroid.mesh.matrixWorld);
        vector.project(camera);

        // Convert the normalized position into pixel coordinates
        var x = (vector.x * 0.5 + 0.5) * containerWidth;
        var y = (vector.y * -0.5 + 0.5) * containerHeight;

        // Check if the asteroid is within the container
        if (x >= 0 && x <= containerWidth && y >= 0 && y <= containerHeight) {
            // Show the label and position it accordingly
            asteroid.label.style.display = 'block';
            asteroid.label.style.left = x+130 + 'px';
            asteroid.label.style.top = y+120 + 'px';
        } else {
            // Hide the label if the asteroid is outside the container
            asteroid.label.style.display = 'none';
        }
    }


    // Render the scene
    renderer.render(scene, camera);
}

// Start the animation
animate();
