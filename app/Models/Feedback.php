<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 09 Apr 2018 09:48:34 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Feedback
 * 
 * @property int $id
 * @property string $feedback
 * @property int $grade
 * @property \Carbon\Carbon $timestamp_received_date
 * @property string $course
 * @property string $location
 * @property int $import
 * @property int $period
 * 
 *
 * @package App\Models
 */
class Feedback extends Eloquent
{
	protected $table = 'feedbacks';
	public $timestamps = false;

	protected $casts = [
		'grade' => 'int',
		'import' => 'int',
	];

	protected $dates = [
		'timestamp_received_date'
	];

	protected $fillable = [
		'feedback',
		'grade',
		'timestamp_received_date',
		'course',
		'location',
		'import',
	];

	public function course()
	{
		return $this->belongsTo(\App\Models\Course::class, 'course');
	}

	public function import()
	{
		return $this->belongsTo(\App\Models\Import::class, 'import');
	}

	public function location()
	{
		return $this->belongsTo(\App\Models\Location::class, 'location');
	}
}
