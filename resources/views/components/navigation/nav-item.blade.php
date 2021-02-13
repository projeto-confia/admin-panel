@props(['active' => false])

<li class="nav-item  {{ $attributes->get('class') }}">
    <a
        class="nav-link  {{ $active ? 'active' : '' }}"
        href="{{ $attributes->get('href') }}"
    >
            {{ $slot }}
    </a>
</li>
