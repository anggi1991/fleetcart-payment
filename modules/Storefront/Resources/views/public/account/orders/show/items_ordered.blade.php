<div class="order-details-middle">
    <div class="table-responsive">
        <table class="table table-borderless order-details-table">
            <thead>
                <tr>
                    <th>{{ trans('storefront::account.product_name') }}</th>
                    <th>{{ trans('storefront::account.view_order.unit_price') }}</th>
                    <th>{{ trans('storefront::account.view_order.quantity') }}</th>
                    <th>{{ trans('storefront::account.view_order.line_total') }}</th>
                </tr>
            </thead>

            <tbody>
                {{-- Loop ini sudah benar menggunakan '$order->products' sesuai data dari Controller --}}
                @foreach ($order->products as $product)
                    <tr>
                        <td>
                            <a href="{{ $product->url() }}" class="product-name">
                                {{ $product->name }}
                            </a>

                            @if ($product->hasAnyVariation())
                                <ul class="list-inline product-options">
                                    @foreach ($product->variations as $variation)
                                        <li>
                                            <label>{{ $variation->name }}:</label>
                                            {{ $variation->values()->first()?->label }}{{ $loop->last ? "" : "," }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            @if ($product->hasAnyOption())
                                <ul class="list-inline product-options">
                                    @foreach ($product->options as $option)
                                        <li>
                                            @if ($option->isFieldType())
                                                <label>{{ $option->name }}:</label> {{ $option->value }}
                                            @else
                                                <label>{{ $option->name }}:</label> {{ $option->values->implode('label', ', ') }}
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            {{-- ============================================= --}}
                            {{-- ==== BLOK BARU UNTUK INFO LISENSI DIMULAI ==== --}}
                            {{-- ============================================= --}}
                            @if ($product->license_key)
                                <div class="license-details mt-3 pt-2 border-top">
                                    <dl>
                                        <dt style="font-weight: bold;">Kunci Lisensi:</dt>
                                        <dd><code style="font-size: 1.1em; padding: 2px 4px; background-color: #f0f0f0; border-radius: 4px;">{{ $product->license_key }}</code></dd>
                                        
                                        <dt style="font-weight: bold;" class="mt-2">Aktif Hingga:</dt>
                                        <dd>{{ $product->expiry_date ? \Carbon\Carbon::parse($product->expiry_date)->format('d F Y') : 'Seumur Hidup' }}</dd>
                                    </dl>
                                </div>
                            @endif
                            {{-- =========================================== --}}
                            {{-- ==== BLOK BARU UNTUK INFO LISENSI SELESAI ==== --}}
                            {{-- =========================================== --}}
                        </td>

                        <td>
                            <label>{{ trans('storefront::account.view_order.unit_price') }}</label>
                            <span class="product-price">
                                {{ $product->unit_price->convert($order->currency, $order->currency_rate)->format($order->currency) }}
                            </span>
                        </td>

                        <td>
                            <label>{{ trans('storefront::account.view_order.quantity') }}</label>
                            <span class="quantity">
                                {{ $product->qty }}
                            </span>
                        </td>

                        <td>
                            <label>{{ trans('storefront::account.view_order.line_total') }}</label>
                            <span class="product-price">
                                {{ $product->line_total->convert($order->currency, $order->currency_rate)->format($order->currency) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>