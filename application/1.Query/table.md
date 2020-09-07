## Database
```php
# Get table name from model instance
$instance->getTable();

# Get table columns
Schema::getcolumnListing($table);

# Check table column exist
if(Schema::hasColumn($table, $column)) { }
```
