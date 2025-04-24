document.addEventListener('DOMContentLoaded', () => {
    const loginBtn = document.getElementById('login-btn');
    const signupBtn = document.getElementById('signup-btn');
    const cartIcon = document.getElementById('cart-icon');
    const profileIcon = document.getElementById('profile-icon');
    const logoutBtn = document.getElementById('logout');
    const navbarLinks = document.querySelectorAll('.nav-links .nav-item a');
    const loginModal = document.getElementById('login-page');
    const signupModal = document.getElementById('signup-page');
    const allPages = document.querySelectorAll('div[id$="-page"]');

    // **Update Navbar UI Based on Login State**
    const updateNavbar = () => {
        fetch('session_status.php') // Endpoint to check session status
            .then((res) => res.json())
            .then((data) => {
                if (data.isLoggedIn) {
                    // sessionStorage.setItem('userId', data.userId); // Store user ID
                    cartIcon.style.display = 'inline-block';
                    profileIcon.style.display = 'inline-block';
                    loginBtn.style.display = 'none';
                    signupBtn.style.display = 'none';
                } else {
                    sessionStorage.removeItem('userId'); // Remove user ID
                    cartIcon.style.display = 'none';
                    profileIcon.style.display = 'none';
                    loginBtn.style.display = 'inline-block';
                    signupBtn.style.display = 'inline-block';
                }
            })
            .catch(console.error);
    };

    // **Page Navigation and Active Link Highlighting**
    const navigateToPage = (pageId) => {
        allPages.forEach((page) => {
            page.classList.remove('show'); // Hide all pages
        });

        const targetPage = document.getElementById(pageId);
        if (targetPage) {
            targetPage.classList.add('show'); // Show the selected page
        }

        // Highlight active link in navbar
        navbarLinks.forEach((link) => {
            link.parentElement.classList.remove('active');
            if (link.getAttribute('href') === `#${pageId}`) {
                link.parentElement.classList.add('active');
            }
        });
    };

    // **Login Button Click**
    loginBtn.addEventListener('click', (e) => {
        e.preventDefault();
        loginModal.classList.add('show'); // Show login modal
    });

    // **Signup Button Click**
    signupBtn.addEventListener('click', (e) => {
        e.preventDefault();
        signupModal.classList.add('show'); // Show signup modal
    });

    // **Handle Login Form Submission**
    const loginForm = document.querySelector('#login-page form');
    loginForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(loginForm);
    
        fetch('login.php', {
            method: 'POST',
            body: new FormData(loginForm),
        })
            .then((res) => res.json())
            .then((data) => {
                console.log(data);
                console.log(data.user_id);
                if (data.success) {
                    console.log(data.user_id);
                    sessionStorage.setItem('userId', data.user_id);
                    console.log(sessionStorage.getItem('userId'));
                    sessionStorage.setItem('username', data.username);
                    alert(data.message);
                    updateNavbar(); // Update UI
                    console.log(sessionStorage.getItem('userId'));
                    loginModal.classList.remove('show'); // Close the modal
                } else {
                    alert(`Login failed: ${data.message}`);
                }
            })
            .catch(console.error);
    });

    // **Handle Logout Button Click**
    logoutBtn.addEventListener('click', (e) => {
        e.preventDefault();
        fetch('logout.php', { method: 'POST' })
            .then(() => {
                alert('Logged out successfully!');
                updateNavbar();
            })
            .catch(console.error);
    });

    // **Handle Signup Form Submission**
    const signupForm = document.querySelector('#signup-page form');
    signupForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(signupForm);

        fetch('signup.php', {
            method: 'POST',
            body: formData,
        })
            .then((res) => res.text())
            .then((message) => {
                alert(message);
                // updateNavbar();
                signupModal.classList.remove('show');
            })
            .catch(console.error);
    });

    // **Close Modals When Clicking Outside**
    allPages.forEach((page) => {
        page.addEventListener('click', (e) => {
            if (e.target === page) {
                page.classList.remove('show'); // Close the modal
            }
        });
    });

});