<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 09 Apr 2018 09:48:34 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Import
 *
 * @property int $id
 * @property string $hash
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \Illuminate\Database\Eloquent\Collection $feedback
 *
 * @package App\Models
 */
class Import extends Eloquent
{
    public function feedback()
    {
        return $this->hasMany(\App\Models\Feedback::class, 'import');
    }
}
