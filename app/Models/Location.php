<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 09 Apr 2018 09:48:34 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Location
 *
 * @property string $location_code
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \Illuminate\Database\Eloquent\Collection $feedback
 *
 * @package App\Models
 */
class Location extends Eloquent
{
    protected $primaryKey = 'location_code';
    public $incrementing = false;

    protected $fillable = [
        'name'
    ];

    public function feedback()
    {
        return $this->hasMany(\App\Models\Feedback::class, 'location');
    }
}
