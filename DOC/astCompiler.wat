[
    "type" => "SelectStatement",

    "with" => null,

    "select" => [
        "type" => "SelectClause",

        "columns" => [
            [
                "type" => "ColumnExpression",

                "column" => [
                    "type" => "ColumnIdentifier",
                    "name" => "name",
                    "table" => null
                ]
            ],

            [
                "type" => "ColumnExpression",

                "column" => [
                    "type" => "ColumnIdentifier",
                    "name" => "age",
                    "table" => null
                ]
            ]
        ]
    ],


    "from" => [
        "type" => "FromClause",

        "table" => [
            "type" => "NamedTableReference",

            "table" => [
                "type" => "TableIdentifier",
                "name" => "users"
            ]
        ]
    ],


    "where" => [
        "type" => "WhereClause",

        "condition" => [
            "type" => "BinaryExpression",

            "left" => [
                "type" => "ColumnExpression",
                "column" => [
                    "name" => "age"
                ]
            ],

            "operator" => ">",

            "right" => [
                "type" => "LiteralExpression",
                "value" => 18,
                "literalType" => "INTEGER"
            ]
        ]
    ]
]