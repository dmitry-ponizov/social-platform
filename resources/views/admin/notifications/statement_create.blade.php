<div class="dropdown-divider"></div>
<a class="dropdown-item" href="{{ route('statement.show', $notification->data['id']) }}" onclick="markNotificationAsRead()">
    <span class="text-success">
        <strong>
            {{ $notification->data['title'] }}
        </strong>
    </span>
    <span class="small float-right text-muted">{{ $notification->created_at  }}</span>
    <div class="dropdown-message small">
        {{ $notification->data['description'] }}
    </div>
</a>