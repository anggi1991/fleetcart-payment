<?php

namespace Modules\Order\Entities;

use Modules\Media\Entities\File;
use Modules\Support\Eloquent\Model;
use Modules\Order\Entities\OrderProduct; // 'use' ini sudah benar ada

class OrderDownload extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['file'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['file_id'];


    public function getRealPathAttribute()
    {
        return $this->file->realPath();
    }


    public function getFilenameAttribute()
    {
        return $this->file->file_name;
    }


    public function file()
    {
        return $this->belongsTo(File::class);
    }
    
    
    // ========================================================= //
    // ==== TAMBAHKAN FUNGSI BARU DI BAWAH INI                ==== //
    // ========================================================= //
    /**
     * Get the order product that this download belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order_product()
    {
        // Fungsi ini memberitahu Laravel bahwa setiap OrderDownload
        // "milik dari" (belongs to) satu OrderProduct.
        return $this->belongsTo(OrderProduct::class);
    }
    // =========================================== //
    // ==== AKHIR DARI FUNGSI BARU              ==== //
    // =========================================== //
}