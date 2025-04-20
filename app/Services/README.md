# Implementación de K-means para recomendaciones de hospedajes

## Resumen

Este documento explica cómo se implementó un sistema de recomendación utilizando el algoritmo K-means para ofrecer hospedajes personalizados a los usuarios basados en sus preferencias y las amenidades disponibles en cada alojamiento.

## Archivos creados

1. `App\Services\RecommendationService.php` - Servicio que implementa el algoritmo K-means para agrupar hospedajes similares y recomendar los más relevantes para un usuario específico.
2. `App\Http\Controllers\RecommendationController.php` - Controlador que utiliza el servicio de recomendación para mostrar hospedajes personalizados.

## Cómo funciona

### 1. Vectorización de datos

Para poder aplicar K-means, convertimos tanto los hospedajes como las preferencias de los usuarios en vectores numéricos:

- **Hospedajes**: Se convierten en vectores donde cada dimensión corresponde a una preferencia posible. Las amenidades, el tipo de hospedaje y el precio se mapean a las preferencias correspondientes.

- **Preferencias de usuarios**: Las preferencias seleccionadas por el usuario se convierten en un vector binario (1 para preferencias seleccionadas, 0 para el resto).

### 2. Agrupamiento con K-means

El algoritmo K-means agrupa los hospedajes en clusters basados en la similitud de sus características:

1. Se inicializan K centroides aleatorios (K=3 por defecto)
2. Se asigna cada hospedaje al centroide más cercano
3. Se recalculan los centroides como el promedio de los hospedajes en cada grupo
4. Se repiten los pasos 2-3 hasta que los grupos se estabilicen o se alcance el número máximo de iteraciones

### 3. Recomendación personalizada

Para recomendar hospedajes a un usuario específico:

1. Se encuentra el cluster cuyo centroide está más cercano al vector de preferencias del usuario
2. Se recomiendan los hospedajes pertenecientes a ese cluster
3. Si no hay suficientes hospedajes en el cluster, se complementan con hospedajes de otros clusters ordenados por similitud con las preferencias del usuario

## Mapeo de características

El sistema mapea las características de los hospedajes a las preferencias del usuario:

- **Amenidades** → Preferencias de la pregunta 2 (WiFi, piscina, etc.)
  - Utiliza AmenidadEnum para mapear cada amenidad específica a las preferencias correspondientes
  
- **Tipo de hospedaje** → Preferencias de la pregunta 1 (tranquilo, animado, etc.)
  - Utiliza TipoHospedajeEnum para relacionar cada tipo con los ambientes correspondientes
  
- **Precio** → Preferencias de la pregunta 3 (económico, lujoso, etc.)
  - Se definen rangos de precios para mapear a las diferentes preferencias de presupuesto
  
- **Características ecológicas** → Preferencias de la pregunta 4 (sostenibilidad)
  - Las amenidades relacionadas con sostenibilidad se mapean a estas preferencias
  
- **Ubicación** → Preferencias de la pregunta 5 (acceso a transporte, etc.)
  - Las amenidades y características relacionadas con la ubicación se mapean a estas preferencias
