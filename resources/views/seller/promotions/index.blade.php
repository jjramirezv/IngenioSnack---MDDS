<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-slate-800 flex items-center gap-2">
            <svg class="w-7 h-7 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
            Centro de Promociones
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-xl shadow-sm font-bold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Lista de Promociones (Izquierda) -->
            <div class="lg:col-span-2 bg-white shadow-sm rounded-2xl border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <h3 class="font-black text-lg text-slate-800">Ofertas Activas</h3>
                    <span class="bg-orange-100 text-orange-600 px-3 py-1 rounded-full text-xs font-bold">{{ $promotions->count() }} Promociones</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-slate-500 font-black uppercase text-[10px] tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Promoción</th>
                                <th class="px-6 py-4">Mecánica</th>
                                <th class="px-6 py-4 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($promotions as $promo)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <span class="font-bold text-slate-900 block text-base">{{ $promo->name }}</span>
                                        <span class="text-xs text-emerald-500 font-black bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100">ACTIVA</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2 text-xs font-bold">
                                            <span class="bg-slate-100 text-slate-600 px-2 py-1 rounded">Compra {{ $promo->required_quantity }} {{ $promo->targetProduct->name }}</span>
                                            <span class="text-orange-500">👉</span>
                                            <span class="bg-orange-50 text-orange-600 px-2 py-1 rounded border border-orange-100">Gana 1 {{ $promo->rewardProduct->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <form action="{{ route('seller.promotions.destroy', $promo->id) }}" method="POST" class="inline-block" x-data="{ confirming: false }">
                                            @csrf
                                            @method('DELETE')
                                            <button x-show="!confirming" @click.prevent="confirming = true" type="button" class="text-slate-400 hover:text-red-500 transition-colors p-2" title="Eliminar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                            <div x-show="confirming" style="display: none;" class="flex items-center justify-end gap-2">
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-[10px] uppercase font-black px-3 py-1.5 rounded-lg shadow-sm">Sí, borrar</button>
                                                <button @click.prevent="confirming = false" type="button" class="bg-slate-100 hover:bg-slate-200 text-slate-600 text-[10px] uppercase font-black px-3 py-1.5 rounded-lg">Cancelar</button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-10 text-center text-slate-400">
                                        <div class="flex flex-col items-center">
                                            <span class="text-4xl mb-3">🎁</span>
                                            <p class="font-bold">No hay promociones activas.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Formulario (Derecha) -->
            <div class="lg:col-span-1">
                <div class="bg-white p-6 shadow-sm rounded-2xl border border-slate-100 sticky top-24">
                    <h3 class="font-black text-lg text-slate-800 mb-6 border-b border-slate-100 pb-4">Nueva Promoción</h3>
                    
                    <form action="{{ route('seller.promotions.store') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Nombre de la Promoción</label>
                            <input type="text" name="name" placeholder="Ej. Lunes de Galletas" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl py-2.5 px-4 focus:ring-orange-500/20 focus:border-orange-500 font-bold text-sm" required>
                        </div>

                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 space-y-4">
                            <h4 class="text-xs font-black text-slate-800 uppercase tracking-wider">La Condición:</h4>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1">Si el alumno compra...</label>
                                <select name="target_product_id" class="w-full border-slate-200 text-slate-900 rounded-xl py-2.5 px-4 focus:ring-orange-500/20 font-bold text-sm" required>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1">Esta cantidad de veces:</label>
                                <input type="number" name="required_quantity" min="1" value="5" class="w-full border-slate-200 text-slate-900 rounded-xl py-2.5 px-4 focus:ring-orange-500/20 font-bold text-sm" required>
                            </div>
                        </div>

                        <div class="p-4 bg-orange-50/50 rounded-xl border border-orange-100 space-y-4">
                            <h4 class="text-xs font-black text-orange-600 uppercase tracking-wider">El Premio:</h4>
                            <div>
                                <label class="block text-xs font-bold text-orange-800 mb-1">Recibe GRATIS un(a):</label>
                                <select name="reward_product_id" class="w-full border-orange-200 text-slate-900 rounded-xl py-2.5 px-4 focus:ring-orange-500/20 font-bold text-sm bg-white" required>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-3.5 px-4 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 mt-2">
                            Crear Promoción
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>