import './bootstrap';

import Alpine from 'alpinejs';

window.Echo.private('orders')
    .listen('.order.created', function(event) {
        alert(`New order created: ${event.order.number}`);
        console.log(event);
    });

window.Echo.join('chat')
    .here(users => {
        console.log(users);
    }).joining(user => {
        $('#messages').append(`<div class="shadow-sm my-5 sm:rounded-lg">
            ${user.name}: joining!
        </div>`);
    }).leaving(user => {
        $('#messages').append(`<div class="shadow-sm my-5 sm:rounded-lg">
            ${user.name}: leaving!
        </div>`);
    }).listen('MessageSent', (e) => {
        addMessage(e);
    });

(function($){
    $('#chat-form').on('submit', function(e){
        e.preventDefault();
        $.post($(this).attr('action'), $(this).serialize(), function(res){
            $('#chat-form input').val('');
        });
    });
})(jQuery)

function addMessage(e){
    $('#messages').append(`<div class="shadow-sm my-5 sm:rounded-lg">
    ${e.sender.name}: ${e.message}</div>`);
}


window.Alpine = Alpine;

Alpine.start();
