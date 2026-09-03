@props(['menuItem'])

@php
$attributes = $attributes->class([
    'menu-item',
    'menu-item-internal' => $menuItem->getType()->isInternal(),
    'menu-item-external' => $menuItem->getType()->isExternal(),
    'has-submenu' => $menuItem->items->isNotEmpty(),
    $menuItem->getTitleAsSlug(),
    'menu-item-active' => $menuItem->isActive(),
]);
@endphp

<li {{ $attributes }}>
    <a href="{{ $menuItem->getUrl() }}" title="{{ $menuItem->getTitle() }}">
        {{ $menuItem->getTitle() }}
    </a>

    @if($menuItem->items->isNotEmpty())
        <ul class="menu-submenu">
            @foreach($menuItem->items->sortBy('sort_order') as $subMenuItem)
                <x-menu::item :menu-item="$subMenuItem" />
            @endforeach
        </ul>
    @endif
</li>
