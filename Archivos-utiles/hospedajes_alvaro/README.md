# Hospedajes (HOTELES)

Los archivos `hospedajes_hoteles.csv` y `propietarios.csv` fueron obtenidos del
archivo `datosgob_2024.csv`.

Se tomaron datos de email y telefono de `datosgob_2024.csv` para generar el
archivo de propietarios, y el resto de datos fue usado para hospedajes_hoteles.

Los destinos asociados a cada hospedaje fueron seleccionados aleatoriamente del
data set `destinos.csv`, hallado en el directorio `../destinos/` relativo a este
directorio.

Este directorio se llama `hospedajes_alvaro` porque el data set utilizado fue encontrado por Alvaro, y pues para tener un poco más organizados los experimentos.

## Sun 13 Apr 2025
El archivo `filtrado_hospedajes.ipynb` fue modificado para tratar de obtener hoteles con direcciones en base al archivo `datosgob_2024.csv` haciendo uso de la API de Nominatim.

Para evitar ser bloqueado por la API, se procesaron por separado dos lotes, los cuales fueron combinados en el archivo `merge_local_and_colab_files.ipynb`. Además, en este archivo se agregó la columna `destino_id` tomando la latitud y longitud del hospedaje y comprobando si está se encuentra en el bounding box de algunos de los destinos guardados en el archivo `destinos.csv`.

Se generaron más hospedajes haciendo búsquedas en la API de Nominatim con el parámetro `amenity=Hoteles en` e indicando la ciudad y estado del destino. No todos los resultados fueron correctos, pero pues ahora tenemos más de donde agarrar.

Los resultados de estas búsquedas van a ser combinados.