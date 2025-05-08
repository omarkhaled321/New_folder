const menuItems = document.querySelectorAll('.menu-item1');
const messagesNotification = document.querySelector('#messages-notifications1');
const messages = document.querySelector('.messages1');
const message = messages.querySelectorAll('.message1');
const messageSearch = document.querySelector('#message-search');

// Remove active class from all menu items
const changeActiveItem = () => {
    menuItems.forEach(item => {
        item.classList.remove('active1');
    });
};

// Add event listener to menu items
menuItems.forEach(item => {
    item.addEventListener('click', () => {
        changeActiveItem();
        item.classList.add('active1');

        if (item.id !== 'notifications') {
            document.querySelector('.notifications-popup1').style.display = 'none';
        } else {
            document.querySelector('.notifications-popup1').style.display = 'block';
            document.querySelector('#notifications .notification-count1').style.display = 'none';
        }
    });
});

// Search messages
const searchMessage = () => {
    const val = messageSearch.value.toLowerCase();
    message.forEach(chat => {
        let name = chat.querySelector('h5').textContent.toLowerCase();
        if (name.indexOf(val) !== -1) {
            chat.style.display = 'flex';
        } else {
            chat.style.display = 'none';
        }
    });
};

messageSearch.addEventListener('keyup', searchMessage);

// Message notification click event
messagesNotification.addEventListener('click', () => {
    messages.style.boxShadow = '0 0 1rem var(--color-primary)';
    messagesNotification.querySelector('.notification-count1').style.display = 'none';
    setTimeout(() => {
        messages.style.boxShadow = 'none';
    }, 2000);
});
