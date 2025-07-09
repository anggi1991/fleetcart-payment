<div class="items-ordered-wrapper">
    <h4 class="section-title">{{ trans('order::orders.items_ordered') }}</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="items-ordered">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ trans('order::orders.product') }}</th>
                                <th>{{ trans('order::orders.unit_price') }}</th>
                                <th>{{ trans('order::orders.quantity') }}</th>
                                <th>{{ trans('order::orders.line_total') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($order->products as $item)
                                <tr>
                                    <td>
                                        @if ($item->trashed())
                                            {{ $item->name }}
                                        @else
                                            <a href="{{ route('admin.products.edit', $item->product->id) }}">{{ $item->name }}</a>
                                        @endif
                                        
                                        {{-- Kode untuk menampilkan variasi dan opsi produk --}}
                                        @if ($item->hasAnyVariation())
                                            {{-- ... kode variasi Anda ... --}}
                                        @endif

                                        @if ($item->hasAnyOption())
                                            {{-- ... kode opsi Anda ... --}}
                                        @endif

                                        {{-- Form Input Lisensi untuk Admin --}}
                                        <div class="license-form-wrapper mt-3 pt-3 border-top">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="license_key_{{ $item->id }}">Kunci Lisensi:</label>
                                                        <input type="text" id="license_key_{{ $item->id }}" class="form-control license-key-input" value="{{ $item->license_key }}" placeholder="Masukkan kunci lisensi...">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="expiry_date_{{ $item->id }}">Tgl. Kadaluwarsa:</label>
                                                        <input type="date" id="expiry_date_{{ $item->id }}" class="form-control expiry-date-input" value="{{ optional($item->expiry_date)->format('Y-m-d') }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 d-flex align-items-end">
                                                    <div class="form-group">
                                                        <button class="btn btn-primary btn-sm save-license-btn" data-id="{{ $item->id }}" type="button">
                                                            Simpan
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <small class="form-text text-muted license-status" id="status_{{ $item->id }}"></small>
                                        </div>
                                    </td>
                                    <td>{{ $item->unit_price->format() }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>{{ $item->line_total->format() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- PERBAIKAN: Blok @push diletakkan di sini, setelah semua elemen HTML dari komponen ini selesai --}}
@push('scripts')
<script>
    // Pastikan jQuery sudah termuat di halaman admin Anda
    $(document).ready(function() {
        // Event listener untuk semua tombol dengan class .save-license-btn
        $('.save-license-btn').on('click', function(e) {
            e.preventDefault(); // Mencegah aksi default tombol

            var button = $(this);
            var itemId = button.data('id');
            var licenseKey = $('#license_key_' + itemId).val();
            var expiryDate = $('#expiry_date_' + itemId).val();
            var statusElement = $('#status_' + itemId);

            // URL untuk AJAX request
            var url = "{{ url('/admin/order-products') }}/" + itemId + "/update-license";

            // Update UI untuk memberitahu user proses sedang berjalan
            statusElement.text('Menyimpan...').removeClass('text-success text-danger').addClass('text-muted');
            button.prop('disabled', true);

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}', // Token keamanan Laravel
                    'license_key': licenseKey,
                    'expiry_date': expiryDate
                },
                success: function(response) {
                    // Tampilkan pesan sukses
                    statusElement.text(response.message).removeClass('text-muted').addClass('text-success');
                    setTimeout(function(){ statusElement.text('Data tersimpan di database.'); }, 3000);
                },
                error: function(xhr) {
                    // Tampilkan pesan error
                    var errorMessage = xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan.';
                    statusElement.text(errorMessage).removeClass('text-muted').addClass('text-danger');
                },
                complete: function() {
                    // Aktifkan kembali tombol setelah proses selesai
                    button.prop('disabled', false);
                }
            });
        });
    });
</script>
@endpush