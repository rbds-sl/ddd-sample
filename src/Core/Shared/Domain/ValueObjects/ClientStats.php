<?php

declare(strict_types=1);

namespace CoverManager\Core\Shared\Domain\ValueObjects;

final readonly class ClientStats
{
    /**
     * Null indicates that the client has no data for that statistic.
     * First-x is used to invalidate the date.
     * For example, we have a "last 3-months stats".
     * If the first noShow is January, and we are in March, if we query data, the data is ok.
     * If we query data in April, the first noShow is invalidated, and we should not use it.
     * We have to recalculate the stats.
     * So we need a cron that runs every month to recalculate the stats o first-x < current month-3.
     * @param  int|null  $bookings
     * @param  int|null  $bookingsCancellations
     * @param  int|null  $bookingsNoShows
     * @param  int|null  $bookingTotalSpending
     * @param  int|null  $bookingAverageSpending
     * @param  int|null  $OnTheGoes
     * @param  int|null  $totalEcommerce
     * @param  int|null  $eCommerces
     * @param  int|null  $firstBookingNoShowDate
     * @param  int|null  $firstBookingCancellationDate
     * @param  int|null  $firstBookingReservationDate
     * @param  int|null  $averageRating
     */
    public function __construct(
        public ?int $bookings,
        public ?int $bookingsCancellations,
        public ?int $bookingsNoShows,
        public ?int $bookingTotalSpending, //cents
        public ?int $bookingAverageSpending, //cents
        public ?int $OnTheGoes,
        public ?int $totalEcommerce,
        public ?int $eCommerces,
        public ?int $firstBookingNoShowDate,
        public ?int $firstBookingCancellationDate,
        public ?int $firstBookingReservationDate,
        public ?int $averageRating, //0-100
    ) {
    }
}
