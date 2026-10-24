# Missing reservation currency column and paid-booking recovery

## Confirmed production failure

The payment webhook receives `charge.success`, but inserting the reservation
fails with `Unknown column 'currency' in 'field list'` on `reservations`.
The old apartment migration adds `currency` only when `apartment_id` does not
exist. The corrective migration checks `currency` independently.

## Targeted schema repair

After uploading the reviewed migration and verifying a current database backup,
run only this migration from `/home/forge/avenuemontaigne.ng`:

```sh
php artisan migrate --path=database/migrations/2026_10_15_230000_ensure_currency_column_on_reservations_table.php --force
```

This adds a nullable column if it is absent. It does not delete or recreate
reservations, change existing amounts, or charge a customer. Its rollback does
not drop the column or remove saved currency values.

## Recover the existing paid booking

Do not blindly replay the webhook. The current handler creates guest and
`user_reservations` records before inserting the individual reservation, without
an enclosing database transaction or a payment-reference deduplication guard.
Previous failed attempts may therefore have left partial records.

Before recovery:

1. Obtain the original Paystack reference and transaction payload. Keep secret
   keys and card authorization details out of logs and shared files.
2. Verify the reference server-side with Paystack: transaction status, amount,
   currency, customer, and the booking IDs in its original metadata.
3. Compare the saved booking details, apartment, dates, selected extras, coupon,
   frozen pricing, and availability. Inspect matching partial reservation
   headers and existing reservation lines before choosing a recovery target.
4. Complete exactly one reservation in a database transaction. Preserve the
   paid amount and currency; do not take another payment. Do not silently delete
   other records or select an ambiguous partial record.
5. After commit, send the existing `ReservationReceipt` to the verified guest,
   CC `info@avenuemontaigne.ng` and BCC `frontdesk@avenuemontaigne.ng`. Confirm
   delivery, not just that a send was attempted. Ensure the normal reservation
   observer queues the ChannexPro inventory event and verify its processing.
6. Verify the final reservation, receipt and inventory status against the same
   payment reference before treating recovery as complete.

The production recovery must be scoped to the supplied, verified payment. The
schema migration alone does not recover a booking, prove email delivery, or
add payment-reference deduplication to the existing webhook.

## Operator-confirmed exception: 15 October 2026

The operator confirmed that payment succeeded and explicitly deferred obtaining
the Paystack reference/verification. This recovery is **manual**, not a claim of
gateway verification. It initiates no charge, refund or transfer.

- Reused header **3818**, invoice **INV-2026-1210495662**; created reservation
  **3760**, apartment **58 / Black Onyx**, 23–26 October 2026, quantity 1.
- Preserved the original USD 957 quote and its source snapshot in
  `pricing_snapshot.manual_recovery`. The actual gateway amount/currency and
  reference remain unverified; the quote is not proof of those facts.
- Converted the booking/receipt to NGN at the site's retrieved USD→NGN rate
  **1331.83**: **NGN 1,274,561.31** total, **NGN 424,853.77** precise nightly
  price. The legacy whole-number `reservations.price` column is rounded; the
  pricing snapshot and recovered receipt retain the precise nightly amount.
- `checked` is also used for guest check-in: its original value is preserved.
  The explicit operator payment confirmation is separate recovery metadata.
- The targeted currency migration was applied; no other migrations were run.
- The normal observer's inventory event was delivered to ChannexPro (event 16).
- The receipt was accepted by ZeptoMail for the guest plus the usual CC/BCC,
  with client reference `avm-recovery-3818-20261015`. Inbox delivery is **not
  confirmed**: the email-log endpoint rejected the configured authorization.
- Other failed parent records, guest records and cart quotes were not deleted.
- Private affected-record/schema and source-file backups are on the server at
  `storage/app/recovery-3818-20261015/` (directory mode 0700).

`ManualBookingRecovery::prepare()` freezes the source data and explicit retry
cart IDs before schema repair. `complete()` checks availability and completes
the same header transactionally and idempotently. The webhook intercepts only
those recorded cart IDs for that guest and logs any callback reference for
reconciliation; it does not create a duplicate booking or send a second receipt.
This scoped guard is not general payment-reference deduplication. If another
payment was taken for one of those carts, the logged reference requires manual
reconciliation; it is not silently treated as gateway-verified or refunded.

Do not rerun the email send blindly. Inspect the recorded receipt attempt first.
To reconcile later, obtain the Paystack reference and independently verify the
actual settled amount/currency against the preserved quote and manual recovery.

Focused regression tests (isolated in-memory SQLite, never the configured DB):

```sh
php vendor/bin/phpunit --filter 'ManualBookingRecoveryTest|ReservationCurrencyMigrationTest'
```

## USD correction: 16 October 2026 (supersedes the naira record above)

The operator clarified that the payment was in USD and explicitly requested an
in-place correction and a replacement receipt, not another reservation.

- `ManualBookingRecovery::restoreOriginalCurrency(3818)` restores the immutable
  source quote, not a new exchange rate or the operator/browser's current currency.
- Header **3818**, reservation **3760**, invoice **INV-2026-1210495662**, guest,
  quantity and stay dates are unchanged. Current total is **USD 957.00**, nightly
  price **USD 319.00**, exchange rate **1** on both header and reservation.
- The former NGN header/line amounts and snapshot are retained under
  `manual_recovery.currency_correction`; the initial naira email audit is kept.
- The correction queues an update for the same downstream source reservation.
- The corrected email explicitly replaces the earlier naira receipt and says
  that the booking is unchanged and no additional payment has been taken.
  ZeptoMail accepted it for the same customer plus the usual CC/BCC recipients,
  with reference `avm-recovery-3818-usd-correction-20261016`. Inbox delivery remains
  unconfirmed because email-log authorization is unavailable.
- The source backup, former NGN records and corrected receipt preview are stored
  privately on production under
  `storage/app/recovery-3818-20261015/usd-correction-20261016/`.
- Payment verification is still deferred. The currency confirmation came from
  the operator; no charge, refund or gateway transaction was performed.

The correction is transactional and repeatable without creating a header or
reservation. It refuses to overwrite a recovery whose total or stay was edited.
The automatic storefront currency rules and normal payment/receipt flow were
not changed. An explicit resend attempt is tracked separately at
`manual_recovery.currency_correction.receipt`; do not resend blindly.
