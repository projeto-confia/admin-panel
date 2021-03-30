@props(['id', 'label'])

<li class="nav-item dropdown {{ $attributes->get('class') }}">
    <a class="nav-link dropdown-toggle" href="#" id="{{ $id }}" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ $label }}
    </a>
    <ul class="dropdown-menu" style="position:fixed; left:auto; top:auto;" aria-labelledby="{{ $id }}">
        {{ $slot }}
    </ul>
</li>
