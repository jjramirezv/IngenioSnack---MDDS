<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recuperar Contraseña - IngenioSnack</title>
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
                
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-orange-500 transition-colors mb-8">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Volver al Login
                </a>

                <div class="mb-8">
                    <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight mb-3">¿Olvidaste tu clave? 🔐</h2>
                    <p class="text-slate-500 font-medium text-lg leading-relaxed">Tranquilo, a todos nos pasa. Ingresa tu correo electrónico y te enviaremos un enlace seguro para crear una nueva contraseña.</p>
                </div>

                @if (session('status'))
                    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl shadow-sm font-bold flex items-center gap-3">
                        <div class="bg-emerald-100 p-1.5 rounded-lg flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf

                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700">Correo Electrónico</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <input id="email" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl py-3.5 pl-11 pr-4 focus:bg-white focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 transition-all outline-none font-medium placeholder-slate-400" type="email" name="email" :value="old('email')" required autofocus placeholder="estudiante@uncp.edu.pe" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold text-lg py-4 rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 active:scale-95 flex justify-center items-center gap-2 mt-2">
                        Enviar Enlace de Recuperación
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>

            </div>
        </div>

        <div class="hidden lg:flex w-1/2 bg-slate-900 relative overflow-hidden items-center justify-center p-12">
            <div class="absolute inset-0 bg-gradient-to-br from-slate-800 to-slate-900 opacity-90 z-0"></div>
            <div class="absolute -top-32 -left-32 w-96 h-96 bg-orange-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
            <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10"></div>

            <div class="relative z-10 max-w-lg text-center">
                <div class="w-24 h-24 bg-white/10 backdrop-blur-md rounded-3xl mx-auto flex items-center justify-center mb-8 border border-white/20 shadow-2xl">
                    <svg class="w-12 h-12 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <h3 class="text-4xl lg:text-5xl font-black text-white leading-tight mb-6">Tu seguridad es<br><span class="text-orange-400">nuestra prioridad.</span></h3>
                <p class="text-slate-300 text-lg font-medium">Protegemos tu cuenta en todo momento. Recupera tu acceso de forma rápida y segura para seguir disfrutando del sistema.</p>
                
                <div class="mt-12 bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-4 shadow-2xl flex items-center gap-4 text-left transform rotate-1 hover:rotate-0 transition-transform duration-300 mx-auto w-3/4">
                    <div class="w-12 h-12 bg-slate-700/50 rounded-full flex-shrink-0 flex items-center justify-center border border-slate-600">
                        <span class="text-xl">📩</span>
                    </div>
                    <div>
                        <p class="text-white font-bold">Correo Enviado</p>
                        <p class="text-slate-400 text-sm">Revisa tu bandeja de entrada.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>
</html>