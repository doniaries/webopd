import "./bootstrap";

// Import Flowbite for interactive components
import "flowbite";

import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';

// Initialize Alpine.js
window.Alpine = Alpine;
Alpine.plugin(intersect);
Alpine.start();
