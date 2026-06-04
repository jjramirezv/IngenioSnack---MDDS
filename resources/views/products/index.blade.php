<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            
            <h2 class="font-extrabold text-2xl text-slate-800 leading-tight">
                {{ __('Gestión del Menú') }}
            </h2>
            
            <a href="{{ route('products.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2.5 px-5 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center gap-2 transform hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nuevo Producto
            </a>
            
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-slate-100">
                <div class="p-0 overflow-x-auto">
                    
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead class="bg-slate-50/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">Producto</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">Precio</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">Stock</th>
                                <th class="px-6 py-4 text-right text-xs font-black text-slate-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-50">
                            @forelse ($products as $product)
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0 bg-slate-100 rounded-lg flex items-center justify-center">
                                                @if($product->image_path)
                                                    <img class="h-10 w-10 rounded-lg object-cover" src="{{ asset('storage/' . $product->image_path) }}" alt="">
                                                @else
                                                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-slate-900">{{ $product->name }}</div>
                                                <div class="text-sm text-slate-500">SKU: {{ $product->sku ?? 'Sin código' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-black text-slate-900">S/ {{ number_format($product->price, 2) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($product->stock_quantity > 0)
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-extrabold rounded-full bg-emerald-100 text-emerald-700">
                                                {{ $product->stock_quantity }} disponibles
                                            </span>
                                        @else
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-extrabold rounded-full bg-red-100 text-red-700">
                                                Agotado
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div x-data="{ openDeleteModal: false }" class="flex items-center justify-end gap-3">
                                            
                                            <a href="{{ route('products.edit', $product->id) }}" class="text-slate-400 hover:text-orange-500 transition-colors" title="Editar Producto">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </a>

                                            <button @click="openDeleteModal = true" type="button" class="text-slate-400 hover:text-red-500 transition-colors" title="Eliminar Producto">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>

                                            <div x-show="openDeleteModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                    
                                                    <div x-show="openDeleteModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity" @click="openDeleteModal = false" aria-hidden="true"></div>

                                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                                    <div x-show="openDeleteModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-100">
                                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                            <div class="sm:flex sm:items-start">
                                                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                                </div>
                                                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                                    <h3 class="text-lg leading-6 font-black text-slate-900" id="modal-title">
                                                                        Eliminar Producto
                                                                    </h3>
                                                                    <div class="mt-2">
                                                                        <p class="text-sm text-slate-500 whitespace-normal">
                                                                            ¿Estás seguro de que deseas eliminar <span class="font-bold text-slate-800">"{{ $product->name }}"</span>? 
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-2xl border-t border-slate-100">
                                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="m-0 p-0">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-red-500 text-base font-bold text-white hover:bg-red-600 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                                                    Sí, eliminar
                                                                </button>
                                                            </form>
                                                            <button @click="openDeleteModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-bold text-slate-700 hover:bg-slate-50 hover:text-slate-900 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                                                Cancelar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                        <svg class="mx-auto h-12 w-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                        <span class="block text-sm font-medium">No hay productos registrados en el inventario.</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>