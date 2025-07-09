<?php

namespace Modules\Order\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Modules\Order\Entities\OrderProduct; // Pastikan model OrderProduct di-import

class OrderProductLicenseController
{
    /**
     * Update the license information for the specified order product.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Modules\Order\Entities\OrderProduct $order_product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, OrderProduct $order_product)
    {
        // Validasi data yang masuk dari form
        $request->validate([
            'license_key' => 'nullable|string',
            'expiry_date' => 'nullable|date',
        ]);

        try {
            // Update data di database
            $order_product->update([
                'license_key' => $request->license_key,
                'expiry_date' => $request->expiry_date,
            ]);

            // Kirim respons sukses dalam format JSON
            return response()->json(['message' => 'Lisensi berhasil disimpan!'], 200);

        } catch (\Exception $e) {
            // Kirim respons error jika gagal
            return response()->json(['message' => 'Gagal menyimpan: ' . $e->getMessage()], 500);
        }
    }
}