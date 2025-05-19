document.querySelectorAll('.favorite-btn').forEach(button => {
    button.addEventListener('click', function () {
        const productId = this.dataset.productId;

        fetch(`/user/favorite/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'added') {
                this.textContent = '❤️';
            } else if (data.status === 'removed') {
                this.textContent = '🤍';
            }
        })
        .catch(error => console.error('Error:', error));
    });
});

