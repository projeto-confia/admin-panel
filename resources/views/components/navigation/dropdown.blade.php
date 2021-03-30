@props(['id', 'label'])

<li class="nav-item dropdown {{ $attributes->get('class') }}">
    <a class="nav-link dropdown-toggle" href="#" id="{{ $id }}" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ $label }}
    </a>
    <ul class="dropdown-menu dropdown-menu-overlapped" aria-labelledby="{{ $id }}">
        {{ $slot }}
    </ul>
</li>
