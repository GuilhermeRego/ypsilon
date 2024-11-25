document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('userSearch');
    const resultsContainer = document.getElementById('userResults');

    searchInput.addEventListener('input', function () {
        const query = this.value;

        if (query.length > 0) {
            fetch(`/home/search-users?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(users => {
                    resultsContainer.innerHTML = ''; // Clear previous results

                    if (users.length > 0) {
                        users.forEach(user => {
                            const li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = `${user.nickname} (${user.username})`;
                            resultsContainer.appendChild(li);
                        });
                    } else {
                        resultsContainer.innerHTML = '<li class="list-group-item">No users found</li>';
                    }
                })
                .catch(err => {
                    console.error('Error fetching user search results:', err);
                });
        } else {
            resultsContainer.innerHTML = '';
        }
    });
});