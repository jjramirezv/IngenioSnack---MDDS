<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear Cuenta - IngenioSnack</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white">

    <div class="min-h-screen w-full flex bg-white">
        
        <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 sm:px-16 md:px-24 xl:px-32 relative z-10 py-12">
            
            <div class="absolute top-8 left-8 sm:left-16 md:left-24 xl:left-32 flex items-center gap-2">
                <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                <span class="font-extrabold text-xl tracking-tight text-slate-900">Ingenio<span class="text-orange-500">Snack</span></span>
            </div>

            <div class="w-full max-w-md mx-auto mt-8 lg:mt-0">
                <div class="mb-8">
                    <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight mb-2">Crea tu cuenta </h2>
                    <p class="text-slate-500 font-medium text-lg">Regístrate y haz tu pedido al instante</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700">Nombre Completo</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <input id="name" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl py-3 pl-11 pr-4 focus:bg-white focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 transition-all outline-none font-medium placeholder-slate-400" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Ej. Jelibeth Ramirez" />
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700">Correo Electrónico</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                            </div>
                            <input id="email" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl py-3 pl-11 pr-4 focus:bg-white focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 transition-all outline-none font-medium placeholder-slate-400" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="estudiante@uncp.edu.pe" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700">Contraseña</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input id="password" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl py-3 pl-11 pr-4 focus:bg-white focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 transition-all outline-none font-medium placeholder-slate-400" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700">Confirmar Contraseña</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <input id="password_confirmation" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl py-3 pl-11 pr-4 focus:bg-white focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 transition-all outline-none font-medium placeholder-slate-400" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                    </div>

                    <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold text-lg py-4 rounded-xl shadow-lg shadow-orange-500/20 transition-all transform hover:-translate-y-0.5 active:scale-95 flex justify-center items-center gap-2 mt-4">
                        Completar Registro
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>

                <div class="mt-8 text-center">
                    <p class="text-slate-600 font-medium">¿Ya eres parte del club? <a href="{{ route('login') }}" class="font-bold text-slate-900 hover:text-orange-500 hover:underline transition-colors">Inicia sesión aquí</a></p>
                </div>
            </div>
        </div>

        <div class="hidden lg:flex w-1/2 bg-slate-900 relative overflow-hidden items-center justify-center p-12">
            <div class="absolute inset-0 bg-gradient-to-br from-orange-500/20 to-slate-900 opacity-90 z-0"></div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-orange-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-orange-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>

            <div class="relative z-10 max-w-lg text-center">
                <div class="w-24 h-24 bg-white/10 backdrop-blur-md rounded-3xl mx-auto flex items-center justify-center mb-8 border border-white/20 shadow-2xl">
                    <span class="text-5xl">🎓</span>
                </div>
                <h3 class="text-4xl lg:text-5xl font-black text-white leading-tight mb-6">Tu tiempo vale,<br><span class="text-orange-400">disfrútalo.</span></h3>
                <p class="text-slate-300 text-lg font-medium">Con IngenioSnack, tus descansos son para ti. Regístrate en segundos y accede al menú completo de tu kiosco universitario.</p>
                
                <div class="mt-12 bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-4 shadow-2xl flex items-center gap-4 text-left transform -rotate-2 hover:rotate-0 transition-transform duration-300">
                    <div class="w-12 h-12 bg-emerald-500 rounded-full flex-shrink-0 flex items-center justify-center">
                        <span class="text-xl">🎁</span>
                    </div>
                    <div>
                        <p class="text-white font-bold">Programa de Lealtad</p>
                        <p class="text-emerald-200 text-sm">Gana recompensas con tus compras.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>
</html>