<?php

declare(strict_types=1);

namespace CoverManager\Core\Restaurant\Infrastructure\Persistence;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $app
 * @property string $app_restaurant_id
 * @property string $name
 * @property string $status
 * @property int $created_at
 * @property int $updated_at
 */
final class RestaurantModel extends Model
{
    protected $table = 'crm_restaurants';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';


    protected $fillable = [
        'id',
        'app',
        'app_restaurant_id',
        'name',
        'status',
    ];
}
