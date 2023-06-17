import './bootstrap';

import Alpine from 'alpinejs';


window.Alpine = Alpine;

Alpine.start();


var channel = Echo.private(`App.Models.User.${userID}`);
// my-events.
// channel.listen('.my-event', function(data) {
channel.notification(function(data) {
    console.log(data);
    alert(data.body);
    alert(JSON.stringify(data));
});
