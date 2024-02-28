<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\HasImagesTrait;
use App\Models\Scopes\PriceFilterScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory,HasImagesTrait;

    protected $fillable = ['name','description','price','user_id','category_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeUserNameContainsA($query)
    {
        return $query->whereHas('user', function ($subquery) {
            $subquery->where('name', 'like', '%a%');
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new PriceFilterScope);
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
