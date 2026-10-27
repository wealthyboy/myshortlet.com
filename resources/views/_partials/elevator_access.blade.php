@if(isset($obj->elevator_access))
    <div class="position-relative mb-1 apartment-elevator-access">
        <span class="position-absolute svg-icon-section" aria-hidden="true">
            <svg viewBox="0 0 24 24" focusable="false" fill="none" stroke="currentColor" stroke-width="1.8">
                <rect x="3" y="2" width="18" height="20" rx="1" />
                <path d="M7 22V11h10v11M12 11v11M6 7l2-2 2 2m4-2 2 2 2-2" />
            </svg>
        </span>
        <span class="svg-icon-text">{{ $obj->elevator_access ? 'Elevator access' : 'No elevator access' }}</span>
    </div>
@endif
