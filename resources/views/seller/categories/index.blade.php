<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-slate-800 flex items-center gap-2">
            <svg class="w-7 h-7 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            Clasificación del Menú
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-xl shadow-sm font-bold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl shadow-sm font-bold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 bg-white shadow-sm rounded-2xl border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <h3 class="font-black text-lg text-slate-800">Categorías Activas</h3>
                    <span class="bg-orange-100 text-orange-600 px-3 py-1 rounded-full text-xs font-bold">{{ $categories->count() }} Registradas</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-slate-500 font-black uppercase text-[10px] tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Nombre</th>
                                <th class="px-6 py-4 text-center">Productos Asociados</th>
                                <th class="px-6 py-4 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($categories as $category)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-slate-800">
                                        {{ $category->name }}
                                        @if($category->description)
                                            <span class="block text-xs text-slate-400 font-normal mt-0.5">{{ $category->description }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center justify-center px-2 py-1 rounded text-xs font-bold {{ $category->products_count > 0 ? 'bg-slate-100 text-slate-700' : 'bg-red-50 text-red-500' }}">
                                            {{ $category->products_count }} productos
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <form action="{{ route('seller.categories.destroy', $category->id) }}" method="POST" class="inline-block" x-data="{ confirming: false }">
                                            @csrf
                                            @method('DELETE')
                                            
                                            <button x-show="!confirming" @click.prevent="confirming = true" type="button" class="text-slate-400 hover:text-red-500 transition-colors p-2" title="Eliminar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>

                                            <div x-show="confirming" style="display: none;" class="flex items-center justify-end gap-2">
                                                <span class="text-xs font-black text-red-500 mr-1">¿Seguro?</span>
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-[10px] uppercase tracking-wider font-black px-3 py-1.5 rounded-lg shadow-sm transition-transform active:scale-95">
                                                    Sí, borrar
                                                </button>
                                                <button @click.prevent="confirming = false" type="button" class="bg-slate-100 hover:bg-slate-200 text-slate-600 text-[10px] uppercase tracking-wider font-black px-3 py-1.5 rounded-lg transition-transform active:scale-95">
                                                    Cancelar
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-10 text-center text-slate-400">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 mb-3 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                            <p>No hay categorías creadas aún.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white p-6 shadow-sm rounded-2xl border border-slate-100 sticky top-24">
                    <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                        <div class="w-8 h-8 bg-orange-100 text-orange-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </div>
                        <h3 class="font-black text-lg text-slate-800">Nueva Categoría</h3>
                    </div>
                    
                    <form action="{{ route('seller.categories.store') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wide">Nombre</label>
                            <input type="text" name="name" placeholder="Ej. Bebidas Calientes" class="w-full rounded-xl border-slate-200 focus:border-orange-500 focus:ring focus:ring-orange-200 focus:ring-opacity-50 transition-shadow bg-slate-50 px-4 py-3 text-slate-800 font-medium placeholder-slate-400" required>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wide">Descripción <span class="text-slate-300 font-normal lowercase">(Opcional)</span></label>
                            <textarea name="description" rows="3" placeholder="Cafés, infusiones, mates..." class="w-full rounded-xl border-slate-200 focus:border-orange-500 focus:ring focus:ring-orange-200 focus:ring-opacity-50 transition-shadow bg-slate-50 px-4 py-3 text-slate-800 font-medium placeholder-slate-400"></textarea>
                        </div>
                        
                        <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-3.5 px-4 rounded-xl shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2 mt-4">
                            Guardar Categoría
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>