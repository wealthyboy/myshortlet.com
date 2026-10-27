# Apartment elevator access

Each apartment now has a nullable `elevator_access` boolean. Existing records remain
unspecified; no elevator or wheelchair-accessibility claim is inferred from the floor.

In Admin → Apartments → Create/Edit, use **Accessibility — elevator access**:

- Elevator access
- No elevator access
- Not specified (clears a previously saved value)

The apartment cards and details show a matching elevator icon and text below the
floor when either yes or no is confirmed. Unspecified values are not shown publicly.
Older save requests that omit the field preserve an existing setting. Invalid
values are rejected before saving. The JSON apartment resource exposes a boolean
or null for the frontend. This feature does not add an OTA accessibility mapping.

## Deployment

Deploy the source, run `php artisan migrate --force`, compile the frontend with
`npm run production`, then run `php artisan view:clear`. The migration must run
before using the new admin field. The frontend must be rebuilt to show the new row.

The existing frontend was successfully compiled using the installed Node 22 runtime.
The local Node 26 runtime is incompatible with this project's existing yargs/Mix
toolchain. No dependencies or runtime configuration were changed for this feature.

## Verification

`php vendor/bin/phpunit --filter ApartmentAccessibilityTest`

`node --test tests/Frontend/elevator-access.test.cjs`

Check a confirmed yes, a confirmed no and an unspecified apartment. Verify that the
floor, bedroom details and price remain readable on small screens, and that the
selected option survives an edit and a validation error.
