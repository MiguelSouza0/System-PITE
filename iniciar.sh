#!/bin/bash
set -e

echo "==================================================="
echo "  System-PITE - Plataforma Inteligente de Turismo"
echo "==================================================="
echo ""

# Check docker command
DOCKER_CMD="docker"
if ! docker ps > /dev/null 2>&1; then
    if sudo docker ps > /dev/null 2>&1; then
        DOCKER_CMD="sudo docker"
    else
        echo "Erro: O daemon do Docker não está rodando ou seu usuário não possui acesso ao socket do Docker."
        echo "Verifique se o Docker Desktop está aberto ou adicione seu usuário ao grupo docker:"
        echo "  sudo usermod -aG docker \$USER"
        exit 1
    fi
fi

echo "1. Subindo contêineres Docker (App + PostgreSQL)..."
$DOCKER_CMD compose up -d --build

echo ""
echo "2. Aguardando inicialização do banco de dados e aplicação..."
sleep 6

echo ""
echo "3. Executando migrações do banco de dados..."
$DOCKER_CMD compose exec -T app php artisan migrate --force

echo ""
echo "4. Populando dados iniciais (Seeders)..."
$DOCKER_CMD compose exec -T app php artisan db:seed --force

echo ""
echo "==================================================="
echo "  System-PITE pronto para uso!"
echo "  Acesse no seu navegador: http://localhost:8080"
echo "==================================================="
