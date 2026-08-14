# Channex PMS Certification Runbook

This runbook maps Channex certification tests to normal MyShortlet PMS actions. Do not use scripts, Postman, or hardcoded certification payloads.

## Supported product model

- Multiple room types: **Yes** — each apartment maps to one Channex room type.
- Multiple rate plans per room type: **Yes** — each apartment can own multiple independently mapped Channex rate plans.
- Min Stay Arrival: **Yes**.
- Min Stay Through: **Yes**.
- Stop Sell, CTA, CTD and Max Stay: **Yes**.
- Raw credit-card details: **Not requested or stored**.
- PCI status: **The PMS remains out of PCI scope and must not receive raw card data.**

For the certification property, create Best Available Rate and Bed & Breakfast Rate under both Twin Room and Double Room. The PMS stores every returned Channex rate-plan ID separately.

## Required deployment state

1. Deploy the `2026_07_26` migrations and `2026_07_28_000001_extend_channex_rate_plans_for_multiple_plans`.
2. Configure staging `CHANNEX_BASE_URL`, `CHANNEX_API_KEY`, `CHANNEX_WEBHOOK_SECRET`, and `CHANNEX_WEBHOOK_SECRET_HEADER`.
3. Set `CHANNEX_ARI_LIMIT_PER_MINUTE=20` and `CHANNEX_ARI_ENDPOINT_LIMIT_PER_PROPERTY=10`.
4. Use a shared production cache such as Redis for cross-worker rate limiting.
5. Run a persistent Laravel queue worker and the Laravel scheduler every minute.
6. Expose `POST /webhook/channex` over HTTPS and configure the same secret in Channex.
7. Confirm every test apartment has local-to-Channex property, room-type and rate-plan IDs.

## PMS paths used during certification

- Rate-plan setup: **Admin → Apartments → Edit → Channex Rate Plans**.
- Daily prices, availability and restrictions: **Admin → Integrations → Channex ARI Updates** (`/admin/channex/ari-updates`).
- Full sync: **Admin → Properties → Full Sync (500 Days)**. The button submits a CSRF-protected `POST /admin/properties/full-sync` request.
- Task evidence: **Admin → Integrations → Channex Logs**.
- Booking evidence: normal admin reservation screens and reservation details.

## Tests 1–14

### 1. Full Data Update

Before running full sync, use Rates & Availability to enter realistic date ranges with varied prices, availability and restrictions. Trigger the property Full Sync action once. Expected result: exactly one `/availability` task and one `/restrictions` task covering 500 days.

### 2. Single Date / Single Rate

Save one price change for the requested apartment and date from Rates & Availability. Confirm one restriction task ID.

### 3. Single Date / Multiple Rates

Select each applicable room/rate-plan combination and save all rows in one form submission. The outbox batches them into one restriction call.

### 4. Multiple Dates / Multiple Rates

Save the requested date ranges together in one submission. Confirm one restriction task containing all applicable ranges.

### 5. Min Stay

Save Min Stay Arrival and/or Min Stay Through values for all applicable rows together. Confirm one restriction task.

### 6. Stop Sell

Set Stop Sell to true for all applicable rows together. Confirm one restriction task.

### 7. Multiple Restrictions

Save CTA, CTD, Min Stay and Max Stay together for the requested ranges. Confirm one restriction task.

### 8. Half-Year Update

Save the long date ranges and restrictions together. Confirm one restriction task. The values persist as daily PMS state and are used by later full syncs.

### 9. Single-Date Availability Through Booking

Set the room capacities in Rates & Availability, then create a real reservation from the normal customer or admin reservation workflow. Reservation observers recalculate the occupied nights and enqueue availability. Confirm one batched availability task and show the booking in the PMS.

### 10. Multiple-Date Availability

Save the requested availability ranges in one Rates & Availability submission, or create/block reservations covering those ranges. Confirm one availability task (or the allowed two when separate events are processed).

### 11. Booking Receiving

Create a Booking CRS or Booking.com test booking in Channex, then modify and cancel it. For every revision verify:

- the webhook returns HTTP 200;
- a queued booking job is created;
- the revision is pulled exactly once, either from `/booking_revisions/feed` or `/booking_revisions/{id}`;
- the booking is created/updated/cancelled in MyShortlet;
- `POST /booking_revisions/{id}/ack` succeeds;
- the certification log records a successful booking acknowledgment.

Capture screenshots of the reservation list/details and retain the received booking ID.

### 12. Rate Limits

Answer **Yes**. ARI is queued and batched, limited to 20 total calls/minute and 10 calls per endpoint/property/minute, with delayed job retries.

### 13. Update Logic

Answer **Yes**. Normal saves and reservation lifecycle events create delta outbox rows. Full sync is an explicit recovery/go-live action, not a recurring five-minute timer.

### 14. Extra Notes answers

- Min Stay Through and Arrival: **Both supported**.
- Stop Sell, CTA, CTD and Max Stay: **Supported**.
- Multiple room types: **Supported**.
- Multiple rate plans per room type: **Supported**.
- Credit-card details required: **No**.
- PCI: **Raw card details are not requested or stored; configure channels/tokenization to keep the PMS out of PCI scope**.

## Evidence to collect

For each scenario save the task ID, request time, scenario/reference label, property, user action and result. Do not submit until every applicable test has a successful task ID and test 11 has new/modify/cancel screenshots plus acknowledgment evidence.

## Live testing call rehearsal

Use the mapped certification property and keep **Admin → Integrations → Channex Logs** open in a second tab.

1. **Full sync**
   - Open **Admin → Properties**.
   - Click **Full Sync (500 Days)** for the mapped property and confirm.
   - Show that the job is queued, then show exactly one successful availability task and one successful restrictions task.
2. **Create a PMS booking**
   - Note the room's availability before creating the booking.
   - Create a normal PMS reservation for the mapped apartment.
   - Show the booking in the reservation list and show the successful Channex availability task.
   - Confirm only occupied nights are present in the outbox payload.
3. **Modify the booking**
   - Open **More details** and extend checkout by one night.
   - Show that only the newly added or removed night is sent to Channex; unchanged nights must not be resent.
4. **Cancel the booking**
   - Return to the reservation list and click **Cancel**.
   - Show one compressed availability update restoring all occupied nights.
   - Confirm the booking is marked cancelled locally.

Verified rehearsal on 30 July 2026:

- Create task `afd227fc-781d-44b8-a871-89c21dbfca2c`: 10–11 June 2027 changed from availability 1 to 0.
- Modify task `61711dda-f1dc-4d4c-b741-dbfb41b70884`: only 12 June 2027 changed from availability 1 to 0.
- Cancel task `9a3f95d7-8f4f-4bf0-9f6b-bf24d7f8346d`: 10–12 June 2027 restored to availability 1.
