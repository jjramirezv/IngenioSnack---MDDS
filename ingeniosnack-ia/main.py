from fastapi import FastAPI, UploadFile, File
from fastapi.responses import JSONResponse
import pandas as pd
from prophet import Prophet
import io

app = FastAPI(title="IngenioSnack AI Engine", version="1.0")

@app.post("/predict")
async def predict_sales(file: UploadFile = File(...)):
    try:
        # 1. Leer el CSV que envía Laravel
        contents = await file.read()
        df = pd.read_csv(io.StringIO(contents.decode('utf-8')))
        
        # Validar estructura de las columnas requeridas por Prophet
        if 'ds' not in df.columns or 'y' not in df.columns:
            return JSONResponse(
                content={"status": "error", "message": "El dataset debe contener las columnas 'ds' (Fecha) y 'y' (Ventas)."},
                status_code=400
            )

        # Validar cantidad de registros mínima para Prophet (requiere al menos 2 filas para el ajuste/fit)
        if len(df) < 2:
            return JSONResponse(
                content={
                    "status": "error",
                    "message": "Datos históricos insuficientes. Se requieren al menos 2 registros diarios de ventas para entrenar la IA."
                },
                status_code=400
            )
        # 2. Preparar los "Eventos Especiales" (holidays en Prophet)
        # Filtramos los días que sí tuvieron un evento académico
        events_df = df[df['event_name'].notna() & (df['event_name'] != '')].copy()
        
        holidays = None
        if not events_df.empty:
            holidays = pd.DataFrame({
                'holiday': events_df['event_name'].astype(str),
                'ds': pd.to_datetime(events_df['ds']),            
                'lower_window': 0,
                'upper_window': 1, # Considera el día del evento y un día de inercia
            })

        # 3. Configurar el Modelo Prophet
        # Desactivamos la anualidad porque solo tenemos 3 meses de data, 
        # pero activamos la estacionalidad semanal (aprende si los viernes se vende más)
        model = Prophet(yearly_seasonality=False, weekly_seasonality=True, holidays=holidays)
        
        # 4. Entrenar la Inteligencia Artificial con los datos de Don Julio
        model.fit(df)
        
        # 5. Predecir los próximos 15 días
        future = model.make_future_dataframe(periods=15)
        forecast = model.predict(future)
        
        # 6. Formatear la respuesta para Laravel y Chart.js
        # Nos quedamos solo con la fecha (ds) y la predicción (yhat)
        result = forecast[['ds', 'yhat']].tail(15)
        
        # Evitar predicciones negativas (no se pueden vender -5 sándwiches)
        result['yhat'] = result['yhat'].apply(lambda x: max(0, round(x, 2)))
        
        # Convertir a un diccionario limpio
        predictions = []
        for index, row in result.iterrows():
            predictions.append({
                "fecha": row['ds'].strftime('%Y-%m-%d'),
                "prediccion_ventas_soles": row['yhat']
            })
            
        return JSONResponse(content={"status": "success", "predictions": predictions})

    except Exception as e:
        return JSONResponse(content={"status": "error", "message": f"Error interno en la IA: {str(e)}"}, status_code=500)