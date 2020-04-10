<?php

namespace App\Entities\Kanban;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Entities\Kanban\Column
 *
 * @property-read Collection|Card[] $cards
 * @property-read int $cards_count
 * @method static Builder|Column newModelQuery()
 * @method static Builder|Column newQuery()
 * @method static Builder|Column query()
 * @mixin Eloquent
 * @property int $id
 * @property string $name
 * @property int $board_id
 * @property int $position
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Column whereBoardId($value)
 * @method static Builder|Column whereCreatedAt($value)
 * @method static Builder|Column whereId($value)
 * @method static Builder|Column whereName($value)
 * @method static Builder|Column wherePosition($value)
 * @method static Builder|Column whereUpdatedAt($value)
 */
class Column extends Model
{
    protected $table = 'kanban_columns';

    protected $fillable = [
        'id',
        'name',
        'board_id',
        'position'
    ];

    /**
     * @return HasMany
     */
    public function cards()
    {
        return $this->hasMany(Card::class, 'column_id', 'id')->limit(10);
    }

    /**
     * @return int
     */
    public function getCardsCountAttribute()
    {
        return $this->cards()->count();
    }
}
