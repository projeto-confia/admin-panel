@props(['id', 'label'])

<li class="nav-item dropdown pe-5">
    <a {!! $attributes->merge(['class' => 'nav-link dropdown-toggle']) !!} href="#" id="{{ $id }}" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        {{ $label }}
    </a>
{{-- @todo: rever atribuição de classes   --}}
    <ul class="dropdown-menu dropdown-menu-overlapped {{ $attributes->get('class') }}" aria-labelledby="{{ $id }}">
        {{ $slot }}
    </ul>
</li>
