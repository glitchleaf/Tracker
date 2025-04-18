<?php

namespace App\Models;

use App\Models\Contracts\HasDisplayName;
use App\Models\Traits\ChecksActiveEvent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @property string $name
 * @property string $description
 * @property float $hours
 * @property string $event_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read string $display_name
 * @property-read \App\Models\Event|null $event
 * @property-read int|null $events_count
 * @property-read \Illuminate\Database\Eloquent\Collection<\App\Models\Activity>|\App\Models\Activity[] $activities
 * @property-read int|null $activities_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reward forEvent(\App\Models\Event|string|null $event = null)
 * @method static \Database\Factories\RewardFactory<self> factory($count = null, $state = [])
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 *
 * @method static \Illuminate\Database\Eloquent\Builder|static query()
 * @method static static make(array $attributes = [])
 * @method static static create(array $attributes = [])
 * @method static static forceCreate(array $attributes)
 * @method \App\Models\Reward firstOrNew(array $attributes = [], array $values = [])
 * @method \App\Models\Reward firstOrFail($columns = ['*'])
 * @method \App\Models\Reward firstOrCreate(array $attributes, array $values = [])
 * @method \App\Models\Reward firstOr($columns = ['*'], \Closure $callback = null)
 * @method \App\Models\Reward firstWhere($column, $operator = null, $value = null, $boolean = 'and')
 * @method \App\Models\Reward updateOrCreate(array $attributes, array $values = [])
 * @method null|static first($columns = ['*'])
 * @method static static findOrFail($id, $columns = ['*'])
 * @method static static findOrNew($id, $columns = ['*'])
 * @method static null|static find($id, $columns = ['*'])
 */
class Reward extends Model implements HasDisplayName {
	/** @use HasFactory<\Database\Factories\RewardFactory> */
	use ChecksActiveEvent, HasFactory, HasUuids, LogsActivity, SoftDeletes;

	protected $fillable = [
		'name',
		'description',
		'hours',
	];

	public function getActivitylogOptions(): LogOptions {
		return LogOptions::defaults()
			->logOnly(['name', 'description', 'hours', 'event_id'])
			->logOnlyDirty()
			->submitEmptyLogs();
	}

	public function getDisplayNameAttribute(): string {
		return !$this->deleted_at ? $this->name : "{$this->name} (del)";
	}

	/**
	 * Get the event the reward is a part of
	 */
	public function event(): BelongsTo {
		return $this->belongsTo(Event::class)->withTrashed();
	}

	/**
	 * Scope a query to only include rewards for an event.
	 * If the event is not specified, then the active event will be used.
	 */
	public function scopeForEvent(Builder $query, Event|string|null $event = null): void {
		$query->where('event_id', $event->id ?? $event ?? Setting::activeEvent()?->id);
	}
}
