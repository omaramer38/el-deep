import Alpine from 'alpinejs';
import Sortable from 'sortablejs';

window.Alpine = Alpine;
window.Sortable = Sortable;

// Notification Toast Dispatcher
window.eldeebNotify = function (message, type = 'success') {
    window.dispatchEvent(new CustomEvent('notify', {
        detail: { message, type }
    }));
};

Alpine.start();
