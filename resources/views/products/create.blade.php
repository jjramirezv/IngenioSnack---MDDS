<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-orange-100 rounded-lg">
                <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h2 class="font-extrabold text-2xl text-slate-800 leading-tight">
                {{ __('Registrar Nuevo Producto') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-slate-100">
                <div class="p-8 sm:p-10 text-slate-900">
                    
                    <div class="mb-8 border-b border-slate-100 pb-5">
                        <h3 class="text-lg font-bold text-slate-800">Detalles del Snack</h3>
                        <p class="text-slate-500 text-sm mt-1">Ingresa la información básica para publicar este producto en el menú principal.</p>
                    </div>

                    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                        @csrf 
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="name" class="block text-sm font-bold text-slate-700 mb-1">Nombre del Producto</label>
                                <input type="text" name="name" id="name" placeholder="Ej. Sándwich de Pollo" class="block w-full border-slate-300 text-slate-800 rounded-xl shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-colors" required>
                            </div>

                            <div>
                                <label for="category_id" class="block text-sm font-bold text-slate-700 mb-1">Categoría</label>
                                <select name="category_id" id="category_id" class="block w-full border-slate-300 text-slate-800 rounded-xl shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-colors" required>
                                    <option value="" disabled selected>Selecciona una categoría...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="description" class="block text-sm font-bold text-slate-700 mb-1">Descripción</label>
                            <textarea name="description" id="description" rows="3" placeholder="Describe los ingredientes o detalles del snack..." class="block w-full border-slate-300 text-slate-800 rounded-xl shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-colors"></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 border-b border-slate-100 pb-8 items-end">
                            <div>
                                <label for="price" class="block text-sm font-bold text-slate-700 mb-1">Precio (S/)</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-slate-500 font-bold">S/</span>
                                    </div>
                                    <input type="number" step="0.10" name="price" id="price" class="pl-8 block w-full border-slate-300 text-slate-800 rounded-xl shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-colors" required>
                                </div>
                            </div>

                            <div>
                                <label for="stock_quantity" class="block text-sm font-bold text-slate-700 mb-1">Stock Inicial</label>
                                <input type="number" name="stock_quantity" id="stock_quantity" value="10" class="block w-full border-slate-300 text-slate-800 rounded-xl shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-colors" required>
                            </div>

                            <div>
                                <label for="image" class="block text-sm font-bold text-slate-700 mb-1">Foto del Producto</label>
                                <input type="file" name="image" id="image" accept="image/*" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-orange-50 file:text-orange-600 hover:file:bg-orange-100 cursor-pointer">
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('products.index') }}" class="text-slate-500 hover:text-slate-700 font-bold transition-colors">Cancelar</a>
                            <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-6 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center gap-2 transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Guardar Producto
                            </button>
                        </div>
                    </form>

                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>