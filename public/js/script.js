// ============================================
// PRODUCT PAGE QUANTITY CONTROL
// ============================================


function initProductPage(productData) {
    loadCartFromLocalStorage();

    const buyBtn = document.getElementById("buyBtn");
    const quantityControl = document.getElementById("quantityControl");

    // Если элементов нет — значит эта страница не продукт
    if (!buyBtn || !quantityControl) return;

    const decreaseBtn = quantityControl.querySelector(".qty-decrease");
    const increaseBtn = quantityControl.querySelector(".qty-increase");
    const quantityValue = quantityControl.querySelector(".product-qty-value");

    // Проверка товара в корзине
    const cartItem = cart.find((item) => item.id === productData.id);
    if (cartItem) {
        buyBtn.classList.add("hidden");
        quantityControl.classList.add("active");
        quantityValue.textContent = cartItem.quantity;
    }

    buyBtn.addEventListener("click", function () {
        addToCart(productData);
        buyBtn.classList.add("hidden");
        quantityControl.classList.add("active");
        updateQuantity();
    });

    increaseBtn.addEventListener("click", function () {
        increaseQuantity(productData.id);
        updateQuantity();
    });

    decreaseBtn.addEventListener("click", function () {
        decreaseQuantity(productData.id);
        updateQuantity();

        // Если товар удалился — показать кнопку Купить
        if (!cart.find(i => i.id === productData.id)) {
            buyBtn.classList.remove("hidden");
            quantityControl.classList.remove("active");
        }
    });

    function updateQuantity() {
        const item = cart.find((i) => i.id === productData.id);
        if (item) quantityValue.textContent = item.quantity;
    }
}
function goBack() {
    window.location.href = "/";
}


// Smooth Scroll Functionality
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
        e.preventDefault();

        const targetId = this.getAttribute("href");
        if (targetId === "#" || !targetId) return;

        const targetElement = document.querySelector(targetId);
        if (targetElement) {
            const headerOffset = 80; // Adjust for fixed header height
            const elementPosition = targetElement.getBoundingClientRect().top;
            const offsetPosition =
                elementPosition + window.pageYOffset - headerOffset;

            window.scrollTo({
                top: offsetPosition,
                behavior: "smooth",
            });

            // Close mobile menu if open
            if (burgerMenu && mobileMenu) {
                burgerMenu.classList.remove("open");
                mobileMenu.classList.remove("open");
            }
        }
    });
});

// Burger Menu Toggle
const burgerMenu = document.getElementById("burgerMenu");
const mobileMenu = document.getElementById("mobileMenu");

if (burgerMenu && mobileMenu) {
    // Toggle menu
    burgerMenu.addEventListener("click", (e) => {
        e.stopPropagation();

        burgerMenu.classList.toggle("open");
        mobileMenu.classList.toggle("open");
    });

    // Close menu when clicking on a link
    const mobileLinks = document.querySelectorAll(".mobile-nav a");
    mobileLinks.forEach((link) => {
        link.addEventListener("click", () => {
            burgerMenu.classList.remove("open");
            mobileMenu.classList.remove("open");
        });
    });

    // Close menu when clicking outside
    document.addEventListener("click", (e) => {
        if (
            burgerMenu.classList.contains("open") &&
            !mobileMenu.contains(e.target) &&
            !burgerMenu.contains(e.target)
        ) {
            burgerMenu.classList.remove("open");
            mobileMenu.classList.remove("open");
        }
    });
}
