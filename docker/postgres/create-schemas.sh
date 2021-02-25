#!/bin/bash
set -e

psql -v ON_ERROR_STOP=1 --username "$DB_USERNAME" --dbname "$DB_DATABASE" <<-EOSQL
    CREATE SCHEMA IF NOT EXISTS detectenv AUTHORIZATION admin;
    CREATE SCHEMA IF NOT EXISTS admin_panel AUTHORIZATION admin;
EOSQL
