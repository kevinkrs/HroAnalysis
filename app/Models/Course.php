<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 09 Apr 2018 09:48:34 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Course
 * 
 * @property string $course_code
 * @property string $name
 * @property string period
 * 
 * @property \Illuminate\Database\Eloquent\Collection $feedback
 *
 * @package App\Models
 */
class Course extends Eloquent
{
	protected $primaryKey = 'course_code';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'name',
		'period',
	];

	public function feedback()
	{
		return $this->hasMany(\App\Models\Feedback::class, 'course');
	}
}
