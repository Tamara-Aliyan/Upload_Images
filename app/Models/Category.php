<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\HasImagesTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory,HasImagesTrait;
    protected $fillable = ['name'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    protected $appends = ['created_from'];

    public function getCreatedFromAttribute()
    {
        return $this->getTimeDiffForAttribute($this->created_at);
    }

    private function getTimeDiffForAttribute($date)
    {
        $carbonDate = Carbon::parse($date);
        $diff = $carbonDate->diffForHumans();

        return $diff;
    }
}
