@props(['id', 'label'])

<li class="nav-item dropdown {{ $attributes->get('class') }}">
    <a class="nav-link dropdown-toggle" href="#" id="{{ $id }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        {{ $label }}
    </a>
    <ul class="dropdown-menu" aria-labelledby="{{ $id }}">
        {{ $slot }}
    </ul>
</li>
