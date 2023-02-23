<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable=[
        'form_type',
        'form_number',
        'hoa',
        'gross',
        'pt_deduction',
        'tds',
        'gst',
        'gis',
        'telangana_haritha_nidhi',
        'net_amount'
    ];
    public function scrutinyAnswers(){
        return $this->hasMany(ScrutinyAnswers::class);
    }

    public function attachments(){
        return $this->hasMany(Attachment::class);
    }
    public function multipleParties(){
        return $this->hasMany(BillMultipleParty::class);
    }

    public function formType(){
        return $this->hasOne(FormType::class,'id','form_type');
    }
    public function hoa(){
        return $this->hasOne(Hoa::class,'hoa','hoa');
    }

}
