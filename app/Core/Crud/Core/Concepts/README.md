```php
// use Illuminate\Contracts\Support\Htmlable;
// use Illuminate\Database\Query\Builder as QueryBuilder;
// use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
// use App\Core\Crud\Core\Concepts\RecordsPagination;
// use App\Core\Crud\Core\Concepts\StringHelpers;
use Illuminate\Support\Fluent;
use App\Core\Crud\Core\Concepts\TableColumn;
use App\Core\Crud\Core\Concepts\Table;

$table = new Table();
$table->columns([
    TableColumn::make('id', 'ID'),
    TableColumn::make('name', 'Nome'),
    // TableColumn::make('created_at', 'Data'),
    TableColumn::make('created_at', 'Data formatada')->prepareContentUsing(function (Fluent $args) {
        $record = $args->record;
        return $record?->created_at?->diffForHumans();
    }),
    TableColumn::make('id', 'Data')->prepareContentUsing(function (Fluent $args) {
        $record = $args->record;
        $valor = $record?->id;
        return "prepareContentUsing: 'valor' => {$valor}";
    }),
]);

/*
$table->staticRecords([
    [
        'id' => 123,
        'name' => 'Tiago',
    ],
]);
/* */

$table->queryBuilder(App\Models\User::where('id', '>', 4));

// dd($table->getColumns()->map(fn(TableColumn $column) => $column->getKey()));
// dd($table->getKeys());
// dd($table->getRecords());
$table->setRequest(request()->merge([
    // 'page' => 1,
    // 'page' => 2,
    // 'page' => 3,
]));
// dd([
//     'limit' => $table->getRecordsLimit(),
//     'offset' => $table->getRecordsOffset(),
// ]);



dd($table->getPreparedContent());

```
