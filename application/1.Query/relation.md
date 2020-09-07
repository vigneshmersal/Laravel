```php
//reset relations on EXISTING MODEL (control which ones will be loaded)
$this->relations = [];

//re-sync everything
$model->getRelations()
foreach ($this->relations as $relationName => $values){
    $new->{$relationName}()->sync($values);
}
```
