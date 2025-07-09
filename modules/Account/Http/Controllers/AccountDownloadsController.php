<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderDownload; 

class AccountDownloadsController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
        public function index()
    {
        return view('storefront::public.account.downloads.index', [
            'downloads' => $this->getDownloads(),
        ]);
    }



    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $file = $this->getDownloads()->firstWhere('id', decrypt($id));

        if (is_null($file) || !file_exists($file->realPath())) {
            return back()->with('error', trans('storefront::account.downloads.no_file_found'));
        }

        return response()->download($file->realPath(), $file->filename);
    }


    private function getDownloads()
    {
        $orderIds = auth()->user()->orders()->where('status', Order::COMPLETED)->pluck('id');

        // Ambil data dari order_downloads dan muat relasi yang dibutuhkan
        $downloads = OrderDownload::whereIn('order_id', $orderIds)
            ->with([
                'file', // Relasi ke file itu sendiri
                'order_product.product', // Relasi dari order_download ke order_product, lalu ke product
            ])
            ->get();

        // Proses koleksi untuk menambahkan data custom kita
        return $downloads->map(function ($download) {
            if (! optional($download)->file || ! optional($download)->order_product) {
                return null;
            }

            $file = $download->file; // Ambil objek file dari relasi
            
            // "Tempelkan" data yang kita butuhkan dari order_product
            $file->order_product = $download->order_product;
            $file->license_key = $download->order_product->license_key;
            $file->expiry_date = $download->order_product->expiry_date ? Carbon::parse($download->order_product->expiry_date) : null;
            $file->url_is_present = ! is_null($file->id);
            
            return $file;
        })->filter()->unique('id');
    }
}
