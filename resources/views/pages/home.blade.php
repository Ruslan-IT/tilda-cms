@extends('layout.app')

@section('title', 'Главная')

@section('content')
    <main>
        <div class="products-container">
            <div class="products-grid">

                <!-- Product 1 -->
                @foreach($products as $product)
                    <div class="product-card"
                         data-collection-id="{{ $product->id }}"
                         data-collection-title="{{ $product->name }}"
                         data-collection-price="{{ $product->price }}"
                         data-collection-image="{{ $product->image ? asset('storage/'.$product->image) : '' }}"
                         data-collection-description="{{ $product->short_description }}"
                    >

                        <div class="product-image">
                            <img src="{{ $product->image ? asset('storage/'.$product->image) : 'assets/images/no-image.png' }}"
                                 alt="{{ $product->name }}">
                        </div>

                        <div class="product-info">

                            <h3 class="product-title">{{ $product->name }}</h3>

                            <div class="product-price">
                                <span class="current-price">{{ number_format($product->price, 0, ',', ' ') }} р.</span>

                                @if($product->old_price)
                                    <span class="old-price">{{ number_format($product->old_price, 0, ',', ' ') }} р.</span>
                                @endif
                            </div>

                            <div class="product-buttons">

                                <a href="{{ route('product.show', $product->id) }}" class="btn btn-list">
                                    Список
                                </a>

                                <button class="btn btn-buy">Купить</button>
                            </div>

                        </div>

                    </div>
                @endforeach


            </div>
        </div>
        <section id="hero-section" class="hero-section">
            <div class="hero-background"></div>
            <div class="hero-overlay"></div>

            <div class="hero-content">
                <h1 class="hero-title">{!! $infoBlock2->title  !!}</h1>
                <p class="hero-description">
                    {!! $infoBlock2->content  !!}
                </p>
                <button class="hero-cta">Не подходит готовая коллекция?</button>
            </div>

            <a href="#custom-disk-section" class="scroll-indicator">
                <svg role="presentation" class="t-cover__arrow-svg" style="fill: #ffffff" x="0px" y="0px" width="38.417px" height="18.592px" viewBox="0 0 38.417 18.592">
                    <g>
                        <path d="M19.208,18.592c-0.241,0-0.483-0.087-0.673-0.261L0.327,1.74c-0.408-0.372-0.438-1.004-0.066-1.413c0.372-0.409,1.004-0.439,1.413-0.066L19.208,16.24L36.743,0.261c0.411-0.372,1.042-0.342,1.413,0.066c0.372,0.408,0.343,1.041-0.065,1.413L19.881,18.332C19.691,18.505,19.449,18.592,19.208,18.592z"></path>
                    </g>
                </svg>
            </a>
        </section>

        <section id="custom-disk-section" class="custom-disk-section">
            <div class="container-custom-disk-section">
                <h2 class="section-title">Создайте свой уникальный диск</h2>
                <p class="section-description">
                    Если вам не подошел никакой из наших готовых дисков, вы можете
                    записать часть одной и другой коллекции на один диск
                </p>

                <form id="customDiskForm">
                    <div class="form-group">
                        <label class="form-label" for="email">E-mail</label>
                        <input type="email" id="email" class="form-input" placeholder="Ваш E-mail" required="">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="name">Имя</label>
                        <input type="text" id="name" class="form-input" placeholder="Ваше полное имя" required="">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="comments">Комментарии</label>
                        <textarea id="comments" class="form-input" required=""></textarea>
                    </div>

                    <button type="submit" class="submit-btn">Отправить</button>
                </form>
            </div>
        </section>

        <section id="features-section" class="features-section">
            {!! $infoBlock3->content  !!}
        </section>
        <article id="article-section" class="article-section">
            <h1 class="article-title">
                Оригинальный Подарок: коллекция фильмов на жестком диске
            </h1>

            {!! $infoBlock->content  !!}


        </article>
    </main>
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

    <div id="customDiskSuccess" class="custom-disk-success-popup">
        <div class="popup-content">
            <h3>Сообщение отправлено!</h3>
            <p>Мы получили вашу заявку и свяжемся с вами в ближайшее время.</p>
            <button class="hero-cta" id="customDiskClosePopup">Закрыть</button>
        </div>
    </div>
@endsection


