{{-- ========================================================= --}}
{{-- ==== ISI FILE: tax.blade.php (Versi Alpine.js)       ==== --}}
{{-- ========================================================= --}}
<div class="tax-invoice-section mt-4 pt-4 border-top">
    <h4 class="section-title">{{ trans('storefront::checkout.tax_information') }}</h4>

    <div class="form-group">
        <div class="form-check">
            <input
                type="checkbox"
                name="tax_invoice_request"
                class="form-check-input"
                id="tax_invoice_request"
                value="1"
                {{-- Dihubungkan ke Alpine.js --}}
                x-model="form.tax_invoice_request"
            >
            
            <label class="form-check-label" for="tax_invoice_request">
                {{ trans('storefront::checkout.i_need_a_tax_invoice') }}
            </label>
        </div>
    </div>

    {{-- Form ini akan muncul/hilang berdasarkan state di Alpine.js --}}
    <div class="tax-invoice-form" id="tax-invoice-form" x-show="form.tax_invoice_request" x-cloak>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="taxpayer_name">
                        {{ trans('storefront::checkout.taxpayer_name') }}<span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="taxpayer_name"
                        id="taxpayer_name"
                        class="form-control"
                        {{-- Dihubungkan ke Alpine.js --}}
                        x-model="form.taxpayer_name"
                    >
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="taxpayer_id_number">
                        {{ trans('storefront::checkout.taxpayer_id_number') }}<span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="taxpayer_id_number"
                        id="taxpayer_id_number"
                        class="form-control"
                        {{-- Dihubungkan ke Alpine.js --}}
                        x-model="form.taxpayer_id_number"
                    >
                </div>
            </div>
        </div>
    </div>
</div>

{{-- TIDAK PERLU ADA BLOK @push('scripts') LAGI DI SINI --}}