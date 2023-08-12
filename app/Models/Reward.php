<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reward extends UuidModel {
	use HasFactory;

	/**
	 * Get the event the reward is a part of
	 */
	public function event(): BelongsTo {
		return $this->belongsTo(Event::class);
	}

	/**
	 * Scope a query to only include rewards for an event.
	 * If the event is not specified, then the active event will be used.
	 */
	public function scopeForEvent(Builder $query, Event|string $event = null): void {
		$query->where('event_id', $event->id ?? $event ?? Setting::activeEvent()?->id);
	}
}
