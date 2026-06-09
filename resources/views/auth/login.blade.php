<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión - IngenioSnack</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white">

    <div class="min-h-screen w-full flex bg-white">
        
        <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 sm:px-16 md:px-24 xl:px-32 relative z-10">
            
            <div class="absolute top-8 left-8 sm:left-16 md:left-24 xl:left-32 flex items-center gap-2">
                <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                <span class="font-extrabold text-xl tracking-tight text-slate-900">Ingenio<span class="text-orange-500">Snack</span></span>
            </div>

            <div class="w-full max-w-md mx-auto mt-12 lg:mt-0">
                <div class="mb-10">
                    <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight mb-2">¡Hola de nuevo! 👋</h2>
                    <p class="text-slate-500 font-medium text-lg">Ingresa tus credenciales para saltarte la fila en el recreo.</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700">Correo Electrónico</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                            </div>
                            <input id="email" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl py-3.5 pl-11 pr-4 focus:bg-white focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 transition-all outline-none font-medium placeholder-slate-400" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="estudiante@uncp.edu.pe" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <label class="block text-sm font-bold text-slate-700">Contraseña</label>
                            @if (Route::has('password.request'))
                                <a class="text-sm font-bold text-orange-500 hover:text-orange-600 transition-colors" href="{{ route('password.request') }}">¿Olvidaste tu clave?</a>
                            @endif
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input id="password" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl py-3.5 pl-11 pr-4 focus:bg-white focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 transition-all outline-none font-medium placeholder-slate-400" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center mt-4">
                        <input id="remember_me" type="checkbox" class="w-5 h-5 rounded border-slate-300 text-orange-500 focus:ring-orange-500 transition-colors cursor-pointer" name="remember">
                        <label for="remember_me" class="ms-3 text-sm text-slate-600 font-medium cursor-pointer">Mantener mi sesión iniciada</label>
                    </div>

                    <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold text-lg py-4 rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 active:scale-95 flex justify-center items-center gap-2 mt-6">
                        Ingresar a mi cuenta
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>

                <div class="mt-10 text-center">
                    <p class="text-slate-600 font-medium">¿Eres nuevo en la UNCP? <a href="{{ route('register') }}" class="font-bold text-orange-500 hover:text-orange-600 hover:underline transition-colors">Crea tu cuenta aquí</a></p>
                </div>
            </div>
        </div>

        <div class="hidden lg:flex w-1/2 bg-slate-900 relative overflow-hidden items-center justify-center p-12">
            <div class="absolute inset-0 bg-gradient-to-br from-orange-500/20 to-slate-900 opacity-90 z-0"></div>
            <div class="absolute -top-32 -right-32 w-96 h-96 bg-orange-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>
            <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-orange-600 rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>

            <div class="relative z-10 max-w-lg text-center">
                <div class="w-24 h-24 bg-white/10 backdrop-blur-md rounded-3xl mx-auto flex items-center justify-center mb-8 border border-white/20 shadow-2xl">
                    <svg class="w-12 h-12 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h3 class="text-4xl lg:text-5xl font-black text-white leading-tight mb-6">El sabor de siempre,<br><span class="text-orange-400">sin esperar.</span></h3>
                <p class="text-slate-300 text-lg font-medium">Olvídate de las filas largas. Pide tu snack favorito desde clase, recógelo al instante y aprovecha al máximo tu recreo.</p>
                
                <div class="mt-12 bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-4 shadow-2xl flex items-center gap-4 text-left transform rotate-2 hover:rotate-0 transition-transform duration-300">
                    <div class="w-12 h-12 bg-orange-500 rounded-full flex-shrink-0 flex items-center justify-center">
                        <span class="text-xl">🍟</span>
                    </div>
                    <div>
                        <p class="text-white font-bold">Orden #0042 Lista</p>
                        <p class="text-orange-200 text-sm">Tus papitas y sándwich te esperan.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>
</html>