# setup.ps1

# Anzeige: Image wird gebaut
Write-Output "Building the Docker image..."
docker compose build

# Prüfen, ob der Build erfolgreich war
if ($LASTEXITCODE -ne 0) {
    Write-Error "Docker image build failed!"
    exit 1
}

# Anzeige: Container werden gestartet
Write-Output "Starting the containers with Docker Compose..."
docker compose up -d

# Prüfen, ob die Container erfolgreich gestartet wurden
if ($LASTEXITCODE -eq 0) {
    Write-Output "Containers started successfully!"
} else {
    Write-Error "Failed to start containers!"
    exit 1
}
