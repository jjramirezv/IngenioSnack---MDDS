<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center bg-slate-50 p-4">
        
        <!-- Logo y Cabecera -->
        <div class="mb-10 text-center">
            <div class="flex justify-center mb-4">
                <div class="w-16 h-16 bg-slate-900 rounded-2xl flex items-center justify-center shadow-xl">
                    <svg class="w-10 h-10 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
            </div>
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">Bienvenido a IngenioSnack</h2>
            <p class="text-slate-500 font-medium mt-2">Inicia sesión para continuar con tu pedido</p>
        </div>

        <!-- Tarjeta de Login -->
        <div class="w-full max-w-md bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
            
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Correo Electrónico</label>
                    <input id="email" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 transition-all outline-none font-medium" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="ejemplo@uncp.edu.pe" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide">Contraseña</label>
                        @if (Route::has('password.request'))
                            <a class="text-xs font-bold text-orange-500 hover:text-orange-600" href="{{ route('password.request') }}">¿Olvidaste tu clave?</a>
                        @endif
                    </div>
                    <input id="password" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 transition-all outline-none font-medium" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-orange-500 focus:ring-orange-500" name="remember">
                    <span class="ms-2 text-sm text-slate-600 font-medium">Recordar sesión</span>
                </div>

                <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-black py-4 rounded-xl shadow-lg shadow-orange-500/20 transition-all transform hover:-translate-y-0.5 active:scale-95">
                    {{ __('Iniciar Sesión') }}
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-slate-100 text-center">
                <p class="text-sm text-slate-500">¿No tienes cuenta? <a href="{{ route('register') }}" class="font-bold text-orange-500 hover:underline">Regístrate aquí</a></p>
            </div>
        </div>
    </div>
</x-guest-layout>