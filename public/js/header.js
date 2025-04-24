document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('searchForm');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        const query = document.getElementById('queryInput').value.trim();
        const category = document.getElementById('category').value;

        if (!query && !category) {
            e.preventDefault();
        }
    });
});
