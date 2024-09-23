
## Technology Stack

- **Backend**: Symfony 7.1
- **Frontend**: Vue.js 2.7
- **Database**: MySQL 8

# Build and run the image
docker compose build && docker compose up -d

# Install composer deps
docker compose exec backend composer install

# Make migration
docker compose exec backend bin/console doctrine:migrations:migrate --no-interaction

# Run fixture
docker compose exec backend bin/console doctrine:fixtures:load --no-interaction

# Instal node modules
docker compose exec backend npm i

# Add build
docker compose exec backend  npm run build

# API Documentation

## 1. Create a Carrier

**Endpoint:** `POST /api/carrier/new`

**Request Body:**
```json
{
  "name": "New Carrier",
  "carrierPriceRules": [
    {
      "type": "fixed",
      "fixedPrice": 20,
      "weightLimit": 10
    },
    {
      "type": "per_kg",
      "pricePerKg": 5
    }
  ]
}
```

## 2. Get All Carriers

**Endpoint:** `GET /api/carrier`

**Response:**
- **200 OK:** Returns a list of carriers.

**Example Response:**
```json
{
  "id": 1,
  "name": "New Carrier",
  "carrierPriceRules": [
    {
      "type": "fixed",
      "fixedPrice": 20,
      "weightLimit": 10
    },
    {
      "type": "per_kg",
      "pricePerKg": 5
    }
  ]
}
```
## 3. Create a Package

**Endpoint:** `POST /api/package/new`

**Request Body:**
```json
{
  "weight": 10,
  "carrier": 1
}
```

## 4. Get All Packages

**Endpoint:** `GET /api/package`

**Response:**
- **200 OK:** Returns a list of all packages.

**Example Response:**
```json
[
  {
    "id": 1,
    "weight": 10,
    "carrier": 1,
    "cost": 50
  },
  {
    "id": 2,
    "weight": 5,
    "carrier": 2,
    "cost": 30
  }
]
```
#Test
# Create the test database
docker compose exec backend  bin/console doctrine:database:create --env=test

# Run migrations for the test database
docker compose exec backend  bin/console doctrine:migrations:migrate --no-interaction --env=test

# (Optional) Load fixtures into the test database
docker compose exec backend  bin/console doctrine:fixtures:load --no-interaction --env=test

# Run the tests
docker compose exec backend  bin/phpunit

