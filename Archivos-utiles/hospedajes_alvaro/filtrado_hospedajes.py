import pandas as pd

df = pd.read_csv('./datosgob_2024.csv', encoding='latin-1')

df[df.Giro.str.contains('hotel|turis|turís', case=False, na=False, regex=True)].Estado.unique().count()
