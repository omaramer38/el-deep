import './bootstrap';
import Alpine from 'alpinejs';
import { initMotion } from './motion';

window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    initMotion();
});
