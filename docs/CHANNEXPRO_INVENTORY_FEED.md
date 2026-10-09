# MyShortlet -> ChannexPro inventory feed

This patch adds a new read-only JSON inventory endpoint for ChannexPro:

`GET /integration/channexpro/inventory`

## Authentication

The endpoint uses the ChannexPro-generated shared token from `config/services.php`.

Add or confirm this in the MyShortlet `.env`:

```env
CHANNEXPRO_SHARED_TOKEN=cp_live_copy_the_token_from_channexpro
```

Then clear cached configuration:

```bash
php artisan optimize:clear
```

## ChannexPro source settings

Use:

- Inventory URL: `https://myshortlet.com/integration/channexpro/inventory`
- API token: the `cp_live_...` value generated for this source in ChannexPro

ChannexPro sends the token as a Bearer token.

## Feed structure

The response uses the generic ChannexPro inventory contract:

- `properties[]`
- `properties[].room_types[]`
- `properties[].room_types[].rate_plans[]`

Each MyShortlet apartment becomes a ChannexPro room type. `quantity` becomes
`inventory_count`, occupancy comes from `max_adults` / `max_children`, and the
base apartment price is exported as USD.

## Legacy AVM / Channex work

Old `channex_*` IDs are intentionally **not** exported in fields that ChannexPro
recognizes as live mappings. They are included only below
`reference.legacy_channex` for inspection/reference.

Therefore a clean ChannexPro import will not reuse the previous AVM mapping by
accident. ChannexPro can create the new property/room/rate mappings when writes
are deliberately enabled there.

The existing `/integration/apartments/snapshot` endpoint and the existing AVM /
Channex code are left unchanged.
