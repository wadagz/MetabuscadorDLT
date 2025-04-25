# Use official Python image as a base
FROM python:3.11-slim

# Set environment variables
ENV PYTHONDONTWRITEBYTECODE=1
ENV PYTHONUNBUFFERED=1

# Set working directory
WORKDIR /app

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    gcc \
    && rm -rf /var/lib/apt/lists/*

# Install Python dependencies
COPY ./flask-api/requirements.txt .
RUN pip install --upgrade pip && pip install -r requirements.txt

# Copy dataset
COPY ./database/seeds/data/destinos.csv .

# Copy the rest of the app
COPY ./flask-api/ .

# Expose the port your Flask app runs on
EXPOSE 5000

# Run the app
CMD ["python", "app.py"]

