import './bootstrap';

import Alpine from 'alpinejs';

window.Echo.private('orders')
    .listen('.order.created', function(event) {
        alert(`New order created: ${event.order.number}`);
        console.log(event);
    });

window.Alpine = Alpine;

Alpine.start();
