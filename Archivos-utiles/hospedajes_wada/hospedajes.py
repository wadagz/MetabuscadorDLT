import pandas as pd

def main():
    df = pd.read_csv('./AGU.csv')
    df_hospedajes = df.loc[df['Tipo PST'] == 'Hospedaje']
    print(df_hospedajes.drop(columns=['review']))

if __name__ == "__main__":
    main()
