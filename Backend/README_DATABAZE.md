# Průvodce databázemi

## Rozdíl mezi soubory

### `dad_db.sql` (lokální vývoj)
- **Název databáze**: `dad_db`
- **Datum**: 18. dubna 2025
- **Server**: 127.0.0.1 (lokální)
- **Engine**: InnoDB ✅ (lepší pro produkci)
- **Foreign Keys**: ANO ✅
- **Primary Key na password_reset_codes**: ANO ✅
- **Počet ticketů**: 15
- **Počet uživatelů**: 10
- **Stav**: Starší, ale struktura je lepší

### `mydb.sql` (produkční server)
- **Název databáze**: `dad`
- **Datum**: 26. dubna 2025 (novější!)
- **Server**: endora-db-11.stable.cz:3306 (produkční)
- **Engine**: MyISAM ⚠️ (starší, bez foreign keys)
- **Foreign Keys**: NE ❌
- **Primary Key na password_reset_codes**: NE ❌
- **Počet ticketů**: 27
- **Počet uživatelů**: 19
- **Stav**: Novější data, ale horší struktura

## Kterou databázi použít?

### Pro lokální vývoj:
**Použijte `dad_db.sql`** - frontend očekává název `dad_db` (viz `Frontend/components/db.php`)

### Pro produkci:
**Doporučuji upravit `mydb.sql`** - má více dat, ale potřebuje opravy struktury

## Problémy v mydb.sql:

1. ❌ **Chybí PRIMARY KEY na password_reset_codes**
2. ❌ **Chybí FOREIGN KEY constraints** (bezpečnost a integrita dat)
3. ❌ **MyISAM místo InnoDB** (horší pro transakce)
4. ❌ **Někteří uživatelé mají prázdné heslo** (bezpečnostní riziko!)
5. ⚠️ **Název databáze je `dad` místo `dad_db`**

## Doporučení:

### Pro lokální vývoj:
1. Importujte `dad_db.sql`
2. Název databáze: `dad_db`
3. Vše by mělo fungovat

### Pro produkci (pokud chcete použít mydb.sql):
1. Upravte název databáze na `dad_db` nebo změňte `db.php`
2. Opravte strukturu (viz níže)

## Jak importovat:

### phpMyAdmin:
1. Vytvořte novou databázi `dad_db`
2. Vyberte ji
3. Klikněte na "Import"
4. Vyberte `dad_db.sql`
5. Klikněte "Go"

### Příkazová řádka:
```bash
mysql -u root -p -e "CREATE DATABASE dad_db CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci;"
mysql -u root -p dad_db < Backend/dad_db.sql
```

## Opravy pro mydb.sql (pokud chcete použít produkční data):

Vytvořil jsem opravenou verzi - viz `dad_db_fixed.sql` (pokud existuje)

