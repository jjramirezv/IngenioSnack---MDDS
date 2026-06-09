# 🚀 Documentación y Refactorización - IngenioSnack

Este documento detalla las recientes actualizaciones arquitectónicas, lógicas de negocio y mejoras de Interfaz de Usuario (UI) aplicadas al sistema central de IngenioSnack. 

Nuestra plataforma opera bajo un modelo híbrido: un núcleo monolítico en **Laravel (PHP)** que se comunica con un microservicio predictivo en **FastAPI (Python)**.

---

## 🛠️ 1. Arquitectura de Despliegue (Railway)

Para garantizar la persistencia de los datos en un entorno de contenedores efímeros, se ha implementado la siguiente estrategia:

* **Volumen Persistente:** Se configuró un disco duro virtual montado en la ruta `/data`.
* **Base de Datos:** El sistema utiliza **SQLite** en producción. El archivo `database.sqlite` vive exclusivamente dentro del volumen `/data` para evitar la pérdida de usuarios, órdenes y recompensas durante los nuevos despliegues (`git push`).
* **Variables de Entorno Críticas:**
  * `DB_DATABASE=/data/database.sqlite`
  * `AI_URL` (Apunta al contenedor independiente de Python).

---

## 👨‍🍳 2. Monitor de Cocina Dinámico (Panel de Don Pepe)

Se rediseñó por completo el `SellerOrderController` y la vista de gestión de pedidos para mejorar la experiencia de usuario (UX) en la cocina.

### Mejoras Implementadas:
* **Filtro de Estados:** Los tickets fluyen por los estados `pending` ➔ `preparing` ➔ `ready` ➔ `completed`.
* **Sistema de Pestañas (Alpine.js):** Se integró un switch reactivo en la vista sin recarga de página:
  1. **Tickets Activos:** Muestra únicamente los pedidos en preparación mediante tarjetas interactivas.
  2. **Historial de Pedidos:** Una tabla limpia de solo lectura que carga los últimos 20 pedidos (entregados o cancelados) para auditoría rápida.
* **Prevención de Pérdida de Stock:** Si un pedido se cancela, el sistema itera sobre los productos y devuelve automáticamente el inventario (`stock_quantity`) a la base de datos.

---

## 🎁 3. Lógica del Sistema de Recompensas

Se implementó el motor de fidelización de clientes basado en tablas pivote (`user_promotions`).

### Flujo de Ejecución:
1. Al marcar un pedido como `completed` en el monitor de cocina, el sistema intercepta la acción.
2. Verifica si los productos entregados coinciden con alguna promoción activa (ej. *Compra 10 Chaufas, Gana 1 Chicolac*).
3. Suma la cantidad exacta comprada al progreso del usuario (`progress`).
4. **Validación Visual:** La barra de progreso en la vista del menú se llena dinámicamente usando porcentajes matemáticos calculados en el controlador.

---

## 🛒 4. Venta Sustituta (Cross-selling de Emergencia)

Para evitar la pérdida de ventas por falta de inventario, se programó un sistema inteligente de recomendaciones.

### Funcionalidad (`Product Model`):
* Se creó el atributo dinámico `getRecommendationsAttribute()`.
* Si el stock de un producto (ej. *Pan con Queso*) llega a **0**, la tarjeta se bloquea en la vista del alumno.
* Automáticamente, el sistema consulta la base de datos y ofrece hasta **2 alternativas aleatorias** que pertenezcan a la **misma categoría** y que **sí tengan stock** (ej. *Pan con Pollo*).
* Se incorporó un botón de compra rápida directa desde la recomendación para minimizar la fricción del usuario.

---

## 🐛 5. Corrección de Bugs Críticos
* **Bug Fix (Auth):** Se solucionó el error `RouteNotFoundException [dashboard]` en `RegisteredUserController.php`. Los nuevos usuarios ahora son redirigidos correctamente a `route('menu.index')` tras el registro exitoso.x