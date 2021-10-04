<a href="#" data-id="{{ $obj->id }}" data-toggle="{{ auth()->check() ? ' ': 'modal' }}"  data-target="{{ auth()->check() ? '#auth': '#loadModal' }}" class="saved" title="Wishlist">
    <svg  id="saved-outline" class="{{ in_array($obj->id, $saved) ? 'd-none': '' }}">
        <use xlink:href="#favorites-outline"></use>
    </svg>
    <svg id="saved-none-outline" class="{{ in_array($obj->id, $saved) ? '': 'd-none' }}">
        <use xlink:href="#favorites"></use>
    </svg>
</a>