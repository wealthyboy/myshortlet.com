# Website channel markup and markdown

Apartment edit → **Channel markup & markdown** opens `/admin/properties/{id}/channel-pricing`. Choose a channel supplied by ChannexPro, enter a signed percentage and/or signed USD fixed amount for each apartment, then save. Positive adds, negative subtracts; zero disables that adjustment. The percent is applied before the fixed amount. Previews use default rates; seasonal/daily prices receive the same rule.

Only staff with apartment permission can read or write these rules. Submitted apartments must belong to that property. Invalid markdowns and unknown channel codes are rejected atomically. Your website's direct price, stock, bookings and min-stay rules are unchanged.

Deploy ChannexPro's pricing update and migration first. Then deploy AVM, run `php artisan migrate --force`, clear caches and restart the database queue worker. The existing `CHANNEXPRO_SHARED_TOKEN` and configured source webhook URL are reused for the authenticated channel catalogue. There is no provider API key in this UI.

The ARI feed continues to export the original base rates, plus separate `channel_pricing` rules (`room_type_id`, canonical `channel`, `currency`, signed `percent`, signed `amount`). ChannexPro applies this source rule exactly once, then any additional ChannexPro workspace rule. Other systems, including WordPress, can implement the same JSON contract. An explicit empty rule list clears the source layer; omission preserves it for older clients.

Saving queues an `ari.updated` source event through the existing retryable delivery job. The ChannexPro handler re-fetches current ARI; the event contains no reservation or guest data. A saved/queued toast is not proof of channel delivery: check source-event and distribution activity in ChannexPro. Base-price/rate-plan edits in the apartment editor also notify ChannexPro when its connection is configured.

Start with one apartment/channel after deployment and verify the actual room-only rate on the OTA before applying bulk adjustments. No markup has been activated by adding this feature. OTA package discounts, promotions, taxes and commission may apply after the price you send.
