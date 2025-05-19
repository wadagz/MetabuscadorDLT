import pandas as pd
import requests
import time

# Lee CSV con lista de destinos (centros turísticos)
df = pd.read_csv('lista_destinos.csv')
df = df.drop_duplicates()

# Nombre del archivo de salida
output_file = "info_destinos.csv"

# Imprime la hora en pantalla para logs
print(f"[{time.strftime('%Y-%m-%d %H:%M:%S', time.localtime())}]")

def obtener_info_destino(destino):
    # Define la URL de la API con la consulta de búsqueda por nombre
    url = "https://nominatim.openstreetmap.org/search"
    
    # Parámetros de la consulta
    params = {
        'q': destino,  # Nombre del lugar
        'format': 'jsonv2',  # Formato de respuesta en JSONv2
        'addressdetails': 1,  # Para obtener detalles adicionales de la dirección
        'limit': 1,  # Limitar a un solo resultado
        'countrycodes': 'mx', # Limitar resultados a solo México
    }

    headers = {
        'User-Agent': 'metabuscador-dtl',  # Si no se pone un user-agent se enoja la API
        'Accept': 'application/json',  # Para aceptar respuesta en JSON
    }
    
    # Realiza la solicitud GET
    response = requests.get(url, params=params, headers=headers)

    # Imprime la respuesta en pantalla
    print(response.json())

    if response.status_code == 200:
        data = response.json()
        if data:
            # Extrae la información del primer resultado
            dest = data[0]
            name = dest['name']
            lat = dest['lat']
            lon = dest['lon']
            category = dest['category']
            type_of = dest['type']
            city = dest['address'].get('city', 'unkwown')
            county = dest['address'].get('county', 'unkwown')
            state = dest['address'].get('state', 'unkwown')
            postcode = dest['address'].get('postcode', 'unkwown')
            bounding_box = dest.get('boundingbox', (0,0,0,0))
            return name, category, type_of, city, county, state, postcode, lat, lon, bounding_box
        else:
            return None,None,None,None,None,None,None,None, None, None, None, None, None
    else:
        return None, None,None,None,None,None,None,None,None,None, None, None, None


header = 'nombre,categoria,tipo,ciudad,municipio,estado,codigopostal,lat,lon,min_lat,max_lat,min_lon,max_lon\n'
records = ''

with open(output_file, 'w') as file:
    file.write(header)

for i, row in enumerate(df.iterrows()):
    nombre_lugar = row[1]['destino'] + ',' + row[1]['pais']
    # print(nombre_lugar)
    name, category, type_of, city, county, state, postcode, lat, lon, box = obtener_info_destino(nombre_lugar)
    record = f"{name},{category},{type_of},{city},{county},{state},{postcode},{lat},{lon},{box[0]},{box[1]},{box[2]},{box[3]}\n"
    records = records + record

    # print(f"Nombre: {name}")
    # print(f"Categoria: {category}")
    # print(f"Tipo: {type_of}")
    # print(f"Ciudad: {city}")
    # print(f"Municipio: {county}")
    # print(f"Estado: {state}")
    # print(f"Codigo Postal: {postcode}")
    # print(f"Latitud: {lat}")
    # print(f"Longitud: {lon}")
    # print(f"Bounding Box: [ {box[0]}, {box[1]}, {box[2]}, {box[3]} ]")
    # print("-"*30)

    if i % 20 == 0:
        with open(output_file, 'a') as file:
            file.write(records)
        records = ""

    # Agregamos tiempo de espera de 1 segundo para respetar las políticas de uso de Nominatim
    time.sleep(1)
