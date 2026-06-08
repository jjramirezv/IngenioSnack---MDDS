@if(auth()->user()->role === 'admin')
    <x-nav-link :href="route('seller.orders.index')">
        Panel de Don Julio
    </x-nav-link>
@endif