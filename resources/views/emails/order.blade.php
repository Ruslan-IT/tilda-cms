
<h2>Новый заказ #{{ $orderId }}</h2>

<p><strong>Имя:</strong> {{ $data['name'] }}</p>
<p><strong>Контакт:</strong> {{ $data['contact'] }}</p>

@if(!empty($data['address']))
    <p><strong>Адрес доставки:</strong> {{ $data['address'] }}</p>
@endif

<hr>

<h3>Товары:</h3>

@foreach($data['items'] as $item)
    <div style="margin-bottom: 20px;">
        <img src="{{ $item['image'] }}" width="120" style="border-radius: 6px">

        <p><strong>{{ $item['title'] }}</strong></p>
        <p>Количество: {{ $item['quantity'] }}</p>
        <p>Сумма: {{ number_format($item['subtotal'], 0, ',', ' ') }} ₽</p>
    </div>
@endforeach

<hr>

<h2>Итого: {{ number_format($data['total'], 0, ',', ' ') }} ₽</h2>
