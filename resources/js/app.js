import './bootstrap';

import Alpine from 'alpinejs';

window.Echo.private('orders')
    .listen('.order.created', function(event) {
        alert(`New order created: ${event.order.number}`);
        console.log(event);
    });

window.Echo.private(`Notifications.${userId}`)
    .notification(function(e) {
        var count = Number($('#unread').text());
        count++;
        $('.unread').text(count);
          $('#notifications').prepend(`
                 <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i>
                    <b>*</b>
                    ${ e.title }
                    <span class="float-right text-muted text-sm">${e.time}</span>
                </a>
                <div class="dropdown-divider"></div>
          `);
          alert(e.title);
    })

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
