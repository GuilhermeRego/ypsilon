document.addEventListener('DOMContentLoaded', function () {
    const followButton = document.getElementById('followButton');

    if (followButton) {
        followButton.addEventListener('click', function () {
            const userId = followButton.getAttribute('data-user-id');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`/profile/${userId}/follow`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
            })
                .then(response => response.json())
                .then(data => {
                    if (data.message === 'Followed successfully') {
                        followButton.textContent = 'Unfollow';
                        followButton.classList.remove('btn-primary');
                        followButton.classList.add('btn-secondary');
                    } else if (data.message === 'Unfollowed successfully') {
                        followButton.textContent = 'Follow';
                        followButton.classList.remove('btn-secondary');
                        followButton.classList.add('btn-primary');
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    }
});
