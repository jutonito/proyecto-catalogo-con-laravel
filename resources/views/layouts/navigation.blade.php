<!-- navigation.blade.php -->
<nav x-data="{ open: false, cartOpen: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Catalogo') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Cart Button -->
            <div class="flex items-center space-x-4 relative">
                <!-- Cart Icon -->
                <button @click="cartOpen = ! cartOpen" class="cart-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                        <path d="M240-80q-33 0-56.5-23.5T160-160v-480q0-33 23.5-56.5T240-720h80q0-66 47-113t113-47q66 0 113 47t47 113h80q33 0 56.5 23.5T800-640v480q0 33-23.5 56.5T720-80H240Zm0-80h480v-480h-80v80q0 17-11.5 28.5T600-520q-17 0-28.5-11.5T560-560v-80H400v80q0 17-11.5 28.5T360-520q-17 0-28.5-11.5T320-560v-80h-80v480Zm160-560h160q0-33-23.5-56.5T480-800q-33 0-56.5 23.5T400-720ZM240-160v-480 480Z"/>
                    </svg>
                    <!-- Cart Item Count -->
                    <span class="cart-item-count">
                        {{ count(session('cart', [])) }}
                    </span>
                </button>
            </div>

            <!-- User Settings -->
            <div class="sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="dropdown-button">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>

    <!-- Cart Dropdown (Collapsed) -->
    <div x-show="cartOpen" x-transition @click.away="cartOpen = false" class="cart-dropdown">
        <h4 class="font-semibold text-xl mb-2">Tu Carrito</h4>
        <div class="space-y-4">
            @foreach(session('cart', []) as $item)
                <div class="cart-item">
                    <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="cart-item-image">
                    <div class="cart-item-details">
                        <p class="cart-item-name">{{ $item['name'] }}</p>
                        <p class="cart-item-quantity">Cantidad: {{ $item['quantity'] }}</p>
                        <p class="cart-item-price">{{ '$' . number_format($item['price'] * $item['quantity'], 2) }}</p>
                    </div>
                    <!-- Formulario para eliminar del carrito -->
                    <form action="{{ route('removeFromCart') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                        <button type="submit" class="remove-item-button">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        <!-- Total Price -->
        <div class="total-price">
            <p class="asa">Total: {{ '$' . number_format(array_sum(array_map(function ($item) { return $item['price'] * $item['quantity']; }, session('cart', []))), 2) }}</p>
        </div>
    </div>
</nav>

<style>
    /* Estilos dentro de la etiqueta <style> */

    .cart-dropdown {
        width: 400px; /* Aumentamos el ancho */
        max-height: 500px; /* Aumentamos la altura máxima */
        background-color: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        padding: 16px;
        z-index: 20;
        position: absolute;
        right: 0;
        margin-top: 8px;
        overflow-y: auto;
    }

    .cart-icon {
        position: relative;
        text-gray-500;
        dark:text-gray-400;
    }

    .cart-item-count {
        position: absolute;
        top: -8px;
        right: -11px;
        background-color: red;
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }

    .cart-item {
        display: flex;
        justify-content: space-between;
        background-color: #f9fafb;
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 8px;
    }

    .cart-item-image {
        width: 64px;
        height: 64px;
        object-fit: cover;
        border-radius: 8px;
    }

    .cart-item-details {
        flex: 1;
        margin-left: 12px;
    }

    .cart-item-name {
        font-weight: 600;
        color: #1f2937;
    }

    .cart-item-quantity,
    .cart-item-price {
        font-size: 12px;
        color: #6b7280;
    }

    .remove-item-button {
        color: red;
        background: none;
        border: none;
        cursor: pointer;
    }

    .total-price {
        margin-top: 16px;
        border-top: 2px solid #353333;
        padding-top: 12px;
        color: #000000
    }

    /* Asegura que el contenedor de la barra de navegación esté alineado a la derecha */
    .flex.justify-between {
        display: flex;
        justify-content: space-between;
        width: 100%;
    }

    /* Contenedor del icono de carrito y dropdown */
    .flex.items-center.space-x-4.relative {
        display: flex;
        justify-content: flex-end; /* Alinea a la derecha */
        gap: 0; /* Distancia de 2 cm entre los elementos */
        position: relative;
    }

    .dropdown-button {
        display: inline-flex;
        align-items: center;
        padding: 8px;
        border: none;
        background-color: #1f2937;
        color: #6b7280;
        font-size: 14px;
        cursor: pointer;
    }

    .dropdown-button:hover {
        color: #4b5563;
    }
</style>

