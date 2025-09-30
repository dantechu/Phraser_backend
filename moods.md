# Moods Feature Documentation

## Overview
The Moods feature allows you to create and manage emotional categories that can be assigned to phrasers. Each mood has a name and color, and multiple moods can be assigned to each phraser.

## Database Setup

### 1. Create Database Tables
Run the following SQL commands in your database:

```sql
-- Create moods table
CREATE TABLE IF NOT EXISTS `tbl_moods` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `mood_name` varchar(255) NOT NULL,
    `mood_color` varchar(7) DEFAULT '#000000',
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `mood_name` (`mood_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create phraser-mood junction table
CREATE TABLE IF NOT EXISTS `tbl_phraser_moods` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `phraser_id` int(11) NOT NULL,
    `mood_id` int(11) NOT NULL,
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `phraser_id` (`phraser_id`),
    KEY `region_id` (`mood_id`),
    UNIQUE KEY `unique_phraser_mood` (`phraser_id`, `mood_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### 2. Import Default Moods from CSV

#### Option A: Using phpMyAdmin
1. Open phpMyAdmin
2. Select your database
3. Click on `tbl_moods` table
4. Click "Import" tab
5. Choose the `moods_setup.csv` file
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
LOAD DATA LOCAL INFILE 'moods_setup.csv' 
INTO TABLE tbl_moods 
FIELDS TERMINATED BY ',' 
ENCLOSED BY '\"' 
LINES TERMINATED BY '\n' 
IGNORE 1 ROWS 
(mood_name, mood_color);"
```

#### Option C: Manual SQL Insert
If CSV import doesn't work, run this SQL:

```sql
INSERT INTO `tbl_moods` (`mood_name`, `mood_color`) VALUES
('Happy', '#FFD700'),
('Sad', '#4169E1'),
('Motivated', '#FF4500'),
('Calm', '#32CD32'),
('Excited', '#FF1493'),
('Thoughtful', '#8B4513'),
('Romantic', '#DC143C'),
('Peaceful', '#00CED1');
```

## CSV File Structure

The `moods_setup.csv` file contains:
```csv
mood_name,mood_color
Happy,#FFD700
Sad,#4169E1
Motivated,#FF4500
Calm,#32CD32
Excited,#FF1493
Thoughtful,#8B4513
Romantic,#DC143C
Peaceful,#00CED1
```

## Usage

### Managing Moods
1. Navigate to **Admin Panel > Manage Moods**
2. **Add New Mood**: Click "ADD NEW MOOD" button
3. **Edit Mood**: Click edit icon next to any mood
4. **Delete Mood**: Click delete icon (removes from all phrasers)

### Assigning Moods to Phrasers
1. Go to **Add Phraser** or **Edit Phraser**
2. In the "Moods (Optional)" dropdown:
   - Select multiple moods by clicking on them
   - Use search to find specific moods
   - Selected moods appear as colored tags
3. Save the phraser

### Viewing Mood Assignments
- In the **Manage Phraser** page, moods appear as colored badges in the "Moods" column
- Each mood displays with its assigned color
- Usage counts are shown in **Manage Moods**

## Features

### Multi-Select Dropdown
- **Search**: Type to filter moods
- **Multiple Selection**: Choose multiple moods per phraser
- **Visual Display**: See mood colors in dropdown
- **Pre-selection**: Previously assigned moods are pre-selected in edit mode

### Color Management
- Each mood has a customizable color (hex code)
- Colors display in dropdowns and listings
- Default colors provided for initial moods

### Usage Tracking
- View how many phrasers use each mood
- Prevent accidental deletion of widely-used moods

## Troubleshooting

### Common Issues

1. **CSV Import Fails**
   - Ensure file encoding is UTF-8
   - Check column separators are commas
   - Verify no extra blank lines in CSV

2. **Colors Not Displaying**
   - Ensure color codes are valid hex (e.g., #FF0000)
   - Check CSS is loading properly

3. **Dropdown Not Working**
   - Verify Bootstrap Select is loaded
   - Check for JavaScript errors in browser console

### Verification Steps

1. **Check Tables Created**:
   ```sql
   SHOW TABLES LIKE 'tbl_moods';
   SHOW TABLES LIKE 'tbl_phraser_moods';
   ```

2. **Verify Data Import**:
   ```sql
   SELECT COUNT(*) FROM tbl_moods;
   SELECT * FROM tbl_moods LIMIT 5;
   ```

3. **Test Relationships**:
   ```sql
   SELECT COUNT(*) FROM tbl_phraser_moods;
   ```

## File Locations

- **CSV File**: `backend/moods_setup.csv`
- **SQL File**: `backend/moods_setup.sql`
- **Management Pages**: 
  - `backend/moods.php`
  - `backend/moods-add.php`
  - `backend/moods-edit.php`
  - `backend/moods-delete.php`

## Notes

- Moods are optional for phrasers
- Multiple moods can be assigned to each phraser
- Deleting a mood removes it from all phrasers
- Mood names must be unique
- Colors should be in hex format (#RRGGBB)