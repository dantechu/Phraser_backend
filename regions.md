# Regions Feature Documentation

## Overview
The Regions feature allows you to create and manage geographical categories that can be assigned to phrasers. Each region has a name (no colors), and multiple regions can be assigned to each phraser.

## Database Setup

### 1. Create Database Tables
Run the following SQL commands in your database:

```sql
-- Create regions table
CREATE TABLE IF NOT EXISTS `tbl_regions` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `region_name` varchar(255) NOT NULL,
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `region_name` (`region_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create phraser-region junction table
CREATE TABLE IF NOT EXISTS `tbl_phraser_regions` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `phraser_id` int(11) NOT NULL,
    `region_id` int(11) NOT NULL,
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `phraser_id` (`phraser_id`),
    KEY `region_id` (`region_id`),
    UNIQUE KEY `unique_phraser_region` (`phraser_id`, `region_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### 2. Import Default Regions from CSV

#### Option A: Using phpMyAdmin
1. Open phpMyAdmin
2. Select your database
3. Click on `tbl_regions` table
4. Click "Import" tab
5. Choose the `regions_setup.csv` file
6. Set format to "CSV"
7. Configure import settings:
   - Column separator: `,`
   - Columns enclosed by: `"`
   - Lines terminated by: `auto`
   - Ignore first line (if headers): ✓
8. Click "Go" to import

#### Option B: Using MySQL Command Line
```bash
# Navigate to the backend directory
cd /path/to/phraser/backend

# Import CSV data
mysql -u username -p database_name -e "
LOAD DATA LOCAL INFILE 'regions_setup.csv' 
INTO TABLE tbl_regions 
FIELDS TERMINATED BY ',' 
ENCLOSED BY '\"' 
LINES TERMINATED BY '\n' 
IGNORE 1 ROWS 
(region_name);"
```

#### Option C: Manual SQL Insert
If CSV import doesn't work, run this SQL:

```sql
INSERT INTO `tbl_regions` (`region_name`) VALUES
('Eastern'),
('Western');
```

## CSV File Structure

The `regions_setup.csv` file contains:
```csv
region_name
Eastern
Western
```

## Usage

### Managing Regions
1. Navigate to **Admin Panel > Manage Regions**
2. **Add New Region**: Click "ADD NEW REGION" button
3. **Edit Region**: Click edit icon next to any region
4. **Delete Region**: Click delete icon (removes from all phrasers)

### Assigning Regions to Phrasers
1. Go to **Add Phraser** or **Edit Phraser**
2. In the "Regions (Optional)" dropdown:
   - Select multiple regions by clicking on them
   - Use search to find specific regions
   - Selected regions appear in the dropdown button
3. Save the phraser

### Viewing Region Assignments
- In the **Manage Phraser** page, regions appear as gray badges in the "Regions" column
- Usage counts are shown in **Manage Regions**

## Features

### Multi-Select Dropdown
- **Search**: Type to filter regions
- **Multiple Selection**: Choose multiple regions per phraser
- **Pre-selection**: Previously assigned regions are pre-selected in edit mode
- **Clean Display**: Regions display as gray badges (no colors)

### Usage Tracking
- View how many phrasers use each region
- Prevent accidental deletion of widely-used regions

### Administrative Features
- Add custom regions beyond Eastern/Western
- Edit region names
- Track region usage across all phrasers

## Expanding Regions

You can easily add more regions by:

1. **Via Admin Panel**: 
   - Go to Manage Regions > Add New Region
   - Enter region name (e.g., "Central", "Northern", "Southern")

2. **Via SQL**:
   ```sql
   INSERT INTO tbl_regions (region_name) VALUES 
   ('Central'),
   ('Northern'),
   ('Southern'),
   ('International');
   ```

3. **Update CSV and Re-import**:
   ```csv
   region_name
   Eastern
   Western
   Central
   Northern
   Southern
   International
   ```

## Troubleshooting

### Common Issues

1. **CSV Import Fails**
   - Ensure file encoding is UTF-8
   - Check column separator is comma
   - Verify no extra blank lines in CSV
   - Ensure column header is exactly "region_name"

2. **Dropdown Not Working**
   - Verify Bootstrap Select is loaded
   - Check for JavaScript errors in browser console
   - Ensure regions table has data

3. **Regions Not Displaying**
   - Check if `tbl_phraser_regions` junction table exists
   - Verify relationships are being created when saving phrasers

### Verification Steps

1. **Check Tables Created**:
   ```sql
   SHOW TABLES LIKE 'tbl_regions';
   SHOW TABLES LIKE 'tbl_phraser_regions';
   ```

2. **Verify Data Import**:
   ```sql
   SELECT COUNT(*) FROM tbl_regions;
   SELECT * FROM tbl_regions;
   ```

3. **Test Relationships**:
   ```sql
   SELECT COUNT(*) FROM tbl_phraser_regions;
   
   -- View phraser-region relationships
   SELECT p.quote, r.region_name 
   FROM tbl_gallery p 
   JOIN tbl_phraser_regions pr ON p.id = pr.phraser_id 
   JOIN tbl_regions r ON pr.region_id = r.id 
   LIMIT 10;
   ```

4. **Check Junction Table Structure**:
   ```sql
   DESCRIBE tbl_phraser_regions;
   ```

## File Locations

- **CSV File**: `backend/regions_setup.csv`
- **SQL File**: `backend/regions_setup.sql`
- **Management Pages**: 
  - `backend/regions.php`
  - `backend/regions-add.php`
  - `backend/regions-edit.php`
  - `backend/regions-delete.php`

## Advanced Usage

### Bulk Region Assignment
You can assign regions to existing phrasers via SQL:

```sql
-- Assign all phrasers to Eastern region (region_id = 1)
INSERT INTO tbl_phraser_regions (phraser_id, region_id)
SELECT id, 1 FROM tbl_gallery 
WHERE id NOT IN (
    SELECT phraser_id FROM tbl_phraser_regions WHERE region_id = 1
);
```

### Region Statistics
```sql
-- Most popular regions
SELECT r.region_name, COUNT(pr.phraser_id) as usage_count
FROM tbl_regions r
LEFT JOIN tbl_phraser_regions pr ON r.id = pr.region_id
GROUP BY r.id, r.region_name
ORDER BY usage_count DESC;

-- Phrasers without regions
SELECT COUNT(*) as unassigned_phrasers
FROM tbl_gallery g
WHERE g.id NOT IN (SELECT DISTINCT phraser_id FROM tbl_phraser_regions);
```

## Notes

- Regions are optional for phrasers
- Multiple regions can be assigned to each phraser
- Deleting a region removes it from all phrasers
- Region names must be unique
- No color system for regions (unlike moods)
- Regions display as gray badges in listings
- Default regions are "Eastern" and "Western"