# Apartment elevator/accessibility display

The apartment card reads the existing selected **Accessibility** attributes—the
same `apartment_facilities` relation and parent category used by its information
modal. There is no separate admin dropdown to maintain.

The backend appends `accessibility_label` from the selected Accessibility items
whose names mention elevator/lift. For example, **Elevator Access** or
**Stairs (No Elevator)** is passed unchanged to the card and displayed beside the
elevator SVG below the floor. No matching selection means no elevator row. This
does not infer wheelchair access or infer elevator availability from a floor.

Listing/detail requests already eager-load these attributes and parents. The
availability response also loads them so filtered cards retain the same label.
The accessor does not introduce per-card lazy queries when models are serialized.

The duplicate elevator dropdown and its save logic have been removed. The old
`elevator_access` column, if already migrated, is ignored and hidden from the
serialized apartment. Its historical migration is retained to avoid rewriting
deployment history; no rollback, data deletion or new migration is required for
this correction.

## Deployment

Deploy the source, rebuild the frontend with `npm run production`, and clear
compiled views with `php artisan view:clear`. The verified local build uses Node
22; the project's existing Mix/yargs toolchain is not compatible with Node 26.

The generated `public/js/services_js.js` is tracked and served directly by the
website. Include its rebuilt version in the deployment; updating Vue source
alone leaves the old card running. The frontend test also checks this shipped
bundle for the corrected field. On local machines with an incompatible desktop
notification helper, set `DISABLE_NOTIFICATIONS=1` when building.

## Checks

`php vendor/bin/phpunit --filter ApartmentAccessibilityTest`

`node --test tests/Frontend/elevator-access.test.cjs`

Verify one apartment with **Elevator Access**, one with **Stairs (No Elevator)**,
and one with no matching attribute. The modal and card must show the same text.
Change the existing attribute selection and confirm both update together.
