<li class="nav-item  {{ $attributes->get('class') }}">
    <a
        class="pe-5 nav-link"
        href="{{ $attributes->get('href') }}"
    >
            {{ $slot }}
    </a>
</li>
