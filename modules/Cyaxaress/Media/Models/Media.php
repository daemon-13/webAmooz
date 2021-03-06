<?php
namespace Cyaxaress\Media\Models;

use Cyaxaress\Media\Services\MediaFileService;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $casts = [
        'files' => 'json'
    ];

    protected static function booted(){
        static::deleting(function ($media) {
            MediaFileService::delete($media);
        });
    }

    public function getThumbAttribute()
    {
       return  !isset($this->files[300]) ?'': '/storage/' .  $this->files[300] ;
    }
}
