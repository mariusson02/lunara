#!/bin/bash

echo "Building the Docker image..."
docker compose build

# Check if the build was successful
if [ $? -ne 0 ]; then
    echo "Docker image build failed!"
    exit 1
fi

# Start the containers with Docker Compose in detached mode
echo "Starting the containers with Docker Compose..."
docker compose up -d

# Check if the containers started successfully
if [ $? -eq 0 ]; then
    echo "Containers started successfully!"
else
    echo "Failed to start containers!"
    exit 1
fi