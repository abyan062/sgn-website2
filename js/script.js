// File: js/script.js
// JavaScript untuk interaksi website

// Wait for DOM to load
document.addEventListener('DOMContentLoaded', function() {
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== "#") {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            }
        });
    });
    
    // Add active class to current nav link
    const currentPage = window.location.pathname.split('/').pop();
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
    navLinks.forEach(link => {
        const linkPage = link.getAttribute('href');
        if (linkPage === currentPage) {
            link.classList.add('active');
        }
    });
    
    // Scroll to top button
    createScrollTopButton();
    
    // Form validation for contact form
    const contactForm = document.querySelector('.contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            const name = document.getElementById('name');
            const email = document.getElementById('email');
            const message = document.getElementById('message');
            let isValid = true;
            
            if (name && !name.value.trim()) {
                showError(name, 'Nama harus diisi');
                isValid = false;
            }
            
            if (email && !isValidEmail(email.value)) {
                showError(email, 'Email tidak valid');
                isValid = false;
            }
            
            if (message && !message.value.trim()) {
                showError(message, 'Pesan harus diisi');
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    }
    
    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });
    
    // Image error handler for book covers
    const bookCovers = document.querySelectorAll('.card-img-top, .book-detail-cover');
    bookCovers.forEach(img => {
        img.addEventListener('error', function() {
            this.src = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="200" height="250" viewBox="0 0 200 250"%3E%3Crect width="200" height="250" fill="%23667eea"/%3E%3Ctext x="100" y="125" text-anchor="middle" fill="white" font-family="Arial" font-size="14"%3ECover%3C/text%3E%3Ctext x="100" y="145" text-anchor="middle" fill="white" font-family="Arial" font-size="12"%3ENo Image%3C/text%3E%3C/svg%3E';
            this.style.objectFit = 'cover';
        });
    });
});

// Helper Functions
function isValidEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function showError(element, message) {
    element.classList.add('is-invalid');
    const feedback = element.nextElementSibling;
    if (feedback && feedback.classList.contains('invalid-feedback')) {
        feedback.textContent = message;
    } else {
        const div = document.createElement('div');
        div.className = 'invalid-feedback';
        div.textContent = message;
        element.parentNode.appendChild(div);
    }
    
    element.addEventListener('input', function() {
        element.classList.remove('is-invalid');
        const fb = element.nextElementSibling;
        if (fb && fb.classList.contains('invalid-feedback')) {
            fb.remove();
        }
    });
}

function createScrollTopButton() {
    const btn = document.createElement('button');
    btn.innerHTML = '<i class="fas fa-arrow-up"></i>';
    btn.className = 'scroll-top';
    btn.setAttribute('aria-label', 'Scroll to top');
    document.body.appendChild(btn);
    
    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            btn.style.display = 'flex';
        } else {
            btn.style.display = 'none';
        }
    });
    
    btn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}

// Filter Katalog dengan AJAX (optional enhancement)
function filterCatalog(kategori) {
    if (kategori) {
        window.location.href = 'katalog.php?kategori=' + kategori;
    } else {
        window.location.href = 'katalog.php';
    }
}

// Preview image before upload (untuk admin panel)
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById(previewId);
            if (preview) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}