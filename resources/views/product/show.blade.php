

@extends('layout.app')

@section('content')

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
        }

        .movie-list-section {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 20px;
        }

        .section-title {
            font-size: 36px;
            font-weight: bold;
            color: #222;
            margin-bottom: 40px;
        }

        .movie-content {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 40px;
            align-items: start;
        }

        .movie-list {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .placeholder-text {
            color: #999;
            font-size: 16px;
            margin-bottom: 30px;
            font-style: italic;
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 25px;
            width: 100%;
        }

        .btn {
            padding: 14px 35px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
        }

        .btn-buy {
            background-color: #ff6b35;
            color: white;
        }

        .btn-buy:hover {
            background-color: #e55a2b;
            transform: translateY(-2px);
        }

        .btn-buy.hidden {
            display: none;
        }

        /* Product Quantity Control */
        .product-quantity-control {
            display: none;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            border: 2px solid #ff6b35;
            border-radius: 6px;
            padding: 10px 18px;
            gap: 15px;
            min-width: 140px;
        }

        .product-quantity-control.active {
            display: flex;
        }

        .product-qty-btn {
            background: #ff6b35;
            color: white;
            border: none;
            width: 35px;
            height: 35px;
            border-radius: 4px;
            font-size: 20px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }

        .product-qty-btn:hover {
            background: #e55a2b;
            transform: scale(1.1);
        }

        .product-qty-btn:active {
            transform: scale(0.95);
        }

        .product-qty-value {
            font-size: 18px;
            font-weight: 700;
            color: #333;
            min-width: 30px;
            text-align: center;
        }

        .btn-close {
            background-color: #e0e0e0;
            color: #555;
        }

        .btn-close:hover {
            background-color: #d0d0d0;
        }

        .movies-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 5px 20px;
        }

        .movie-item {
            font-size: 14px;
            color: #555;
            line-height: 1.6;
            padding: 5px 0;
        }

        .movie-sidebar {
            position: sticky;
            top: 20px;
        }

        .disk-image-container div {
            width: 100%;
        }

        .disk-image {
            width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
        }

        .badge-2tb {
            position: absolute;
            bottom: 30px;
            left: 30px;
            background-color: #ff6b35;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .badge-2tb::before {
            content: "💾";
            font-size: 18px;
        }

        @media (max-width: 1024px) {
            .movie-content {
                grid-template-columns: 1fr;
            }

            .movie-sidebar {
                position: relative;
                order: -1;
            }

            .movies-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .section-title {
                font-size: 28px;
            }

            .movie-list {
                padding: 20px;
            }

            .movies-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }

    </style>



    <section class="movie-list-section">
        <h2 class="section-title">{{ $product->name }}</h2>

        <div class="movie-content">

            {!!   $product->full_description !!}

            <div class="movie-sidebar">
                <div class="disk-image-container">
                    <div style="position: relative; display: inline-block">
                        <img src="{{ $product->image ? asset('storage/'.$product->image) : 'assets/images/no-image.png' }}"
                             alt="Советские 2 тб" class="disk-image">
                    </div>
                </div>

                <div class="action-buttons">
                    <button class="btn btn-buy" id="buyBtn">Купить</button>
                    <div class="product-quantity-control" id="quantityControl">
                        <button class="product-qty-btn qty-decrease">−</button>
                        <span class="product-qty-value">1</span>
                        <button class="product-qty-btn qty-increase">+</button>
                    </div>
                    <button class="btn btn-close" onclick="goBack()">Закрыть</button>
                </div>
            </div>
        </div>
    </section>
    <!-- Cart Modal -->
    <div id="cartModal" class="cart-modal">
        <div class="cart-modal-overlay"></div>
        <div class="cart-modal-content">
            <div class="cart-modal-header">
                <h2 class="cart-modal-title">Корзина</h2>
                <button class="cart-modal-close" aria-label="Close">×</button>
            </div>

            <div class="cart-modal-body" id="cartModalBody">
                <!-- Empty cart message -->
                <div class="cart-empty" id="cartEmpty">
                    <p>Ваша корзина пуста</p>
                    <button class="btn-continue-shopping" onclick="closeCartModal()">
                        Продолжить покупки
                    </button>
                </div>

                <!-- Cart items -->
                <div class="cart-items" id="cartItems"></div>
            </div>

            <div class="cart-modal-footer" id="cartFooter" style="display: none">
                <div class="cart-total">
                    <span class="cart-total-label">Итого:</span>
                    <span class="cart-total-price" id="cartTotalPrice">0 ₽</span>
                </div>

                <form id="cartCheckoutForm" class="cart-checkout-form">
                    <div class="cart-form-group">
                        <label for="cartCustomerName">Имя</label>
                        <input type="text" id="cartCustomerName" placeholder="Ваше полное имя" required="">
                    </div>

                    <div class="cart-form-group">
                        <label for="cartCustomerContact">Контакт</label>
                        <p>(email, телефон, мессенджеры)</p>
                        <input type="text" id="cartCustomerContact" placeholder="Телефон или Email" required="">
                    </div>

                    <div class="cart-form-group">
                        <label for="cartCustomerAddress">Адрес доставки</label>
                        <p>не обязательно</p>
                        <textarea id="cartCustomerAddress" placeholder="Город, улица, дом, квартира" rows="3"></textarea>
                    </div>

                    <button type="submit" class="cart-checkout-btn">
                        <span class="cart-checkout-btn-text">Оформить заказ</span>
                        <span class="cart-checkout-btn-loader"></span>
                    </button>
                </form>
            </div>

            <!-- Success screen -->
            <div class="cart-success" id="cartSuccess" style="display: none">
                <div class="cart-success-icon">✓</div>
                <h3 class="cart-success-title">Заказ успешно оформлен!</h3>
                <div class="cart-success-info">
                    <p>
                        <strong>Номер заказа:</strong>
                        <span id="successCartOrderId"></span>
                    </p>
                    <p><strong>Сумма:</strong> <span id="successCartTotal"></span></p>
                </div>
                <p class="cart-success-message">
                    Наш менеджер свяжется с вами в ближайшее время для подтверждения
                    заказа.
                </p>
                <button class="cart-success-btn" onclick="closeCartModal()">
                    Закрыть
                </button>
            </div>
        </div>
    </div>
    {{-- Передача данных в JS --}}

        <script>

            // Передача данных в JS и инициализация страницы продукта
            const productData = {
                id: "{{ $product->id }}",
                title: "{{ $product->name }}", {{-- исправлено с title на name --}}
                price: {{ $product->price }},
                image: "{{ $product->image ? asset('storage/'.$product->image) : 'assets/images/no-image.png' }}"
            };

            // Инициализация при загрузке DOM
            document.addEventListener('DOMContentLoaded', function() {
                initProductPage(productData);
            });


        </script>
@endsection

