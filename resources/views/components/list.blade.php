@props(['menu'])
<ul {{ $attributes }}>
    @foreach($menu->items->whereNull('parent_id')->sortBy('sort_order') as $menuItem)
        <x-menu::item :menu-item="$menuItem" />
    @endforeach
</ul>
