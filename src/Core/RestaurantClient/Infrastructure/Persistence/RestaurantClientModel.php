<?php

declare(strict_types=1);

namespace CoverManager\Core\RestaurantClient\Infrastructure\Persistence;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $app
 * @property string $app_client_id
 * @property string $status
 * @property string $identification JSON string containing client identification data (deprecated)
 * @property string $first_name Client's first name
 * @property string|null $last_name Client's last name
 * @property string|null $email Client's email
 * @property string|null $phone Client's phone
 * @property string|null $phone_country_code Client's phone country code
 * @property string $preferences JSON string containing client preferences
 * @property string $stats JSON string containing client statistics
 * @property string $last_3_months_stats JSON string containing client statistics for the last 3 months
 * @property int|null $stats_updated_at
 * @property string|null $language
 * @property string|null $company_name
 * @property string|null $address JSON string containing address information
 * @property string $marketing_subscription JSON string containing marketing subscription information
 * @property string $integrations JSON string containing integration information
 * @property int|null $dob Date of birth as timestamp
 * @property string $custom_properties JSON string containing custom properties
 * @property string|null $restaurant_id ID of the associated restaurant
 * @property int $created_at
 * @property int $updated_at
 * @property int $added_at
 */
final class RestaurantClientModel extends Model
{
    protected $table = 'crm_restaurant_clients';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'app',
        'app_client_id',
        'status',
        'first_name',
        'last_name',
        'email',
        'phone',
        'phone_country_code',
        'preferences',
        'stats',
        'last_3_months_stats',
        'stats_updated_at',
        'language',
        'company_name',
        'address',
        'marketing_subscription',
        'integrations',
        'dob',
        'custom_properties',
        'restaurant_id',
        'added_at',
    ];
}
