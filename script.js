document.body.addEventListener('click', function (e) {
    if (e.target.closest('i')) {
        const input = e.target.previousElementSibling;
        e.target.classList.toggle('fa-eye-slash')
            ? input.setAttribute('type', 'password')
            : input.setAttribute('type', 'text');
    }
});
