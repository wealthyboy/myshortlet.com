# MyShortlet / AVM -> ChannexPro ARI feed

This endpoint supplies booking-aware availability, daily rates and restrictions to ChannexPro.

```text
GET /integration/channexpro/ari?property_id=1&from=2026-10-08&to=2028-02-19
Authorization: Bearer <LIVE_EXPORT_TOKEN>
```

The same `LIVE_EXPORT_TOKEN` used by `/integration/channexpro/inventory` protects this endpoint.

## Initial load

ChannexPro should request 500 days for the first ARI sync. The date range is inclusive, so a 500-day window is today through today + 499 days.

The feed calculates availability from:

- apartment quantity / daily availability overrides;
- existing non-cancelled reservations whose stay overlaps the requested night;
- apartment active/disabled state.

The feed calculates the Standard Rate from the apartment's active default Channex rate plan when available, falling back to the apartment price. Daily ARI overrides are respected.

The response uses source IDs, not the old direct AVM -> Channex UUIDs:

- `room_type_id` = AVM apartment id;
- `rate_plan_id` = `standard:<apartment id>`.

ChannexPro maps those source IDs to its own Channex room/rate mappings before publishing `/availability` and `/restrictions`.

Rates in this source feed are expressed in major currency units (for example `665.50` USD). ChannexPro converts them to Channex minor units when publishing.
