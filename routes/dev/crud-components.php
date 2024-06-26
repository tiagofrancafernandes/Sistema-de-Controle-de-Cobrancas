<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

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
    // resources/js/Components/CRUD/Pages/Index.vue

    Route::get('/tables', fn () => Inertia::render('tailadmin/TablesView', [
        //
    ]))?->name('tables');
});
