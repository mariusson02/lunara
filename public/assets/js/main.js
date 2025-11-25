"use strict";


const IS_LOGGED_IN = document.querySelector('meta[name="logged-in"]').getAttribute('content') === "true";

function redirect(path) {
    window.location.href = path;
}

const cartCookie = 'shoppingCart';

/**
 * Retrieves the value of a specified cookie.
 * @param {string} name - The name of the cookie.
 * @returns {string|null} The decoded value of the cookie if found, or null if the cookie doesn't exist.
 */
function getCookie(name) {
    const cookies = document.cookie.split('; ');
    for (let i = 0; i < cookies.length; i++) {
        const [key, value] = cookies[i].split('=');
        if (key === name) {
            return decodeURIComponent(value);
        }
    }
    return null;
}

/**
 * Sets a cookie with the specified name, value, and expiration time in days.
 * @param {string} name - The name of the cookie.
 * @param {string} value - The value to store in the cookie.
 * @param {number} days - The number of days the cookie will remain valid.
 * @example
 * setCookie('shoppingCart', 'item123', 7);
 */
function setCookie(name, value, days) {
    const date = new Date();
    date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
    const expires = `expires=${date.toUTCString()}`;
    document.cookie = `${name}=${encodeURIComponent(value)}; ${expires}; path=/; SameSite=Strict`;
}

/**
 * Sets up an IntersectionObserver to reveal elements with the 'reveal' class as they appear on screen.
 * Each element will be revealed with a slight delay based on its index.
 */
function observeRevealElements() {
    const revealElements = document.querySelectorAll(".reveal");

    const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if(entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add("visible");
                        observer.unobserve(entry.target);
                    }, 200 * index);
                }
            });
        },
        {
            threshold: 0.1
        });

    revealElements.forEach((el) => observer.observe((el)));
}

/**
 * Initializes the mobile navigation menu. Adds event listeners to toggle the visibility of the menu
 * and close it using a close button.
 */
function setupMobileNav(){
    const hamburger = document.getElementById("hamburger-btn");
    const navbarItems = document.getElementById("hamburger-items");

    // Close Button direkt ins Navbar-Menü einfügen
    const closeBtn = document.createElement("button");
    closeBtn.innerHTML = "&times;";
    closeBtn.classList.add("navbar__close");
    navbarItems && navbarItems.prepend(closeBtn);

    hamburger && hamburger.addEventListener("click", function () {
        navbarItems.classList.toggle("show");
        hamburger.classList.toggle("hide");
    });

    closeBtn && closeBtn.addEventListener("click", function () {
        navbarItems.classList.remove("show");
        hamburger.classList.remove("hide");
    });
}

function navbarHover(listNodes, originalActive) {
    listNodes.forEach( item => {
        item && item.addEventListener( 'mouseover', () => {
            if (originalActive) {
                originalActive.classList.remove('active');
            }
            item.classList.add('active');
        })

        item && item.addEventListener( 'mouseout', () => {
            item.classList.remove('active');
            if(originalActive) {
                originalActive.classList.add('active');
            }
        })
    })
}

/**
 * Displays a temporary alert message on the screen. The alert will disappear after 3 seconds.
 * @param {boolean} success - Whether the alert is a success (green) or error (red).
 * @param {string} message - The message to display in the alert.
 * @returns {Promise} A promise that resolves after the alert has been removed.
 * @example
 * displayAlert(true, 'Action successful!');
 */
function displayAlert(success, message) {
    return new Promise((resolve) => {
        const alertWrapper = document.createElement('div');
        const alert = document.createElement('p');

        alertWrapper.classList.add('alert-wrapper');
        alert.classList.add('alert');
        if (success) {
            alert.classList.add('success');
        }
        alert.textContent = message;

        document.body.appendChild(alertWrapper);
        alertWrapper.appendChild(alert);

        setTimeout(() => {
            alertWrapper.remove();
            resolve();
        }, 3000);
    });
}

/**
 * Adds tooltips to buttons with the 'with-tooltip' class.
 * The tooltip appears when the user hovers over the button.
 * The button must have the tooltip text in a data-tooltip attribute.
 */
function setupTooltipsForButtons() {

    const buttons = document.querySelectorAll('button.with-tooltip');
    buttons && buttons.forEach((button) => {

        const tooltipText = button.getAttribute("data-tooltip");
        let tooltip = null;

        button.style.position = "relative";
        button.addEventListener("mouseover", () => {
            if(button.disabled && !tooltip) {
                tooltip = document.createElement("div");
                tooltip.innerText = tooltipText;
                tooltip.classList.add("tooltip");
                button.appendChild(tooltip);
            }
        })
        button.addEventListener("mouseleave", () => {
            if(tooltip) {
                tooltip.remove();
                tooltip = null;
            }
        })
    })
}

document.addEventListener("DOMContentLoaded", function() {
    const navbar = document.querySelectorAll('.navbar__item');
    const navbarOriginalActive = document.querySelector(".navbar__item.active");
    observeRevealElements();
    setupTooltipsForButtons();
    navbarHover(navbar, navbarOriginalActive);
    setupMobileNav();
});
