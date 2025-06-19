// Header functionality for dropdown menus and mobile navigation

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize dropdown functionality
    initDropdowns();
    
    // Initialize search dropdown
    initSearchDropdown();
    
    // Initialize mobile menu
    initMobileMenu();
});

// Dropdown functionality
function initDropdowns() {
    const dropdowns = document.querySelectorAll('.dropdown');
    
    dropdowns.forEach(dropdown => {
        const dropdownMenu = dropdown.querySelector('.dropdown-menu');
        
        if (dropdownMenu) {
            // Show dropdown on hover
            dropdown.addEventListener('mouseenter', function() {
                dropdownMenu.style.display = 'block';
                dropdownMenu.classList.remove('opacity-0', 'invisible');
                dropdownMenu.classList.add('opacity-100', 'visible');
            });
            
            // Hide dropdown when mouse leaves
            dropdown.addEventListener('mouseleave', function() {
                dropdownMenu.classList.remove('opacity-100', 'visible');
                dropdownMenu.classList.add('opacity-0', 'invisible');
                setTimeout(() => {
                    if (dropdownMenu.classList.contains('opacity-0')) {
                        dropdownMenu.style.display = 'none';
                    }
                }, 200);
            });
        }
    });
}

// Search dropdown functionality
function initSearchDropdown() {
    const searchDropdown = document.querySelector('.search-dropdown');
    const searchButton = searchDropdown?.querySelector('button');
    const searchMenu = searchDropdown?.querySelector('.dropdown-menu');
    const openIcon = searchDropdown?.querySelector('.open');
    const closeIcon = searchDropdown?.querySelector('.close');
    
    if (searchButton && searchMenu) {
        // Initially hide close icon and search menu
        closeIcon.style.display = 'none';
        searchMenu.style.display = 'none';
        
        searchButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (searchMenu.style.display === 'none') {
                // Show search menu
                searchMenu.style.display = 'block';
                openIcon.style.display = 'none';
                closeIcon.style.display = 'block';
            } else {
                // Hide search menu
                searchMenu.style.display = 'none';
                openIcon.style.display = 'block';
                closeIcon.style.display = 'none';
            }
        });
        
        // Close search when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchDropdown.contains(e.target)) {
                searchMenu.style.display = 'none';
                openIcon.style.display = 'block';
                closeIcon.style.display = 'none';
            }
        });
    }
}

// Mobile menu functionality
function initMobileMenu() {
    const mobileMenuButton = document.querySelector('.menu-mobile');
    const sideArea = document.querySelector('.side-area');
    const backMenu = document.querySelector('.back-menu');
    const mobileDropdowns = document.querySelectorAll('#side-menu .dropdown');
    
    if (mobileMenuButton && sideArea) {
        // Initially hide mobile menu
        sideArea.style.display = 'none';
        
        // Show mobile menu
        mobileMenuButton.addEventListener('click', function(e) {
            e.preventDefault();
            sideArea.style.display = 'block';
            document.body.style.overflow = 'hidden';
        });
        
        // Hide mobile menu when clicking background
        if (backMenu) {
            backMenu.addEventListener('click', function(e) {
                if (e.target === backMenu || e.target.closest('.cursor-pointer')) {
                    sideArea.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
            });
        }
    }
    
    // Mobile dropdown functionality
    mobileDropdowns.forEach(dropdown => {
        const dropdownLink = dropdown.querySelector('a[href="javascript:;"]');
        const dropdownMenu = dropdown.querySelector('.dropdown-menu');
        
        if (dropdownLink && dropdownMenu) {
            // Initially hide dropdown menu
            dropdownMenu.style.display = 'none';
            
            dropdownLink.addEventListener('click', function(e) {
                e.preventDefault();
                
                if (dropdownMenu.style.display === 'none') {
                    // Close other open dropdowns
                    mobileDropdowns.forEach(otherDropdown => {
                        if (otherDropdown !== dropdown) {
                            const otherMenu = otherDropdown.querySelector('.dropdown-menu');
                            if (otherMenu) {
                                otherMenu.style.display = 'none';
                            }
                        }
                    });
                    
                    // Show this dropdown
                    dropdownMenu.style.display = 'block';
                } else {
                    // Hide this dropdown
                    dropdownMenu.style.display = 'none';
                }
            });
        }
    });
}

// Close mobile menu when window is resized to desktop size
window.addEventListener('resize', function() {
    if (window.innerWidth >= 1024) { // lg breakpoint
        const sideArea = document.querySelector('.side-area');
        if (sideArea) {
            sideArea.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    }
});