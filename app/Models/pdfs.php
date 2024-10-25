<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pdfs extends Model
{
    public $timestamps = false;
    protected $fillable = ['qrcode_id', 'pdf_path'];

    public function qrcode()
    {
        return $this->belongsTo(QrCodeModel::class);
    }
}
