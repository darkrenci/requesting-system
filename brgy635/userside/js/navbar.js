

// Add and remove border bottom when focused
const list = document.querySelectorAll('li');

list.forEach(list => {
    // add the active class when focused
    list.addEventListener('focus', () => {
        list.classList.add('active');
    });
    // remove the active class when not in focus
    list.addEventListener('blur', () => {
        list.classList.remove('active');
    });
});


