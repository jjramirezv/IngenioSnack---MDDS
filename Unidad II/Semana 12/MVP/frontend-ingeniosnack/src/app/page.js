'use client';
import { useState } from 'react';

const bebidas = [
  { nombre: 'Café pasado', precio: 2.50 },
  { nombre: 'Emoliente', precio: 2.00 },
  { nombre: 'Jugo de Naranja', precio: 3.50 },
  { nombre: 'Té / Infusión', precio: 1.50 }
];

const alimentos = [
  { nombre: 'Sándwich de Pollo', precio: 4.50 },
  { nombre: 'Triple', precio: 4.00 },
  { nombre: 'Snack Energético', precio: 3.00 },
  { nombre: 'Pan con Queso', precio: 2.50 }
];

const diasSemana = [
  { id: 'Lun', completo: 'Lunes' },
  { id: 'Mar', completo: 'Martes' },
  { id: 'Mie', completo: 'Miércoles' },
  { id: 'Jue', completo: 'Jueves' },
  { id: 'Vie', completo: 'Viernes' }
];

export default function Suscripcion() {
  const [paso, setPaso] = useState(1);
  const [email, setEmail] = useState('');
  const [cargando, setCargando] = useState(false);
  const [ciclo, setCiclo] = useState('semanal'); // 'semanal', 'mensual', 'semestral'
  const [diasSeleccionados, setDiasSeleccionados] = useState(['Lun', 'Mar', 'Mie', 'Jue', 'Vie']);
  const [menuPorDia, setMenuPorDia] = useState({
    Lun: { bebida: 'Café pasado', alimento: 'Sándwich de Pollo' },
    Mar: { bebida: 'Emoliente', alimento: 'Triple' },
    Mie: { bebida: 'Café pasado', alimento: 'Snack Energético' },
    Jue: { bebida: 'Emoliente', alimento: 'Sándwich de Pollo' },
    Vie: { bebida: 'Café pasado', alimento: 'Triple' }
  });

  const toggleDia = (id) => {
    setDiasSeleccionados(prev => prev.includes(id) ? prev.filter(d => d !== id) : [...prev, id]);
  };

  const cambiarMenu = (id, campo, valor) => {
    setMenuPorDia(prev => ({ ...prev, [id]: { ...prev[id], [campo]: valor } }));
  };

  const calcularTotal = () => {
    const costoSemanal = diasSeleccionados.reduce((sum, id) => {
      const b = bebidas.find(p => p.nombre === menuPorDia[id]?.bebida)?.precio || 0;
      const a = alimentos.find(p => p.nombre === menuPorDia[id]?.alimento)?.precio || 0;
      return sum + b + a;
    }, 0);

    if (ciclo === 'semanal') return costoSemanal;
    if (ciclo === 'mensual') return costoSemanal * 4 * 0.90; // 10% desc
    return costoSemanal * 16 * 0.80; // 20% desc
  };

  const totalFinal = calcularTotal().toFixed(2);

  const confirmarPedido = async (e) => {
    e.preventDefault();
    if (diasSeleccionados.length === 0) return;
    setCargando(true);
    try {
      await fetch('http://localhost:8000/api/suscribir', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email, ciclo, dias: diasSeleccionados, menu: menuPorDia, total: totalFinal }),
      });
    } catch (e) {
      console.error(e);
    } finally {
      setCargando(false);
      setPaso(3);
    }
  };

  return (
    <div className="min-h-screen bg-gray-50 flex flex-col font-sans text-gray-900">
      {/* Header */}
      <header className="bg-white border-b border-gray-100 px-6 py-4 flex justify-between items-center sticky top-0 z-50">
        <div className="flex items-center gap-2 cursor-pointer" onClick={() => setPaso(1)}>
          <span className="text-orange-500 text-2xl">⚡</span>
          <span className="text-xl font-black text-gray-800">IngenioSnack</span>
        </div>
        <div className="flex items-center gap-4">
          <div className="hidden sm:flex flex-col text-right">
            <span className="text-sm font-bold text-gray-700">Usuario</span>
            <span className="text-xs text-gray-500">Sistemas - UNCP</span>
          </div>
          <div className="w-10 h-10 bg-slate-800 text-white rounded-full flex items-center justify-center font-bold">U</div>
        </div>
      </header>

      {/* Main content */}
      <main className="flex-grow flex flex-col items-center p-4 md:p-8 max-w-6xl mx-auto w-full">
        {paso === 1 && (
          <div className="w-full grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            {/* Configurator */}
            <div className="lg:col-span-2 space-y-6">
              <div className="text-center lg:text-left mb-6">
                <span className="bg-orange-100 text-orange-600 text-xs font-bold px-3 py-1 rounded-full uppercase">Nuevo Servicio</span>
                <h2 className="text-3xl font-extrabold mt-3 text-gray-900">Arma tu suscripción a tu medida</h2>
              </div>

              {/* 1. Periodo */}
              <div className="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <h3 className="font-bold text-gray-800 mb-4">1. Elige el periodo de suscripción</h3>
                <div className="grid grid-cols-3 gap-3">
                  {[
                    { id: 'semanal', label: 'Semanal', desc: '1 semana', badge: null },
                    { id: 'mensual', label: 'Mensual', desc: '4 semanas', badge: '10% DTO' },
                    { id: 'semestral', label: 'Semestral', desc: '16 semanas', badge: '20% DTO' }
                  ].map((p) => (
                    <button key={p.id} onClick={() => setCiclo(p.id)} className={`relative p-4 rounded-xl border-2 text-left transition ${ciclo === p.id ? 'border-orange-500 bg-orange-50/30' : 'border-gray-200'}`}>
                      {p.badge && <span className="absolute -top-2.5 right-2 bg-orange-500 text-white text-[9px] font-bold px-2 py-0.5 rounded-full">{p.badge}</span>}
                      <span className="block font-bold text-sm">{p.label}</span>
                      <span className="block text-xs text-gray-500">{p.desc}</span>
                    </button>
                  ))}
                </div>
              </div>

              {/* 2. Días */}
              <div className="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <h3 className="font-bold text-gray-800 mb-4">2. Selecciona los días (Lunes a Viernes)</h3>
                <div className="flex gap-2">
                  {diasSemana.map((d) => {
                    const active = diasSeleccionados.includes(d.id);
                    return (
                      <button key={d.id} onClick={() => toggleDia(d.id)} className={`flex-1 py-3 rounded-xl font-bold border-2 transition ${active ? 'bg-orange-500 border-orange-500 text-white' : 'bg-white border-gray-200 text-gray-600'}`}>
                        {d.id}
                      </button>
                    );
                  })}
                </div>
              </div>

              {/* 3. Menú */}
              <div className="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <h3 className="font-bold text-gray-800 mb-4">3. Personaliza tu menú</h3>
                {diasSeleccionados.length === 0 ? (
                  <p className="text-gray-400 text-center py-4 text-sm">⚠️ Selecciona al menos un día.</p>
                ) : (
                  <div className="space-y-3">
                    {diasSemana.filter(d => diasSeleccionados.includes(d.id)).map((d) => (
                      <div key={d.id} className="flex flex-col sm:flex-row sm:items-center justify-between p-3 bg-gray-50 rounded-xl gap-2">
                        <span className="font-bold text-sm text-gray-800">{d.completo}</span>
                        <div className="flex gap-2 flex-1 sm:justify-end">
                          <select value={menuPorDia[d.id]?.bebida} onChange={(e) => cambiarMenu(d.id, 'bebida', e.target.value)} className="p-2 border border-gray-200 rounded-lg bg-white text-xs flex-1 max-w-[150px]">
                            {bebidas.map(p => <option key={p.nombre} value={p.nombre}>{p.nombre} (+S/ {p.precio.toFixed(2)})</option>)}
                          </select>
                          <select value={menuPorDia[d.id]?.alimento} onChange={(e) => cambiarMenu(d.id, 'alimento', e.target.value)} className="p-2 border border-gray-200 rounded-lg bg-white text-xs flex-1 max-w-[150px]">
                            {alimentos.map(p => <option key={p.nombre} value={p.nombre}>{p.nombre} (+S/ {p.precio.toFixed(2)})</option>)}
                          </select>
                        </div>
                      </div>
                    ))}
                  </div>
                )}
              </div>
            </div>

            {/* Resume (Right column) */}
            <div className="bg-white rounded-2xl p-6 border border-gray-100 shadow-md lg:sticky lg:top-24 w-full">
              <h3 className="text-lg font-bold mb-4">Resumen</h3>
              <div className="space-y-3 text-sm mb-6">
                <div className="flex justify-between pb-2 border-b border-gray-100"><span className="text-gray-500">Periodo</span><span className="font-bold uppercase">{ciclo}</span></div>
                <div className="flex justify-between pb-2 border-b border-gray-100"><span className="text-gray-500">Días</span><span className="font-bold">{diasSeleccionados.length} días/sem</span></div>
                <div className="flex justify-between pt-2"><span className="text-gray-700 font-bold">Total del periodo</span><span className="text-2xl font-black text-orange-500">S/ {totalFinal}</span></div>
              </div>
              <button onClick={() => setPaso(2)} disabled={diasSeleccionados.length === 0} className="w-full bg-orange-500 hover:bg-orange-600 disabled:bg-gray-200 disabled:text-gray-400 py-3 rounded-xl font-bold text-white transition">
                Continuar a pagar
              </button>
            </div>
          </div>
        )}

        {/* --- PASO 2: PAGO EN EFECTIVO --- */}
        {paso === 2 && (
          <div className="w-full max-w-md bg-white p-6 rounded-3xl shadow-md border border-gray-100 text-left">
            <button onClick={() => setPaso(1)} className="text-gray-400 hover:text-gray-700 font-bold text-xs flex items-center gap-1 mb-6">
              ← Volver
            </button>
            
            <h2 className="text-xl font-black text-gray-900">Pago en Efectivo</h2>
            <p className="text-gray-500 text-xs mt-1">Sin tarjetas. Fácil y seguro</p>

            {/* Banner pago */}
            <div className="bg-orange-50 border border-orange-100 rounded-2xl p-4 flex gap-3 items-center my-5">
              <span className="text-2xl">💵</span>
              <div className="text-left">
                <p className="font-bold text-xs uppercase text-orange-800 tracking-wider">Solo aceptamos</p>
                <p className="font-bold text-sm text-gray-900">PAGO EN EFECTIVO</p>
                <p className="text-xs text-gray-600">Realiza tu pago al momento de recoger tu desayuno.</p>
              </div>
            </div>

            {/* Cómo funciona */}
            <div className="mb-6">
              <h3 className="font-bold text-sm text-gray-800 mb-4">¿Cómo funciona?</h3>
              <div className="relative pl-6 space-y-4 border-l-2 border-orange-100 ml-3">
                <div>
                  <span className="absolute -left-[14px] bg-orange-100 text-orange-600 w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold">1</span>
                  <p className="text-xs text-gray-700">Confirma tu pedido y genera tu código.</p>
                </div>
                <div>
                  <span className="absolute -left-[14px] bg-orange-100 text-orange-600 w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold">2</span>
                  <p className="text-xs text-gray-700">Acércate a la tienda personalmente para pagar la {ciclo === 'semanal' ? 'semana' : ciclo === 'mensual' ? 'mensualidad' : 'suscripción semestral'}.</p>
                </div>
                <div>
                  <span className="absolute -left-[14px] bg-orange-100 text-orange-600 w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold">3</span>
                  <p className="text-xs text-gray-700">Disfrute su suscripción.</p>
                </div>
              </div>
            </div>

            {/* Resumen */}
            <div className="bg-gray-50 p-4 rounded-2xl mb-5 text-sm">
              <div className="flex justify-between mb-2"><span className="text-gray-600">Suscripción {ciclo}</span><span className="font-bold">S/ {totalFinal}</span></div>
              <div className="border-t border-gray-200 pt-2 flex justify-between font-bold text-base"><span className="text-gray-800">Total a pagar</span><span className="text-orange-500">S/ {totalFinal}</span></div>
            </div>

            {/* Banner Reloj */}
            <div className="bg-gray-50 text-gray-600 text-xs p-3 rounded-2xl flex items-center gap-2 mb-6">
              <span>🕒</span>
              <p>Tu pedido estará listo desde <strong>mañana</strong> a partir de las <strong>7:00 a.m.</strong></p>
            </div>

            {/* Email input */}
            <form onSubmit={confirmarPedido} className="space-y-4">
              <div>
                <label className="block text-xs font-bold text-gray-700 mb-1.5">CORREO INSTITUCIONAL (UNCP)</label>
                <input type="email" placeholder="ejemplo@uncp.edu.pe" value={email} onChange={(e) => setEmail(e.target.value)} required className="w-full p-3 border border-gray-200 rounded-xl bg-gray-50 text-sm focus:outline-none focus:ring-1 focus:ring-orange-500" />
              </div>
              <button type="submit" disabled={cargando} className="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3.5 rounded-xl transition">
                {cargando ? 'Procesando...' : 'Confirmar pedido'}
              </button>
            </form>
          </div>
        )}

        {/* --- PASO 3: ÉXITO Y CÓDIGO QR --- */}
        {paso === 3 && (
          <div className="w-full max-w-md mx-auto text-center animation-fade-in mt-4">
            <div className="w-20 h-20 bg-orange-50 border border-orange-100 text-orange-500 rounded-full flex items-center justify-center text-4xl font-bold mx-auto mb-5 shadow-sm">
              ✓
            </div>
            <h2 className="text-3xl font-extrabold text-gray-900 mb-2">¡Pedido Confirmado!</h2>
            <p className="text-gray-600 text-sm mb-6 max-w-sm mx-auto">
              Hemos registrado tu solicitud para el plan <strong className="text-gray-800 uppercase">{ciclo}</strong>. Revisa tu correo <strong>{email}</strong> para los detalles del cobro físico en tienda.
            </p>
            
            <div className="bg-white rounded-3xl p-8 shadow-xl border border-gray-100 mb-8">
              <p className="font-bold text-sm text-gray-500 mb-4 uppercase tracking-wider">Tu Código Express</p>
              
              {/* Simulador de QR */}
              <div className="w-48 h-48 bg-white border-8 border-gray-900 p-2 mx-auto mb-6 flex flex-wrap content-start shadow-sm rounded-lg">
                {[...Array(25)].map((_, i) => (
                  <div key={i} className={`w-[20%] h-[20%] ${i % 2 === 0 || i % 7 === 0 ? 'bg-gray-900' : 'bg-transparent'}`}></div>
                ))}
              </div>
              
              <p className="font-black text-3xl text-gray-900 tracking-widest mb-2">7XK9-M2L5</p>
              <p className="text-sm text-gray-500">Muestra este código al recoger tu primer pedido y realizar tu pago físico.</p>
            </div>

            <button onClick={() => { setPaso(1); setEmail(''); setDiasSeleccionados(['Lun', 'Mar', 'Mie', 'Jue', 'Vie']); }} className="text-orange-500 font-bold text-sm">
              Volver al inicio
            </button>
          </div>
        )}
      </main>
    </div>
  );
}