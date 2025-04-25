from flask import Flask, jsonify, request, make_response
from GrafoDestinos import GrafoDestinos

app = Flask(__name__)

# Sin docker
grafo = GrafoDestinos('../database/seeds/data/destinos.csv')
# Con docker
# grafo = GrafoDestinos('destinos.csv')
print(len(grafo.matriz_adyacencia))

# Home route
@app.route('/')
def home():
    return jsonify({"message": "Welcome to the Flask API!"})

@app.route('/api/kshortestpaths', methods=['GET'])
def kshortestPaths():
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
        "message": "Received query parameters",
        "k_paths": k_paths
    })

# Run server
if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)

