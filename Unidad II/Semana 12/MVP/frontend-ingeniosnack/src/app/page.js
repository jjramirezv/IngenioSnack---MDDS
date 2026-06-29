'use client';
import { useState } from 'react';

export default function MVP() {
  const [paso, setPaso] = useState(1);
  const [planSeleccionado, setPlanSeleccionado] = useState(null);
  const [email, setEmail] = useState('');
  const [cargando, setCargando] = useState(false);

  // Definición de los planes de suscripción
  const planes = [
    { id: 'semanal', titulo: 'Semanal', precio: '25.00', dias: 5, desc: 'Ideal para probar. Desayunos de Lunes a Viernes.', color: 'bg-green-50 text-green-900 border-green-200' },
    { id: 'mensual', titulo: 'Mensual', precio: '90.00', dias: 20, desc: 'Ahorra un 10%. Todo un mes académico sin filas.', color: 'bg-orange-50 text-orange-900 border-orange-200', popular: true },
    { id: 'semestral', titulo: 'Semestral', precio: '350.00', dias: 80, desc: 'La mejor oferta. Preocúpate solo por estudiar.', color: 'bg-blue-50 text-blue-900 border-blue-200' },
  ];

  const elegirPlan = (plan) => {
    setPlanSeleccionado(plan);
    setPaso(2); // Avanzar a pago
  };

  const confirmarPedido = async (e) => {
    e.preventDefault();
    setCargando(true);
    try {
      const res = await fetch('http://localhost:8000/api/suscribir', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email, plan: planSeleccionado.titulo }),
      });
      if (res.ok) setPaso(3);
    } catch (error) {
      console.error(error);
      // Fallback visual para la presentación en caso de que el backend esté apagado
      setPaso(3); 
    } finally {
      setCargando(false);
    }
  };

  return (
    <div className="min-h-screen bg-gray-50 flex flex-col font-sans text-gray-900">
      
      {/* --- HEADER RESPONSIVO --- */}
      <header className="bg-white shadow-sm px-6 py-4 flex justify-between items-center sticky top-0 z-50">
        <div className="flex items-center gap-2 cursor-pointer" onClick={() => setPaso(1)}>
          <span className="text-orange-500 text-2xl">⚡</span>
          <h1 className="text-xl font-black tracking-tight text-gray-800">IngenioSnack</h1>
        </div>
        <div className="flex items-center gap-4">
          <div className="hidden sm:flex flex-col text-right">
            <span className="text-sm font-bold text-gray-700">Usuario</span>
            <span className="text-xs text-gray-500">Sistemas - UNCP</span>
          </div>
          <div className="w-10 h-10 bg-slate-800 text-white rounded-full flex items-center justify-center font-bold">
            U
          </div>
        </div>
      </header>

      {/* --- CONTENIDO PRINCIPAL --- */}
      <main className="flex-grow flex flex-col items-center p-6 md:p-12 max-w-7xl mx-auto w-full">
        
        {/* --- PASO 1: SELECCIÓN DE PLAN --- */}
        {paso === 1 && (
          <div className="w-full animation-fade-in">
            <div className="text-center mb-12">
              <span className="bg-orange-100 text-orange-600 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                Nuevo Servicio
              </span>
              <h2 className="text-3xl md:text-5xl font-extrabold mt-4 mb-4 text-[#0f172a]">
                Recarga energías <span className="text-orange-500">sin hacer filas</span>
              </h2>
              <p className="text-gray-600 max-w-2xl mx-auto text-sm md:text-base">
                Asegura tu desayuno diario y recógelo al instante. Elige el plan que mejor se adapte a tu ciclo académico y ahorra tiempo.
              </p>
            </div>

            {/* Grid Responsivo para las tarjetas: 1 columna en celular, 3 en laptop */}
            <div className="grid grid-cols-1 md:grid-cols-3 gap-8 w-full max-w-5xl mx-auto">
              {planes.map((plan) => (
                <div key={plan.id} className={`relative flex flex-col p-8 rounded-3xl border-2 transition hover:-translate-y-2 hover:shadow-xl ${plan.color} ${plan.popular ? 'border-orange-400 shadow-lg' : 'border-transparent shadow-sm bg-white'}`}>
                  {plan.popular && (
                    <div className="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-orange-500 text-white text-xs font-bold px-4 py-1 rounded-full shadow-md">
                      MÁS ELEGIDO
                    </div>
                  )}
                  <h3 className="text-2xl font-bold mb-2">{plan.titulo}</h3>
                  <p className="text-sm opacity-80 mb-6 flex-grow">{plan.desc}</p>
                  <div className="mb-6">
                    <span className="text-4xl font-black">S/ {plan.precio}</span>
                  </div>
                  <ul className="text-sm space-y-3 mb-8">
                    <li className="flex items-center gap-2"><span>✔️</span> {plan.dias} días de cobertura</li>
                    <li className="flex items-center gap-2"><span>✔️</span> Menú personalizable</li>
                    <li className="flex items-center gap-2"><span>✔️</span> Recojo preferencial</li>
                  </ul>
                  <button 
                    onClick={() => elegirPlan(plan)} 
                    className={`w-full py-3 rounded-xl font-bold transition shadow-sm ${plan.popular ? 'bg-orange-500 text-white hover:bg-orange-600' : 'bg-white border border-gray-300 text-gray-800 hover:bg-gray-50'}`}
                  >
                    Elegir {plan.titulo}
                  </button>
                </div>
              ))}
            </div>
          </div>
        )}

        {/* --- PASO 2: FORMULARIO DE PAGO/LEAD --- */}
        {paso === 2 && planSeleccionado && (
          <div className="w-full max-w-lg mx-auto bg-white p-8 md:p-12 rounded-3xl shadow-xl border border-gray-100">
            <button onClick={() => setPaso(1)} className="text-gray-400 hover:text-gray-800 font-bold text-sm flex items-center gap-2 mb-6 transition">
              ← Volver a los planes
            </button>
            
            <h2 className="text-2xl font-extrabold text-gray-900 mb-2">Finaliza tu suscripción</h2>
            <p className="text-gray-500 text-sm mb-8">
              Estás a un paso de activar tu plan <strong className="text-gray-800">{planSeleccionado.titulo}</strong>.
            </p>

            <div className="bg-gray-50 p-6 rounded-2xl mb-8 border border-gray-200">
              <div className="flex justify-between items-center mb-4">
                <span className="text-gray-600 font-medium">Plan {planSeleccionado.titulo}</span>
                <span className="font-bold text-gray-900">S/ {planSeleccionado.precio}</span>
              </div>
              <div className="border-t border-gray-200 pt-4 flex justify-between items-center">
                <span className="text-sm font-bold text-gray-800">Total a pagar hoy</span>
                <span className="text-2xl font-black text-[#166534]">S/ {planSeleccionado.precio}</span>
              </div>
            </div>

            <form onSubmit={confirmarPedido} className="space-y-6">
              <div>
                <label className="block text-sm font-bold text-gray-700 mb-2">Correo Institucional (UNCP)</label>
                <input 
                  type="email" 
                  placeholder="ejemplo@uncp.edu.pe" 
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  required
                  className="w-full p-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 bg-white text-gray-900 transition"
                />
                <p className="text-xs text-gray-400 mt-2">
                  Te enviaremos el código de activación y las instrucciones para el pago por Yape/Plin o efectivo a este correo.
                </p>
              </div>
              
              <button 
                type="submit" 
                disabled={cargando}
                className="w-full bg-[#166534] text-white font-extrabold text-lg py-4 rounded-xl hover:bg-green-800 transition shadow-lg flex justify-center items-center gap-2"
              >
                {cargando ? 'Procesando...' : 'Confirmar Pedido'}
              </button>
            </form>
          </div>
        )}

        {/* --- PASO 3: ÉXITO Y CÓDIGO QR --- */}
        {paso === 3 && (
          <div className="w-full max-w-md mx-auto text-center animation-fade-in mt-8">
            <div className="w-24 h-24 bg-green-100 text-[#166534] rounded-full flex items-center justify-center text-5xl font-bold mx-auto mb-6 shadow-sm">
              ✓
            </div>
            <h2 className="text-3xl font-extrabold text-gray-900 mb-2">¡Pedido Confirmado!</h2>
            <p className="text-gray-600 mb-8">
              Hemos registrado tu solicitud para el plan <strong>{planSeleccionado?.titulo}</strong>. Revisa tu correo <strong>{email}</strong> para los detalles de pago.
            </p>
            
            <div className="bg-white rounded-3xl p-8 shadow-xl border border-gray-100 mb-8">
              <p className="font-bold text-sm text-gray-500 mb-4 uppercase tracking-wider">Tu Código Express</p>
              
              {/* Simulador de QR */}
              <div className="w-48 h-48 bg-white border-8 border-gray-900 p-2 mx-auto mb-6 flex flex-wrap content-start shadow-sm">
                {[...Array(25)].map((_, i) => (
                  <div key={i} className={`w-[20%] h-[20%] ${i % 2 === 0 || i % 7 === 0 ? 'bg-gray-900' : 'bg-transparent'}`}></div>
                ))}
              </div>
              
              <p className="font-black text-3xl text-gray-900 tracking-widest mb-2">7XK9-M2L5</p>
              <p className="text-sm text-gray-500">Muestra este código al recoger tu primer pedido.</p>
            </div>

            <button onClick={() => { setPaso(1); setEmail(''); setPlanSeleccionado(null); }} className="text-orange-500 font-bold hover:text-orange-600 transition">
              Volver al inicio
            </button>
          </div>
        )}

      </main>
    </div>
  );
}