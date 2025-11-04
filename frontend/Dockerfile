FROM node:18-alpine

WORKDIR /app

# Copia package.json e installa dipendenze
COPY src/package*.json ./
RUN npm install -g @angular/cli@15 && npm install

# Copia tutto il codice sorgente Angular
COPY src/ ./

# Espone la porta Angular dev server
EXPOSE 4200

# Comando di default: serve in modalità sviluppo
CMD ["npm", "run", "start", "--", "--host", "0.0.0.0"]
