// ===== Griffin Quartz Website JavaScript =====

document.addEventListener('DOMContentLoaded', function() {
    // Mobile Menu Toggle
    initMobileMenu();

    // Countdown Timer
    initCountdown();

    // Form Handling
    initForms();

    // Smooth Scroll for anchor links
    initSmoothScroll();

    // Dropdown handling for mobile
    initDropdowns();

    // Reviews Carousel
    initReviewsCarousel();

    // Accordion
    initAccordion();

    // Lead Capture Popup
    initLeadPopup();
});

// ===== Mobile Menu =====
function initMobileMenu() {
    const toggle = document.getElementById('mobileMenuToggle');
    const nav = document.getElementById('mainNav');
    
    if (toggle && nav) {
        toggle.addEventListener('click', function() {
            nav.classList.toggle('active');
            toggle.classList.toggle('active');
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!nav.contains(e.target) && !toggle.contains(e.target)) {
                nav.classList.remove('active');
                toggle.classList.remove('active');
            }
        });
    }
}

// ===== Dropdown Menus (Mobile) =====
function initDropdowns() {
    const dropdowns = document.querySelectorAll('.dropdown');
    
    dropdowns.forEach(dropdown => {
        const link = dropdown.querySelector('.nav-link');
        
        link.addEventListener('click', function(e) {
            // Only prevent default on mobile (match CSS breakpoint)
            if (window.innerWidth <= 1024) {
                e.preventDefault();
                dropdown.classList.toggle('active');
                
                // Close other dropdowns
                dropdowns.forEach(other => {
                    if (other !== dropdown) {
                        other.classList.remove('active');
                    }
                });
            }
        });
    });
}

// ===== Countdown Timer =====
function initCountdown() {
    const countdown = document.getElementById('countdown');
    if (!countdown) return;
    
    // St. Patrick's Day Sale ends March 17, 2026
    const endDate = new Date('2026-03-17T23:59:59');
    
    function updateCountdown() {
        const now = new Date().getTime();
        const distance = endDate.getTime() - now;
        
        if (distance < 0) {
            // Sale ended
            document.getElementById('days').textContent = '00';
            document.getElementById('hours').textContent = '00';
            document.getElementById('minutes').textContent = '00';
            document.getElementById('seconds').textContent = '00';
            return;
        }
        
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        document.getElementById('days').textContent = String(days).padStart(2, '0');
        document.getElementById('hours').textContent = String(hours).padStart(2, '0');
        document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
        document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
    }
    
    // Update immediately and then every second
    updateCountdown();
    setInterval(updateCountdown, 1000);
}

// ===== Form Handling =====
function initForms() {
    // Quote Form (main contact form on homepage)
    const quoteForm = document.getElementById('quoteForm');
    if (quoteForm) {
        quoteForm.addEventListener('submit', function(e) {
            e.preventDefault();
            submitLead(this, 'quote', 'Quote request submitted successfully! We\'ll contact you shortly.');
        });
    }

    // Contact Form (contact page)
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            submitLead(this, 'contact', 'Message sent successfully! We\'ll be in touch soon.');
        });
    }

    // Product Quote Form (Cambria pages, etc.)
    const productQuoteForm = document.getElementById('productQuoteForm');
    if (productQuoteForm) {
        productQuoteForm.addEventListener('submit', function(e) {
            e.preventDefault();
            submitLead(this, 'product_quote', 'Quote request submitted! We\'ll contact you shortly.');
        });
    }

    // Newsletter Form
    const newsletterForm = document.getElementById('newsletterForm');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = newsletterForm.querySelector('input[type="email"]').value;
            submitLead(this, 'newsletter', 'Thank you for subscribing!', { email: email });
        });
    }

    // Hero Quote Form (service pages: kitchen, bathroom, outdoor, commercial)
    const heroQuoteForm = document.getElementById('heroQuoteForm');
    if (heroQuoteForm) {
        heroQuoteForm.addEventListener('submit', function(e) {
            e.preventDefault();
            submitLead(this, 'service_quote', 'Quote request submitted! We\'ll contact you shortly.');
        });
    }

    // Samples Request Form (color visualizer)
    const samplesForm = document.getElementById('samplesForm');
    if (samplesForm) {
        samplesForm.addEventListener('submit', function(e) {
            e.preventDefault();
            submitLead(this, 'samples_request', 'Sample request submitted! We\'ll ship your samples soon.');
        });
    }
}

function submitLead(form, formType, successMessage, additionalData = {}) {
    const formData = new FormData(form);
    const data = Object.fromEntries(formData);

    // Add metadata
    data.form_type = formType;
    data.page_url = window.location.href;
    data.page_title = document.title;

    // Merge additional data
    Object.assign(data, additionalData);

    // Show loading state
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn ? submitBtn.innerHTML : '';
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Sending...';
    }

    // Send to backend
    fetch('/api/submit-lead.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            showNotification(successMessage, 'success');
            form.reset();
        } else {
            showNotification(result.message || 'Something went wrong. Please try again.', 'error');
        }
    })
    .catch(error => {
        console.error('Form submission error:', error);
        showNotification('Something went wrong. Please try again.', 'error');
    })
    .finally(() => {
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    });
}

function showNotification(message, type = 'success') {
    // Remove existing notification
    const existing = document.querySelector('.notification');
    if (existing) existing.remove();
    
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <p>${message}</p>
        <button class="notification-close">&times;</button>
    `;
    
    // Add styles
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        background-color: ${type === 'success' ? '#10B981' : '#EF4444'};
        color: white;
        border-radius: 8px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        z-index: 9999;
        display: flex;
        align-items: center;
        gap: 1rem;
        animation: slideIn 0.3s ease;
    `;
    
    // Add keyframes if not already present
    if (!document.querySelector('#notification-styles')) {
        const style = document.createElement('style');
        style.id = 'notification-styles';
        style.textContent = `
            @keyframes slideIn {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            .notification-close {
                background: none;
                border: none;
                color: white;
                font-size: 1.5rem;
                cursor: pointer;
                padding: 0;
                line-height: 1;
            }
        `;
        document.head.appendChild(style);
    }
    
    document.body.appendChild(notification);
    
    // Close button
    notification.querySelector('.notification-close').addEventListener('click', () => {
        notification.remove();
    });
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

// ===== Smooth Scroll =====
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href === '#') return;
            
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                const headerHeight = document.querySelector('.header').offsetHeight;
                const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - headerHeight - 20;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
                
                // Close mobile menu if open
                document.getElementById('mainNav')?.classList.remove('active');
                document.getElementById('mobileMenuToggle')?.classList.remove('active');
            }
        });
    });
}

// ===== Intersection Observer for Animations =====
function initScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Observe elements with animation classes
    document.querySelectorAll('.feature-card, .review-card, .process-card, .blog-card').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
}

// Add animate-in styles
const animateStyles = document.createElement('style');
animateStyles.textContent = `
    .animate-in {
        opacity: 1 !important;
        transform: translateY(0) !important;
    }
`;
document.head.appendChild(animateStyles);

// Initialize scroll animations after page load
window.addEventListener('load', initScrollAnimations);

// ===== Header Scroll Effect =====
let lastScroll = 0;
window.addEventListener('scroll', () => {
    const header = document.querySelector('.header');
    const currentScroll = window.pageYOffset;

    if (currentScroll > 100) {
        header.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.1)';
    } else {
        header.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.05)';
    }

    lastScroll = currentScroll;
});

// ===== Reviews Carousel =====
function initReviewsCarousel() {
    const carousel = document.getElementById('reviewsCarousel');
    if (!carousel) return;

    const track = carousel.querySelector('.reviews-track');
    const cards = track.querySelectorAll('.review-card');
    const prevBtn = document.querySelector('.carousel-prev');
    const nextBtn = document.querySelector('.carousel-next');
    const dotsContainer = document.getElementById('carouselDots');
    const dots = dotsContainer ? dotsContainer.querySelectorAll('.dot') : [];

    let currentIndex = 0;
    let cardsToShow = getCardsToShow();
    let autoPlayInterval;

    function getCardsToShow() {
        if (window.innerWidth <= 768) return 1;
        if (window.innerWidth <= 1024) return 2;
        return 3;
    }

    function getCardWidth() {
        const card = cards[0];
        const style = window.getComputedStyle(card);
        const width = card.offsetWidth;
        const gap = parseInt(style.marginRight) || 24;
        return width + gap;
    }

    function updateCarousel() {
        const cardWidth = getCardWidth();
        const offset = currentIndex * cardWidth;
        track.style.transform = `translateX(-${offset}px)`;

        // Update dots
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentIndex);
        });

        // Update button states
        if (prevBtn) {
            prevBtn.style.opacity = currentIndex === 0 ? '0.5' : '1';
        }
        if (nextBtn) {
            const maxIndex = Math.max(0, cards.length - cardsToShow);
            nextBtn.style.opacity = currentIndex >= maxIndex ? '0.5' : '1';
        }
    }

    function goToSlide(index) {
        const maxIndex = Math.max(0, cards.length - cardsToShow);
        currentIndex = Math.max(0, Math.min(index, maxIndex));
        updateCarousel();
    }

    function nextSlide() {
        const maxIndex = Math.max(0, cards.length - cardsToShow);
        if (currentIndex < maxIndex) {
            currentIndex++;
        } else {
            currentIndex = 0;
        }
        updateCarousel();
    }

    function prevSlide() {
        if (currentIndex > 0) {
            currentIndex--;
        } else {
            const maxIndex = Math.max(0, cards.length - cardsToShow);
            currentIndex = maxIndex;
        }
        updateCarousel();
    }

    function startAutoPlay() {
        stopAutoPlay();
        autoPlayInterval = setInterval(nextSlide, 5000);
    }

    function stopAutoPlay() {
        if (autoPlayInterval) {
            clearInterval(autoPlayInterval);
        }
    }

    // Event listeners
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            prevSlide();
            stopAutoPlay();
            startAutoPlay();
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            nextSlide();
            stopAutoPlay();
            startAutoPlay();
        });
    }

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            goToSlide(index);
            stopAutoPlay();
            startAutoPlay();
        });
    });

    // Pause on hover
    carousel.addEventListener('mouseenter', stopAutoPlay);
    carousel.addEventListener('mouseleave', startAutoPlay);

    // Touch/swipe support
    let touchStartX = 0;
    let touchEndX = 0;

    carousel.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
        stopAutoPlay();
    }, { passive: true });

    carousel.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
        startAutoPlay();
    }, { passive: true });

    function handleSwipe() {
        const swipeThreshold = 50;
        const diff = touchStartX - touchEndX;

        if (diff > swipeThreshold) {
            nextSlide();
        } else if (diff < -swipeThreshold) {
            prevSlide();
        }
    }

    // Handle window resize
    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            cardsToShow = getCardsToShow();
            const maxIndex = Math.max(0, cards.length - cardsToShow);
            if (currentIndex > maxIndex) {
                currentIndex = maxIndex;
            }
            updateCarousel();
        }, 250);
    });

    // Initialize
    updateCarousel();
    startAutoPlay();
}

// ===== Accordion =====
function initAccordion() {
    const accordions = document.querySelectorAll('.accordion');

    accordions.forEach(accordion => {
        const items = accordion.querySelectorAll('.accordion-item');

        items.forEach(item => {
            const header = item.querySelector('.accordion-header');

            header.addEventListener('click', () => {
                const isActive = item.classList.contains('active');

                // Close all items in this accordion
                items.forEach(otherItem => {
                    otherItem.classList.remove('active');
                    otherItem.querySelector('.accordion-header').setAttribute('aria-expanded', 'false');
                });

                // If the clicked item wasn't active, open it
                if (!isActive) {
                    item.classList.add('active');
                    header.setAttribute('aria-expanded', 'true');
                }
            });
        });
    });
}

// ===== Lead Capture Popup =====
function initLeadPopup() {
    const popup = document.getElementById('leadPopup');
    const closeBtn = document.getElementById('leadPopupClose');
    const form = document.getElementById('leadPopupForm');

    if (!popup || !closeBtn || !form) return;

    // Check if popup was already dismissed or submitted
    const popupDismissed = localStorage.getItem('leadPopupDismissed');
    const popupSubmitted = localStorage.getItem('leadPopupSubmitted');

    // Don't show if already dismissed within 7 days or submitted within 30 days
    if (popupDismissed) {
        const dismissedDate = new Date(popupDismissed);
        const daysSinceDismissed = (Date.now() - dismissedDate) / (1000 * 60 * 60 * 24);
        if (daysSinceDismissed < 7) return;
    }

    if (popupSubmitted) {
        const submittedDate = new Date(popupSubmitted);
        const daysSinceSubmitted = (Date.now() - submittedDate) / (1000 * 60 * 60 * 24);
        if (daysSinceSubmitted < 30) return;
    }

    // Show popup after 5 seconds or 30% scroll, whichever comes first
    let popupShown = false;

    function showPopup() {
        if (popupShown) return;
        popupShown = true;
        popup.classList.add('active');
        document.body.style.overflow = 'hidden';
        // Trigger animation
        requestAnimationFrame(() => {
            popup.classList.add('fade-in');
        });
    }

    function hidePopup() {
        popup.classList.remove('fade-in');
        popup.classList.remove('active');
        document.body.style.overflow = '';
    }

    // Timer trigger - show after 5 seconds
    const timerTrigger = setTimeout(showPopup, 5000);

    // Scroll trigger - show after 30% scroll
    function handleScroll() {
        const scrollPercent = (window.scrollY / (document.body.scrollHeight - window.innerHeight)) * 100;
        if (scrollPercent > 30) {
            showPopup();
            window.removeEventListener('scroll', handleScroll);
        }
    }
    window.addEventListener('scroll', handleScroll);

    // Close button
    closeBtn.addEventListener('click', () => {
        hidePopup();
        localStorage.setItem('leadPopupDismissed', new Date().toISOString());
        clearTimeout(timerTrigger);
        window.removeEventListener('scroll', handleScroll);
    });

    // Click outside to close
    popup.addEventListener('click', (e) => {
        if (e.target === popup) {
            hidePopup();
            localStorage.setItem('leadPopupDismissed', new Date().toISOString());
        }
    });

    // Escape key to close
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && popup.classList.contains('active')) {
            hidePopup();
            localStorage.setItem('leadPopupDismissed', new Date().toISOString());
        }
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(form);
        const data = Object.fromEntries(formData);

        // Add metadata
        data.form_type = 'popup_lead';
        data.page_url = window.location.href;
        data.page_title = document.title;

        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Sending...';

        // Send to backend
        fetch('/api/submit-lead.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                showNotification('Thank you! We\'ll contact you within 24 hours.', 'success');
                localStorage.setItem('leadPopupSubmitted', new Date().toISOString());
                hidePopup();
            } else {
                showNotification(result.message || 'Something went wrong. Please try again.', 'error');
            }
        })
        .catch(error => {
            console.error('Form submission error:', error);
            showNotification('Something went wrong. Please try again.', 'error');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });
}
