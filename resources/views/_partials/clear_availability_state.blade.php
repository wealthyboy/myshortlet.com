@php
    $preserveAvailabilityState = request()->is('apartment/*')
        || request()->is('property/*')
        || request()->is('checkout/*')
        || request()->is('book/*')
        || ((request()->is('apartments*') || request()->is('properties/*'))
            && request()->filled('check_in_checkout'));
@endphp

@if(! $preserveAvailabilityState)
<script>
    // Keep the browser state aligned with the cleared Laravel session. Do
    // this before Vue/Flatpickr mounts so stale values never flash onscreen.
    (function () {
        try {
            localStorage.removeItem('searchParams');
            sessionStorage.removeItem('searchParams');
        } catch (error) {
            // Storage may be unavailable in private browsing; server-side
            // session cleanup still handles the booking flow safely.
        }

        ['check_in_checkout', 'checkin', 'checkout', 'searchParams'].forEach(function (name) {
            document.cookie = name + '=; Max-Age=0; path=/; SameSite=Lax';
        });
    })();
</script>
@endif
