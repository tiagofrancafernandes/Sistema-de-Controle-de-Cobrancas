<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Core\Crud\Core\Concepts\Table;
use App\Core\Crud\Core\Concepts\TableColumn;
use Illuminate\Support\Fluent;
use Illuminate\Http\Request;

// use Illuminate\Foundation\Application;

Route::prefix('crud')->name('crud.')->group(function () {
    Route::get(
        '/index',
        fn () => Inertia::render(
            'CRUD/Pages/List',
            [
                'tenant' => tenant(),
                'pageTitle' => 'DEV Index',
                'pageData' => json_decode(
                    <<<'JSON'
                    {
                        "table": {
                            "columns": [
                                {
                                    "key": "id",
                                    "label": "ID",
                                    "content": null,
                                    "attributes": {
                                        "attr1": "val1",
                                        "attr2": "val2"
                                    },
                                    "classes": [],
                                    "headerComponent": null,
                                    "dataComponent": null,
                                    "sortable": false,
                                    "sortableKey": "id",
                                    "show": true,
                                    "type": "content"
                                },
                                {
                                    "key": "name",
                                    "label": "Package",
                                    "content": null,
                                    "attributes": {
                                        "attr1": "val1",
                                        "attr2": "val2"
                                    },
                                    "classes": [],
                                    "headerComponent": null,
                                    "dataComponent": null,
                                    "sortable": false,
                                    "sortableKey": "id",
                                    "show": true,
                                    "type": "content"
                                },
                                {
                                    "key": "price",
                                    "label": "Price",
                                    "content": null,
                                    "attributes": {
                                        "attr1": "val1",
                                        "attr2": "val2"
                                    },
                                    "classes": [],
                                    "headerComponent": null,
                                    "dataComponent": "CrudTBodyTD2Lines",
                                    "sortable": false,
                                    "sortableKey": "id",
                                    "show": true,
                                    "type": "content",
                                    "props": {
                                        "staticProps": {
                                            "abc": 123,
                                            "xyz": 465
                                        },
                                        "dynamicProps": {
                                            "userId": {
                                                "callable": "recordAttribute",
                                                "params": [
                                                    "id"
                                                ]
                                            },
                                            "date": {
                                                "callable": "evalThis",
                                                "params": [
                                                    "(new Date('2024-01-28')).toLocaleString()"
                                                ]
                                            },
                                            "now": {
                                                "callable": "evalThis",
                                                "params": [
                                                    "(new Date()).toLocaleString()"
                                                ]
                                            },
                                            "lineOne": {
                                                "callable": "recordAttribute",
                                                "params": [
                                                    "name"
                                                ]
                                            },
                                            "lineTwo": {
                                                "callable": "recordAttribute",
                                                "params": [
                                                    "price"
                                                ]
                                            }
                                        }
                                    }
                                },
                                {
                                    "key": "invoiceDate",
                                    "label": "Invoice date",
                                    "content": null,
                                    "attributes": {
                                        "attr1": "val1",
                                        "attr2": "val2"
                                    },
                                    "classes": [],
                                    "headerComponent": null,
                                    "dataComponent": null,
                                    "sortable": false,
                                    "sortableKey": "id",
                                    "show": true,
                                    "type": "content"
                                },
                                {
                                    "key": "status",
                                    "label": "Status",
                                    "content": null,
                                    "attributes": {
                                        "attr1": "val1",
                                        "attr2": "val2"
                                    },
                                    "classes": [],
                                    "headerComponent": null,
                                    "dataComponent": null,
                                    "sortable": false,
                                    "sortableKey": "id",
                                    "show": true,
                                    "type": "content"
                                },
                                {
                                    "key": "actions",
                                    "label": "Actions",
                                    "content": null,
                                    "attributes": {
                                        "attr1": "val1",
                                        "attr2": "val2"
                                    },
                                    "classes": [],
                                    "headerComponent": null,
                                    "dataComponent": null,
                                    "sortable": false,
                                    "sortableKey": "id",
                                    "show": true,
                                    "type": "actionGroup"
                                }
                            ]
                        },
                        "records": [
                            {
                                "id": 15,
                                "name": "Free Package",
                                "price": "$0.00",
                                "invoiceDate": "Jan 13, 2025",
                                "status": "Paid"
                            },
                            {
                                "id": 16,
                                "name": "Standard Package",
                                "price": "$79.00",
                                "invoiceDate": "Jan 13, 2025",
                                "status": "Paid"
                            },
                            {
                                "id": 17,
                                "name": "Business Package",
                                "price": "$99.00",
                                "invoiceDate": "Jan 13, 2025",
                                "status": "Unpaid"
                            },
                            {
                                "id": 18,
                                "name": "Standard Package",
                                "price": "$59.00",
                                "invoiceDate": "Jan 13, 2025",
                                "status": "Pending"
                            }
                        ]
                    }
                    JSON,
                    true
                )
            ]
        )
    )->name('index');

    Route::get(
        '/index/v2',
        function (Request $request) {
            $genColumn = fn (array $array = []) => array_merge([
                'key' => 'id',
                'label' => 'ID',
                'content' => null,
                'attributes' => [
                    'attr1' => 'val1',
                    'attr2' => 'val2'
                ],
                'classes' => [],
                'headerComponent' => null,
                'dataComponent' => null,
                'sortable' => false,
                'sortableKey' => 'id',
                'show' => true,
                'type' => 'content',
            ], $array);

            $staticPageData = fn () => [
                'table' => [
                    'columns' => [
                        $genColumn(),
                        $genColumn([
                            'key' => 'name',
                            'label' => 'Name',
                        ]),
                    ],
                ],
                'records' => User::limit(3)->get(),
            ];

            $table = new Table();
            // rowClasses
            $table->columns([
                TableColumn::make('id', 'ID', translateLabel: false),
                TableColumn::make('uuid'),
                TableColumn::make('email'),
                TableColumn::make('name'),
                TableColumn::make('fake_date')->dynamicProps([
                    'label' => [
                        "callable" => "evalThis",
                        "params" => [
                            "(new Date('2024-01-28 12:00')).toLocaleString()"
                        ],
                    ],
                ]),
                // TableColumn::make('name', translateLabel: true),
                TableColumn::make('verified_email', __('Verified e-mail?'))->prepareContentUsing(function (Fluent $args) {
                    $record = $args->record;

                    return $record?->email_verified_at ? __('Yes') : __('No');
                })->attributes([]),
                // TableColumn::make('created_at'),
                // TableColumn::make('updated_at'),
                // TableColumn::make('deleted_at'),
                // TableColumn::make('created_at', 'Data formatada')->prepareContentUsing(function (Fluent $args) {
                //     $record = $args->record;
                //     return $record?->created_at?->diffForHumans();
                // }),
            ]);
            $table->queryBuilder(
                User::query()->when(
                    $request->string('search'),
                    fn ($query, $search) => $query->where('name', 'ilike', "%{$search}%")
                )
            );
            $table->setRequest($request->merge([
                //
            ]));

            // dd($staticPageData(), $table->getPreparedContent()?->toArray());

            return Inertia::render(
                'CRUD/Pages/List',
                [
                    'tenant' => tenant(),
                    'pageTitle' => 'DEV Index',
                    // 'pageData' => $staticPageData(),
                    // 'pageData' => $staticPageData(),
                    'pageData' => $table->getPreparedContent(),
                    'pageData_' => json_decode(
                        <<<'JSON'
                        {
                            "table": {
                                "columns": [
                                    {
                                        "key": "id",
                                        "label": "ID",
                                        "content": null,
                                        "attributes": {
                                            "attr1": "val1",
                                            "attr2": "val2"
                                        },
                                        "classes": [],
                                        "headerComponent": null,
                                        "dataComponent": null,
                                        "sortable": false,
                                        "sortableKey": "id",
                                        "show": true,
                                        "type": "content"
                                    },
                                    {
                                        "key": "name",
                                        "label": "Package",
                                        "content": null,
                                        "attributes": {
                                            "attr1": "val1",
                                            "attr2": "val2"
                                        },
                                        "classes": [],
                                        "headerComponent": null,
                                        "dataComponent": null,
                                        "sortable": false,
                                        "sortableKey": "id",
                                        "show": true,
                                        "type": "content"
                                    },
                                    {
                                        "key": "price",
                                        "label": "Price",
                                        "content": null,
                                        "attributes": {
                                            "attr1": "val1",
                                            "attr2": "val2"
                                        },
                                        "classes": [],
                                        "headerComponent": null,
                                        "dataComponent": "CrudTBodyTD2Lines",
                                        "sortable": false,
                                        "sortableKey": "id",
                                        "show": true,
                                        "type": "content",
                                        "props": {
                                            "staticProps": {
                                                "abc": 123,
                                                "xyz": 465
                                            },
                                            "dynamicProps": {
                                                "userId": {
                                                    "callable": "recordAttribute",
                                                    "params": [
                                                        "id"
                                                    ]
                                                },
                                                "date": {
                                                    "callable": "evalThis",
                                                    "params": [
                                                        "(new Date('2024-01-28')).toLocaleString()"
                                                    ]
                                                },
                                                "now": {
                                                    "callable": "evalThis",
                                                    "params": [
                                                        "(new Date()).toLocaleString()"
                                                    ]
                                                },
                                                "lineOne": {
                                                    "callable": "recordAttribute",
                                                    "params": [
                                                        "name"
                                                    ]
                                                },
                                                "lineTwo": {
                                                    "callable": "recordAttribute",
                                                    "params": [
                                                        "price"
                                                    ]
                                                }
                                            }
                                        }
                                    },
                                    {
                                        "key": "invoiceDate",
                                        "label": "Invoice date",
                                        "content": null,
                                        "attributes": {
                                            "attr1": "val1",
                                            "attr2": "val2"
                                        },
                                        "classes": [],
                                        "headerComponent": null,
                                        "dataComponent": null,
                                        "sortable": false,
                                        "sortableKey": "id",
                                        "show": true,
                                        "type": "content"
                                    },
                                    {
                                        "key": "status",
                                        "label": "Status",
                                        "content": null,
                                        "attributes": {
                                            "attr1": "val1",
                                            "attr2": "val2"
                                        },
                                        "classes": [],
                                        "headerComponent": null,
                                        "dataComponent": null,
                                        "sortable": false,
                                        "sortableKey": "id",
                                        "show": true,
                                        "type": "content"
                                    },
                                    {
                                        "key": "actions",
                                        "label": "Actions",
                                        "content": null,
                                        "attributes": {
                                            "attr1": "val1",
                                            "attr2": "val2"
                                        },
                                        "classes": [],
                                        "headerComponent": null,
                                        "dataComponent": null,
                                        "sortable": false,
                                        "sortableKey": "id",
                                        "show": true,
                                        "type": "actionGroup"
                                    }
                                ]
                            },
                            "records": [
                                {
                                    "id": 15,
                                    "name": "Free Package",
                                    "price": "$0.00",
                                    "invoiceDate": "Jan 13, 2025",
                                    "status": "Paid"
                                },
                                {
                                    "id": 16,
                                    "name": "Standard Package",
                                    "price": "$79.00",
                                    "invoiceDate": "Jan 13, 2025",
                                    "status": "Paid"
                                },
                                {
                                    "id": 17,
                                    "name": "Business Package",
                                    "price": "$99.00",
                                    "invoiceDate": "Jan 13, 2025",
                                    "status": "Unpaid"
                                },
                                {
                                    "id": 18,
                                    "name": "Standard Package",
                                    "price": "$59.00",
                                    "invoiceDate": "Jan 13, 2025",
                                    "status": "Pending"
                                }
                            ]
                        }
                        JSON,
                        true
                    )
                ]
            );
        }
    )->name('index.v2');
    // resources/js/Components/CRUD/Pages/Index.vue

    Route::get('/tables', fn () => Inertia::render('tailadmin/TablesView', [
        //
    ]))?->name('tables');
});
