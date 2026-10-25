# Apartment photo finder

Admin page: `/admin/photo-finder`, also linked from Apartments and each apartment
edit page. The same apartment-management permission (`2`) protects browsing,
comparison, preparation and tag changes. It is not a public reverse-image API.

## Deploy and use

Run `php artisan migrate --force`, then `php artisan optimize:clear` after
deploying this AVM repository. PHP GD with JPEG/PNG/WebP support is required.
No API key, paid AI provider, new queue worker or frontend bundle is needed.

1. Open **Photo finder** in AVM.
2. Choose **Prepare photo search** once. Preparation runs in small resumable
   batches and skips fingerprints already current. Leave the tab open, or stop
   after a batch and rerun later. Unreadable photos are counted with a safe
   support reference; they never prevent other photos from being prepared.
3. Upload the reference photo/screenshot and select **Find similar photos**.
4. Compare the ranked photos, apartment names, local IDs and original photos.
   **Open apartment** opens that apartment's edit page in another tab.
5. Tag individual photos (Bedroom, Living room, Bathroom, Kitchen, Dining room,
   Balcony / terrace, Exterior or Other). Filter by property, apartment, name,
   room tag or Not tagged yet. Tags are manual; no automatic room classification
   or apartment reassignment occurs.

Preparation uses the current filters. Clear filters to prepare the whole library.
Tags do not need to be complete to run a visual search; leave Room tag at All
room types if a needed photo has not yet been tagged.

For large libraries, the server can prepare fingerprints without leaving a
browser open:

```bash
php artisan photos:index-apartments
php artisan photos:index-apartments --property=20
```

`--force` recomputes fingerprints when a file was replaced under the same name.
Ordinary AVM uploads use a new URL and are automatically considered unprepared.

## Matching and privacy

This is bounded local near-duplicate matching, using image gradients, brightness
and colour patterns, with small centre-crop variants to tolerate screenshot
borders and modest crops. It works best when the same photo (possibly resized,
recompressed or lightly cropped) is in AVM. It is not semantic room recognition:
different camera angles, heavily cropped images, large overlays and similar
decor can produce weak or misleading suggestions. Scores are visual similarity,
not probabilities or confirmation of an apartment's identity. All results require
manual comparison. Identical photos reused on multiple apartments remain
separate results so an administrator can see the ambiguity.

Reference uploads are read from PHP's temporary upload, never copied into AVM's
public gallery, logged, or sent to an AI provider. Fingerprints contain no
reference photo. Existing gallery files are read only from AVM's fixed apartment
directory or configured upload disk; stored external URLs are never fetched.
Oversized older camera originals use an existing small gallery derivative rather
than decoding a high-memory original in a web request. Missing originals and
derivatives are reported, not guessed. Deleted apartments/properties and
property-wide/shared gallery images are excluded from apartment search.

No OTA connection, mapping, inventory, booking, original photo or gallery owner
is changed. The only changes are search fingerprints and administrator-selected
room tags. Public image JSON hides fingerprints. Removing the migration fields
on rollback loses those tags/indexes, not the original photos.

## Verify

`php vendor/bin/phpunit --filter 'PhotoVisualSignatureTest|ApartmentPhotoFinderTest'`
covers resized and bordered images, ranking, permissions, gallery scope, tags,
private uploads, changed sources, failed reads and derivative fallback.
`node --check public/backend/js/photo-finder.js` checks browser-script syntax.
