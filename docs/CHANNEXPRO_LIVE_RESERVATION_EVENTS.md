# ChannexPro live reservation events

AVM is the source system. Reservation lifecycle changes are sent to ChannexPro first; AVM no longer uses the reservation observers to write ARI directly to Channex.

Flow:

1. AVM reservation created / moved / edited / cancelled / deleted.
2. AVM queues a `channexpro.source-event.v1` event after the database transaction commits.
3. AVM POSTs the event to `https://channexpro.com/api/v1/source/webhook` with the shared `cp_live_...` token.
4. ChannexPro mirrors the source reservation for its calendar.
5. ChannexPro pulls authoritative ARI from AVM only for the affected date window.
6. ChannexPro publishes the resulting availability/rates/restrictions to Channex.

Required AVM environment value:

```env
CHANNEXPRO_SHARED_TOKEN=cp_live_...
```

Optional overrides:

```env
CHANNEXPRO_URL=https://channexpro.com
CHANNEXPRO_WEBHOOK_URL=https://channexpro.com/api/v1/source/webhook
CHANNEXPRO_EVENTS_ENABLED=true
```

The source-specific token is the same token ChannexPro uses when pulling AVM inventory and ARI.
