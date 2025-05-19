import pandas as pd
import numpy as np
from math import radians, sin, cos, sqrt, atan2
import networkx as nx
from networkx.algorithms.simple_paths import shortest_simple_paths

class GrafoDestinos:
    def __init__(self, path_destinos_csv, K = 5, a = 0.5, b = 0.8):
        self._df_destinos = pd.read_csv(path_destinos_csv)
        self._matriz_distancias = self._generar_matriz_distancias()
        self._df_distancias = self._generar_dataframe_distancias()
        self.matriz_adyacencia = self._generar_matriz_adyacencia(K, a, b)
        self._graph = self._generar_grafo_ponderado_no_dirigido()

    def _calcular_distancia(self, lat1, lon1, lat2, lon2):
        R = 6371.0  # Radio de la Tierra en km

        dlat = radians(lat2 - lat1)
        dlon = radians(lon2 - lon1)

        a = sin(dlat/2)**2 + cos(radians(lat1)) * cos(radians(lat2)) * sin(dlon/2)**2
        c = 2 * atan2(sqrt(a), sqrt(1 - a))

        return R * c

    def _generar_matriz_distancias(self):
        len_destinos = len(self._df_destinos)
        matriz = np.zeros((len_destinos, len_destinos))
        for org_idx, org_row in self._df_destinos.iterrows():
            for dest_idx, dest_row in self._df_destinos.iterrows():
                if org_idx == dest_idx:
                    matriz[org_idx][dest_idx] = 0
                    continue
                matriz[org_idx][dest_idx] = self._calcular_distancia(org_row['lat'], org_row['lon'], dest_row['lat'], dest_row['lon'])
        min_matriz = np.min(matriz)
        max_matriz = np.max(matriz)
        normalized_matriz = ((matriz - min_matriz) / (max_matriz - min_matriz)) * 100
        return normalized_matriz

    def _generar_dataframe_distancias(self):
        self._df_distancias = pd.DataFrame(self._matriz_distancias)
        return self._df_distancias

    def _generar_matriz_adyacencia(self, K = 5, a = 50, b = 0.5):
        """
        Genera la matriz de adyacencia conectando los K vértices más cercanos a cada vértice.
        La ponderación se da tomando la distancia entre los destinos y multiplicándola por un escalar,
        dependiendo de si ambos tienen aeropuerto o no.
        @params
        K: número de vértices a conectar.
        a: escalar para aeropuertos.
        b: escalar para autobuses.
        @return void
        """
        # Replace 0s and self-connections with np.inf to ignore them
        adj_masked = self._df_distancias.mask((self._df_distancias == 0) | (np.eye(len(self._df_distancias), dtype=bool)), np.inf)
        # Get the indices (column names) of the K smallest values per row
        k_neighbors = adj_masked.apply(lambda row: row.nsmallest(K).index.tolist(), axis=1)

        # Convert to list of lists
        k_neighbors_list = k_neighbors.tolist()

        # Los pesos se generan tomando la distancia entre lo destinos multiplicadas
        # por escalares a y b. Estos escalares alteran los pesos para darle mayor prioridad
        # a los destinos con aeropuertos.
        self.matriz_adyacencia = np.zeros((len(self._df_destinos), len(self._df_destinos)))

        for i in range(len(self._df_destinos)):
            for j in range(len(self._df_destinos)):
                if i == j:
                    # matriz_adyacencia[i][j] = np.inf
                    continue

                ambos_tienen_aeropuerto = self._df_destinos.iloc[i]['tiene_aeropuerto'] == 1 and self._df_destinos.iloc[j]['tiene_aeropuerto']

                if ambos_tienen_aeropuerto:
                    self.matriz_adyacencia[i][j] = a * self._df_distancias.iloc[i][j]
                elif j in k_neighbors_list[i]:
                    self.matriz_adyacencia[i][j] = b * self._df_distancias.iloc[i][j]
                # else:
                #     matriz_adyacencia[i][j] = np.inf

        return self.matriz_adyacencia

    def _generar_grafo_ponderado_no_dirigido(self):
        # Create a graph from the adjacency matrix
        self._graph = nx.from_numpy_array(self.matriz_adyacencia, create_using=nx.DiGraph())

        # Remove zero-weight (no connection) edges (optional if 0 means no edge)
        self._graph.remove_edges_from([(u, v) for u, v, d in self._graph.edges(data=True) if d['weight'] == 0])
        return self._graph

    def obtener_K_paths_mas_cortos(self, source, target, K = 3):
        """
        Obtiene los K caminos más cortos entre dos vértices del grafo mediante el algoritmo de Yen.
        @params
        source: Vértice Origen dado por el index del destino en el dataframe de destinos.
        target: Vértice Objetivo dado por el index del destino en el dataframe de destinos.
        """
        # Use Yen's algorithm (shortest_simple_paths returns paths sorted by total weight)
        paths_generator = shortest_simple_paths(self._graph, source, target, weight='weight')
        k_best_paths = list(next(paths_generator) for _ in range(K))

        return k_best_paths


    def obtener_K_paths_mas_cortos_con_nombres(self, source, target, K = 3):
        k_best_paths = self.obtener_K_paths_mas_cortos(source, target, K)

        paths_con_nombres = list()
        for i, path in enumerate(k_best_paths, 1):
            nombres = list()
            for j, v in enumerate(path):
                nombres.append(self._df_destinos.iloc[v]['nombre'])
            paths_con_nombres.append(nombres)

        return (k_best_paths, paths_con_nombres)

    def obtener_K_paths_mas_cortos_con_ids(self, source, target, K = 3):
        k_best_paths = self.obtener_K_paths_mas_cortos(source, target, K)

        paths_con_ids = list()
        for i, path in enumerate(k_best_paths, 1):
            ids = list()
            for j, v in enumerate(path):
                ids.append(int(self._df_destinos.iloc[v]['id']))
            paths_con_ids.append(ids)

        return paths_con_ids

    def obtener_distancia_entre_destinos(self, source, target):
        return self._calcular_distancia(source['lat'], source['lon'], target['lat'], target['lon'])

    def obtener_destino_mas_cercano_a_coordenadas(self, lat, lon):
        destinos = list()
        for idx, row in self._df_destinos.iterrows():
            idx_distancia = {
                'idx': idx,
                'distancia': self._calcular_distancia(lat, lon, row['lat'], row['lon'])
            }
            destinos.append(idx_distancia)

        destinos = sorted(destinos, key=lambda pair: pair['distancia'])
        destino = destinos[0]
        duracion_min = int(destino['distancia'] / 60 * 60 + 60)  # velocidad media + paradas
        precio = int(destino['distancia'] * 0.7 + 100)
        return (destino['idx'], destino['distancia'], duracion_min, precio)
