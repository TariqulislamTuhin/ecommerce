@extends('frontend.master')
@section('content')

<!-- breadcrumb-area start -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-12 text-center">
                <h2 class="breadcrumb-title">Shop</h2>
                <!-- breadcrumb-list start -->
                <ul class="breadcrumb-list">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Checkout</li>
                </ul>
                <!-- breadcrumb-list end -->
            </div>
        </div>
    </div>
</div>

<!-- breadcrumb-area end -->


<!-- checkout area start -->
<div class="checkout-area pt-100px pb-100px">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="billing-info-wrap">
                    <h3>Billing Details</h3>
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="billing-info mb-4">
                                <label for="name">Name</label>
                                <input type="text" name="name" value="{{ $profile->user->name }}" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="billing-info mb-4">
                                <label>Mobile No.</label>
                                <input type="tel" value="0{{ $profile->mobile_no }}" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="billing-info mb-4">
                                <label>Email Address</label>
                                <input type="email" value="{{ $profile->user->email }}" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="billing-select mb-4">
                                <label>Country</label>
                                <select id="city_dropdown" class="email s-email s-wid">
                                    <option value="">Select</option>
                                    @foreach ($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="billing-select mb-4">
                                <label>District</label>
                                <select id="district_dropdown" class="email s-email s-wid">
                                    <option value="">Select</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="billing-info mb-4">
                                <label>Street Address</label>
                                <input class="billing-address" placeholder="House number and street name" type="text" />
                                <input placeholder="Apartment, suite, unit etc." type="text"
                                    value="{{ $profile->address }}" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="billing-info mb-4">
                                <label>Thana / Upozila</label>
                                <input type="text" name="thana" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="billing-info mb-4">
                                <label>Postcode / ZIP</label>
                                <input type="text" />
                            </div>
                        </div>

                    </div>

                    <div class="additional-info-wrap">
                        <h4>Additional information</h4>
                        <div class="additional-info">
                            <label>Order notes</label>
                            <textarea placeholder="Notes about your order, e.g. special notes for delivery. "
                                name="message"></textarea>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-5 mt-md-30px mt-lm-30px ">
                <div class="your-order-area">
                    <h3>Your order</h3>
                    <div class="your-order-wrap gray-bg-4">
                        <div class="your-order-product-info">
                            <div class="your-order-top">
                                <ul>
                                    <li>Product</li>
                                    <li>Total</li>
                                </ul>
                            </div>
                            <div class="your-order-middle">
                                <ul>
                                    @foreach (getcarts() as $cart)

                                    <li><span
                                            class="order-middle-left">{{ $cart->product->name .' X '. $cart->quantity }}</span>
                                        <span class="order-price">
                                            @php
                                            $price=(price($cart->product_id,$cart->color_id,$cart->size_id)->offer_price)
                                            ?? (price($cart->product_id,$cart->color_id,$cart->size_id)->regular_price);
                                            @endphp
                                            {{ $price * $cart->quantity }} tk.
                                        </span>
                                    </li>
                                    <hr>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="your-order-bottom">
                                <ul>
                                    <li class="your-order-shipping">Discount
                                        {{ session('coupon_name') ? '('.session('coupon_name').')' : '' }}
                                    </li>
                                    <li>{{ session('discount') }}%</li>
                                </ul>
                                <hr>
                                <ul>
                                    <li class="your-order-shipping">Shipping</li>
                                    <li>{{ session('shipping') }} Tk.</li>
                                </ul>
                            </div>
                            <div class="your-order-total">
                                <ul>
                                    <li class="order-total">Total</li>
                                    <li>{{ (session('total') + session('shipping')) }} Tk.</li>
                                </ul>
                            </div>

                        </div>
                        <div class="payment-method">

                            <div class="payment-accordion element-mrg">
                                <div id="faq" class="panel-group">
                                    <div class="panel panel-default single-my-account m-0">
                                        <div class="panel-heading my-account-title">
                                            <label class="container">SSLCOMMERZ
                                                <input type="radio" name="payment_method" value="sslcommerz">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="panel panel-default single-my-account m-0">
                                        <div class="panel-heading my-account-title">
                                            <label class="container">Cash on Delivary
                                                <input type="radio" name="payment_method" value="cash_on_delivary">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="Place-order mt-25">
                        <a class="btn-hover" href="#">Place Order</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- checkout area end -->

@endsection


@section('footer_js')
<script>
    $(document).ready(function(){
        $('#coupon_btn').click(function(){
            var coupon = $("#coupon_name").val();
            var address = "{{ route('cart.index') }}/" + coupon;
            window.location.href = address;
        });


         $("#city_dropdown").change(function(){
                var city_id = $('#city_dropdown').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url:'{{ route('cart.DistrictList') }}',
                    data: {city_id: city_id},
                    success: function(res){
                        $("#district_dropdown").empty();
                        $("#district_dropdown").append('<option value="">--Select One--</option>');
                        let options = "";
                        $.each(res,function (key,value) {
                            options += '<option value="'+value.id+'">'+value.name+'</option>';
                        });
                        $("#district_dropdown").append(options);
                    }
                });

        });



    });
</script>

@endsection
