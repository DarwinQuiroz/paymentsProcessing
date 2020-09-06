<label class="mt-3">Detalles de la tarjeta:</label>

<div class="form-group form-row">
    <div class="col-5">
        <input type="text" class="form-control"
        id="cardNumber"
        data-checkout="cardNumber"
        placeholder="Número de tarjeta">
    </div>

    <div class="col-2">
        <input type="text" class="form-control"
        data-checkout="securityCode"
        placeholder="CVC">
    </div>

    <div class="col-1"></div>

    <div class="col-1">
        <input type="text" class="form-control"
        data-checkout="cardExpirationMonth"
        placeholder="MM">
    </div>

    <div class="col-1">
        <input type="text" class="form-control"
        data-checkout="cardExpirationYear"
        placeholder="YY">
    </div>
</div>

<div class="form-group form-row">
    <div class="col-5">
        <input type="text" class="form-control"
        data-checkout="cardHolderName"
        placeholder="Nombres">
    </div>

    <div class="col-5">
        <input type="email" class="form-control"
        data-checkout="cardHolderEmail"
        placeholder="email@example.com" name="email" value="{{ Auth::user()->email }}">
    </div>
</div>

<div class="form-group form-row">
    <div class="col-2">
        <select class="custom-select" data-checkout="docType"></select>
    </div>
    <div class="col-3">
        <input type="text" class="form-control"
        data-checkout="docNumer" placeholder="Documento">
    </div>
</div>

<div class="form-group form-row">
    <div class="col">
        <small class="form-text text-muted" role="alert">
            Su pago va a ser convertido a {{ strtoupper(config('services.mercadopago.base_currency')) }}
        </small>
    </div>
</div>

<div class="form-group form-row">
    <div class="col">
        <small class="form-text text-danger" id="paymentErrors" role="alert"></small>
    </div>
</div>

<input type="hidden" id="cardNetwork" name="card_network">
<input type="hidden" id="cardToken" name="card_token">

@push('scripts')
    <script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>

    <script>
        const mercadoPago = window.Mercadopago;
        mercadoPago.setPublishableKey('{{ config('services.mercadopago.key')}}');
        mercadoPago.getIdentificationTypes();

        function setCardNetwork() {
            const cardNumber = document.getElementById('cardNumber');
            mercadoPago.getPaymentMethod({
                "bin": cardNumber.value.substring(0, 6),
            }, function(status, response) {
                const cardNetwork = document.getElementById('cardNetwork');
                cardNetwork.value = response[0].id;
            });
        }

        const mercadoPagoForm = document.getElementById('paymentForm');
        mercadoPagoForm.addEventListener('submit', function(e) {
            if(mercadoPagoForm.elements.payment_platform.value === "{{ $paymentPlatform->id }}") {
                e.preventDefault();
                mercadoPago.createToken(mercadoPagoForm, function(status, response) {
                    if(status != 200 && status != 201) {
                        const errors = document.getElementById('paymentErrors');
                        errors.textContent = response.cause[0].description;
                    }
                    else {
                        const cardToken = document.getElementById('cardToken');
                        setCardNetwork();
                        cardtoken.value = response.id;
                        mercadoPagoForm.submit();
                    }
                });
            }
        });
    </script>
@endpush
