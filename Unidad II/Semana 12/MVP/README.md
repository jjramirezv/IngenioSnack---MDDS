# Diseño del Producto Mínimo Viable (MVP)


## Descripción del MVP Elegido
Para validar esta hipótesis, construiremos una **Landing Page de "Falsa Puerta" (Fake Door)**. 

*   **¿En qué consiste?** Se desarrollará una página web de una sola vista (usando React/Next.js) que presenta la propuesta de valor del nuevo servicio de "Suscripción IngenioSnack". 
*   **Interacción Funcional:** La página incluirá botones de "Suscribirme por S/ 25 a la semana". Al hacer clic, se pedirá el correo institucional del alumno. Un microservicio en FastAPI capturará estos correos.
*   **Cierre del Experimento:** Una vez registrado el correo, se le mostrará un mensaje indicando que el servicio está en fase de prueba y se le notificará cuando haya cupos, midiendo así la intención de compra real.

## Justificación
Este MVP cumple con ser el experimento más barato y rápido de construir por las siguientes razones:
1.  **Cero Inversión en Insumos:** El Sr. Julio no necesita gastar en panes, café ni empaques hasta comprobar cuántos correos se registran mostrando interés real en pagar.
2.  **Desarrollo Ágil:** Evitamos programar pasarelas de pago, bases de datos relacionales complejas y sistemas de gestión de inventario. Solo necesitamos un frontend básico y un recolector de datos.
3.  **Métrica Real:** Nos permite medir acciones reales (clics en el botón de suscripción y correos dejados) en lugar de opiniones basadas en encuestas.
