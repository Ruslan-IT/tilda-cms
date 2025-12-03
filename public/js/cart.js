// ============================================
// CART SYSTEM - MODULAR IMPLEMENTATION
// ============================================

// Cart State
let cart = [];

// ============================================
// CART CORE FUNCTIONS
// ============================================

function addToCart(product) {
    const existingItem = cart.find(item => item.id === product.id);

    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({
            id: product.id,
            title: product.title,
            price: product.price,
            image: product.image,
            quantity: 1,
        });
    }

    saveCartToLocalStorage();
    updateCartUI();
    showCartTooltip();
}

function removeFromCart(productId) {
    cart = cart.filter(item => item.id !== productId);
    saveCartToLocalStorage();
    updateCartUI();
}

function increaseQuantity(productId) {
    const item = cart.find(item => item.id === productId);
    if (item) {
        item.quantity += 1;
        saveCartToLocalStorage();
        updateCartUI();
    }
}

function decreaseQuantity(productId) {
    const item = cart.find(item => item.id === productId);
    if (!item) return;

    if (item.quantity > 1) {
        item.quantity -= 1;
    } else {
        removeFromCart(productId);
    }

    saveCartToLocalStorage();
    updateCartUI();
}

function calculateTotal() {
    return cart.reduce((total, item) => total + item.price * item.quantity, 0);
}

function getTotalQuantity() {
    return cart.reduce((total, item) => total + item.quantity, 0);
}

// ============================================
// LOCAL STORAGE
// ============================================

function saveCartToLocalStorage() {
    localStorage.setItem("filmshdd_cart", JSON.stringify(cart));
}

function loadCartFromLocalStorage() {
    const stored = localStorage.getItem("filmshdd_cart");
    if (stored) {
        try {
            cart = JSON.parse(stored);
            updateCartUI();
        } catch (e) {
            console.error("LocalStorage error:", e);
            cart = [];
        }
    }
}

function clearCart() {
    cart = [];
    saveCartToLocalStorage();
    updateCartUI();
    updateAllProductQuantityControls(); // <--- вот это обновит карточки
}

function updateAllProductQuantityControls() {
    // Пробегаем по всем контролам на карточках товаров
    document.querySelectorAll('.product-quantity-control').forEach(control => {
        const productId = control.querySelector('.product-qty-value')?.dataset.id;
        if (!productId) return;

        const item = cart.find(i => i.id === productId);
        const qtySpan = control.querySelector('.product-qty-value');

        if (item) {
            qtySpan.textContent = item.quantity;
            control.classList.add('active');
        } else {
            qtySpan.textContent = '0';
            control.classList.remove('active');
        }
    });
}

// ============================================
// UI UPDATE
// ============================================

function updateCartUI() {
    updateCartBadge();
    updateCartModal();
    updateCartTooltip();
    updateCartIconVisibility();
}

function updateCartBadge() {
    const badge = document.getElementById("cartBadge");
    if (!badge) return;

    const qty = getTotalQuantity();
    badge.textContent = qty;
    badge.style.display = qty > 0 ? "flex" : "none";
}

function updateCartIconVisibility() {
    const cartIcon = document.getElementById("cartIcon");
    if (!cartIcon) return;

    const qty = getTotalQuantity();
    qty > 0 ? cartIcon.classList.add("has-items") : cartIcon.classList.remove("has-items");
}

function updateCartTooltip() {
    const tooltip = document.getElementById("cartTooltip");
    const tooltipContent = tooltip?.querySelector(".cart-tooltip-content");
    if (!tooltipContent) return;

    const qty = getTotalQuantity();
    const total = calculateTotal();

    if (qty === 0) {
        tooltipContent.textContent = "Корзина пуста";
    } else {
        tooltipContent.innerHTML = `
      <div><strong>${qty}</strong> товаров</div>
      <div><strong>${total.toLocaleString("ru-RU")} ₽</strong></div>
    `;
    }
}

function showCartTooltip() {
    const tooltip = document.getElementById("cartTooltip");
    if (!tooltip) return;

    tooltip.classList.add("show");
    setTimeout(() => tooltip.classList.remove("show"), 2000);
}

function updateCartModal() {
    const cartItems = document.getElementById("cartItems");
    const cartEmpty = document.getElementById("cartEmpty");
    const cartFooter = document.getElementById("cartFooter");
    const cartTotalPrice = document.getElementById("cartTotalPrice");

    if (!cartItems) return;

    if (cart.length === 0) {
        cartEmpty.style.display = "block";
        cartItems.style.display = "none";
        cartFooter.style.display = "none";
        return;
    }

    cartEmpty.style.display = "none";
    cartItems.style.display = "block";
    cartFooter.style.display = "block";

    cartItems.innerHTML = cart.map(item => `
    <div class="cart-item" data-id="${item.id}">
      <img src="${item.image}" class="cart-item-image" />
      <div class="cart-item-details">
        <h4 class="cart-item-title">${item.title}</h4>

        <div class="cart-item-controls">
          <div class="cart-item-quantity">
            <button onclick="decreaseQuantity('${item.id}')" class="qty-btn">−</button>
            <span class="qty-value">${item.quantity}</span>
            <button onclick="increaseQuantity('${item.id}')" class="qty-btn">+</button>
          </div>

          <div class="cart-item-subtotal">
            ${(item.price * item.quantity).toLocaleString("ru-RU")} ₽
          </div>
        </div>
      </div>

      <button onclick="removeFromCart('${item.id}')" class="cart-item-remove">×</button>
    </div>
  `).join("");

    cartTotalPrice.textContent = `${calculateTotal().toLocaleString("ru-RU")} ₽`;
}

// ============================================
// MODAL

// ============================================

function openCartModal() {
    const modal = document.getElementById("cartModal");
    if (!modal) return;

    document.getElementById("cartSuccess").style.display = "none";
    document.getElementById("cartModalBody").style.display = "block";

    modal.classList.add("active");
    document.body.style.overflow = "hidden";
}

function closeCartModal() {
    const modal = document.getElementById("cartModal");
    if (!modal) return;

    modal.classList.remove("active");
    document.body.style.overflow = "";
}

window.closeCartModal = closeCartModal;

// ============================================
// CHECKOUT — реальные отправка заказа на Laravel
// ============================================

async function handleCartCheckout(e) {
    e.preventDefault();

    let name = document.getElementById('cartCustomerName').value;
    let contact = document.getElementById('cartCustomerContact').value;
    let address = document.getElementById('cartCustomerAddress').value;
    let email = document.getElementById('cartCustomerEmail').value;

    if (!name || !contact || !address || !email) {
        alert("Заполните все поля");
        return;
    }

    if (cart.length === 0) {
        alert("Корзина пуста");
        return;
    }

    let items = cart.map(item => ({
        id: item.id,
        title: item.title,
        email: item.email,
        quantity: item.quantity,
        price: item.price,
        subtotal: item.price * item.quantity,
        image: item.image
    }));

    let data = {
        name,
        contact,
        address,
        email,
        items,
        total: calculateTotal()
    };

    try {
        let res = await fetch('/order/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
            },
            body: JSON.stringify(data)
        });


        res = await res.json();

        if (res.success) {
            document.getElementById('successCartOrderId').innerText = res.order_id;
            document.getElementById('successCartTotal').innerText = res.total + ' ₽';

            document.getElementById('cartModalBody').style.display = 'none';
            document.getElementById('cartSuccess').style.display = 'block';

            clearCart();
        }

    } catch (e) {
        console.error(e);
        alert("Ошибка отправки заказа");
    }
}

// ============================================
// INIT
// ============================================

function initCartSystem() {
    loadCartFromLocalStorage();

    document.querySelectorAll(".btn-buy").forEach(btn =>
        btn.addEventListener("click", handleBuyButtonClick)
    );

    document.getElementById("cartIcon")?.addEventListener("click", openCartModal);
    document.querySelector(".cart-modal-close")?.addEventListener("click", closeCartModal);
    document.querySelector(".cart-modal-overlay")?.addEventListener("click", closeCartModal);

    document.getElementById('cartCheckoutForm')?.addEventListener('submit', handleCartCheckout);
}

function handleBuyButtonClick(event) {
    const card = event.target.closest(".product-card");
    if (!card) return;

    addToCart({
        id: card.dataset.collectionId,
        title: card.dataset.collectionTitle,
        email: card.dataset.cartCustomerEmail,
        price: parseInt(card.dataset.collectionPrice),
        image: card.dataset.collectionImage
    });
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initCartSystem);
} else {
    initCartSystem();
}





    document.getElementById('customDiskForm').addEventListener('submit', function(e){
        e.preventDefault();

        const data = {
            email: document.getElementById('email').value,
            name: document.getElementById('name').value,
            comments: document.getElementById('comments').value,
        };

        fetch('/custom-disk/send', {
        method: 'POST',
        headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
        body: JSON.stringify(data)
    })
        .then(res => res.json())
        .then(res => {
        if(res.success){

            const popup = document.getElementById('customDiskSuccess');
            popup.style.display = 'flex';

        document.getElementById('customDiskForm').reset();
    } else {
        alert('Ошибка при отправке, попробуйте снова.');
    }


    })
            .catch(err => {
            console.error(err);
            alert('Ошибка при отправке, попробуйте снова.');
        });
    });

// кнопка закрытия попапа
document.getElementById('customDiskClosePopup').addEventListener('click', function() {
    document.getElementById('customDiskSuccess').style.display = 'none';
});




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



