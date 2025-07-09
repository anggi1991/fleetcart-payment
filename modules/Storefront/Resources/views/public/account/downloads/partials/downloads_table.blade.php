<div class="table-responsive">
    <table class="table table-borderless my-downloads-table">
        <thead>
            <tr>
                {{-- Kolom 1: Nama Produk & Lisensi --}}
                <th>{{ trans('storefront::account.downloads.filename') }}</th>
                
                {{-- Kolom 2: Tanggal Kadaluwarsa --}}
                <th>{{ trans('storefront::account.downloads.expiry_date') }}</th>
                
                {{-- Kolom 3: Aksi/Tindakan --}}
                <th>{{ trans('storefront::account.action') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($downloads as $download)
                <tr>
                    <td>
                        {{-- Menampilkan Nama Produk (dengan fallback ke nama file) --}}
                        <strong>{{ $download->order_product->product->name ?? $download->filename }}</strong>

                        {{-- Menampilkan Kunci Lisensi jika ada --}}
                        @if ($download->license_key)
                            <div class="license-key-wrapper mt-2">
                                <small>{{ trans('storefront::account.downloads.license_key') }}:</small><br>
                                <code>{{ $download->license_key }}</code>
                            </div>
                        @endif
                    </td>

                    <td>
                        {{-- Menampilkan tanggal kadaluwarsa atau teks "Lifetime" dari file bahasa --}}
                        {{ $download->expiry_date ? $download->expiry_date->format('d F Y') : trans('storefront::account.downloads.lifetime') }}
                    </td>

                    <td>
                        {{-- Tombol Download hanya akan muncul jika memang ada file --}}
                        @if ($download->url_is_present)
                            <a href="{{ route('account.downloads.show', encrypt($download->id)) }}" class="btn btn-primary btn-sm" title="{{ trans('storefront::account.downloads.download') }}">
                                <i class="las la-cloud-download-alt"></i>
                                {{ trans('storefront::account.downloads.download') }}
                            </a>
                        @else
                            <span class="text-muted">--</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>