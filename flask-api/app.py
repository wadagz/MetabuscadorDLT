from flask import Flask, jsonify, request, make_response
from GrafoDestinos import GrafoDestinos

app = Flask(__name__)

# Sin docker
grafo = GrafoDestinos('../database/seeds/data/destinos.csv')
# Con docker
# grafo = GrafoDestinos('destinos.csv')
# print(len(grafo.matriz_adyacencia))

# Home route
@app.route('/')
def home():
    return jsonify({"message": "Welcome to the Flask API!"})

@app.route('/api/kshortestpaths', methods=['GET'])
def kshortestPaths():
    """
    Obtiene los K caminos más cortos entre dos destinos.
    @return lista de listas con los id de los destinos en el orden de enrutamiento.
    """
    global grafo

    # Get query parameters
    origin_id = request.args.get('origin_id')
    target_id = request.args.get('target_id')
    K = request.args.get('K')

    # Se reduce en 1 porque los indices de los vértices comienzan en 0
    origin_id = int(origin_id) - 1
    target_id = int(target_id) - 1
    K = int(K)

    try:
        k_paths = grafo.obtener_K_paths_mas_cortos_con_ids(origin_id, target_id, K)
    except(error):
        print(error)
        response = make_response('Internal Server Error', 500)
        return response

    return jsonify({
        "k_paths": k_paths
    })

@app.route('/api/getNearestDestinoToCoordinates', methods=['GET'])
def getNearestDestinoToCoordinates():
    """
    Busca el destino más cercano a las coordenadas provistas en los parámetros
    de la query.
    @return id del destino más cercano.
    """
    global grafo

    # Get query parameters
    lat = request.args.get('lat')
    lon = request.args.get('lon')

    # Se reduce en 1 porque los indices de los vértices comienzan en 0
    lat = float(lat)
    lon = float(lon)

    try:
        destino_idx, distancia, duracion_min, precio = grafo.obtener_destino_mas_cercano_a_coordenadas(lat, lon)
        # Aumentar en 1 el idx para que sea el id en la DB.
        destino_id = destino_idx + 1
    except Exception as e:
        print(e)
        response = make_response('Internal Server Error', 500)
        return response

    return jsonify({
        "id": destino_id,
        "distancia": distancia,
        "duracionMin": duracion_min,
        "precio": precio
    })

# Run server
if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)

