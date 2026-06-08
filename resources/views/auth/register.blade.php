<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center bg-slate-50 p-4">
        
        <!-- Cabecera -->
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">Crea tu cuenta</h2>
            <p class="text-slate-500 font-medium mt-2">Únete a IngenioSnack y empieza a pedir</p>
        </div>

        <!-- Tarjeta de Registro -->
        <div class="w-full max-w-md bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
            
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Name -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Nombre Completo</label>
                    <input id="name" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 transition-all outline-none font-medium" type="text" name="name" :value="old('name')" required autofocus placeholder="Jelibeth Ramirez" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Correo Electrónico</label>
                    <input id="email" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 transition-all outline-none font-medium" type="email" name="email" :value="old('email')" required placeholder="estudiante@uncp.edu.pe" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Contraseña</label>
                    <input id="password" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 transition-all outline-none font-medium" type="password" name="password" required placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Confirmar Contraseña</label>
                    <input id="password_confirmation" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 transition-all outline-none font-medium" type="password" name="password_confirmation" required placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Botón de Registro -->
                <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-black py-4 rounded-xl shadow-lg shadow-orange-500/20 transition-all transform hover:-translate-y-0.5 active:scale-95 mt-2">
                    {{ __('Registrarse') }}
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-slate-100 text-center">
                <p class="text-sm text-slate-500">¿Ya tienes cuenta? <a href="{{ route('login') }}" class="font-bold text-orange-500 hover:underline">Inicia sesión aquí</a></p>
            </div>
        </div>
    </div>
</x-guest-layout>