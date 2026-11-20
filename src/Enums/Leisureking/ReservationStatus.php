<?php

namespace SOSEventsBV\Cms\Enums\Leisureking;

/**
 * The status of a reservation as returned by LeisureKing.
 *
 * @see https://leisureking.atlassian.net/wiki/spaces/LM/pages/3997808/3.9+Reservering+statussen
 */
enum ReservationStatus: string
{
    /**
     * The reservation was created manually in LeisureKing and has no detail rows yet.
     * Informational status only.
     */
    case Requested = 'requested';

    /**
     * The reservation is incomplete and can be finished at a later moment.
     */
    case RequestInProgress = 'request_in_progress';

    /**
     * The reservation has been placed but not paid yet.
     * Once paid, it moves to Reserved. If payment is not received within
     * the configured time limit, it is canceled automatically.
     */
    case WaitingForPayment = 'waiting_for_payment';

    /**
     * The payment was made outside LeisureKing and must be verified manually.
     * Informational status only.
     */
    case CheckingPayment = 'checking_payment';

    /**
     * The reservation is confirmed.
     */
    case Reserved = 'reserved';

    /**
     * The reservation is currently in use.
     * Set once the items have been handed out ("Uitgeven" in LeisureKing).
     */
    case Active = 'active';

    /**
     * The reservation is completed, but stock is still reserved.
     */
    case PostponedCompleted = 'postponed_completed';

    /**
     * The reservation is completed and all items/products have been returned.
     */
    case Completed = 'completed';

    /**
     * The reservation was canceled, either by the user or automatically due to missing payment.
     */
    case Cancelled = 'cancelled';
}
