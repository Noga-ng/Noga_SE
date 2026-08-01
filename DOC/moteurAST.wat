
CONCEPT
---------------

QueryBuilder
      │
      ▼
     AST
      │
      ▼
 Compiler
      │
      ▼
 SQL

;; L'AST est simplement une représentation de la requête. Il ne génère pas de SQL.

Le nœud AST
-----------

      AST 
        A
      / | \
     B  C  D
       / \
      E   F
Chaque cercle est un nœud (Node).

ETAPE 
---------

| Étape | Objectif                                | Résultat                               |
| ----- | --------------------------------------- | -------------------------------------- |
| 1     | Définir les types de nœuds AST          | Un format unique pour tous les drivers |
| 2     | Construire l'AST depuis le QueryBuilder | Builder → AST                          |
| 3     | Valider l'AST                           | Vérification des erreurs               |
| 4     | Optimiser l'AST                         | Simplification automatique             |
| 5     | Compiler l'AST                          | AST → SQL PostgreSQL/MySQL/SQLite      |
| 6     | Visitors                                | Analyse, Debug, Explain...             |
| 7     | Cache                                   | AST sérialisable                       |



Familly off Node
----------------------

AST
│
├── Statement
│
├── Clause
│
├── Expression
│
├── Literal
│
├── Operator
│
├── Function
│
├── Join
│
├── Order
│
├── Group
│
└── Common


STATEMENT
----------------

SelectStatement

InsertStatement

UpdateStatement

DeleteStatement

UnionStatement

WithStatement


structure
-------------
Statement
    │
    ├── Clause
    │      │
    │      └── Expression
    │               │
    │               ├── Column
    │               ├── Literal
    │               └── Function


CLAUSE
-----------
SelectClause

FromClause

WhereClause

JoinClause

GroupClause

HavingClause

OrderClause

LimitClause

OffsetClause


EXPRESSION
-----------

ColumnExpression

ValueExpression

BinaryExpression

UnaryExpression

BetweenExpression

InExpression

ExistsExpression

CaseExpression

FunctionExpression

SubqueryExpression



Arbre des Expression
---------------------------

Expression
│
├── LiteralExpression
├── ColumnExpression
├── BinaryExpression
├── UnaryExpression
├── FunctionExpression
├── CaseExpression
├── BetweenExpression
├── InExpression
├── ExistsExpression
├── SubqueryExpression
└── ParameterExpression


LITERAL
--------------

StringLiteral

NumberLiteral

BooleanLiteral

NullLiteral


OPERATOR SQL 
--------------------

=

!=

>

>=

<

<=

AND

OR

LIKE

ILIKE

NOT

IN

IS

BETWEEN


Example Query 
----------------------

SELECT id,name
FROM users
WHERE age > 18

to 

result schematic d'AST
---------------------------

SelectStatement
│
├── SelectClause
│      ├── Column(id)
│      └── Column(name)
│
├── FromClause
│      └── Table(users)
│
└── WhereClause
       └── BinaryExpression
              left  -> Column(age)
              op    -> >
              right -> Number(18)


BinaryExpression
├── left
│     FunctionExpression
│        │
│        ├── name : UPPER
│        └── args
│             └── ColumnExpression(name)
|             └── ColumnExpression(name)
|             └── ColumnExpression(name)

│
├── operator
│      =
│
└── right
       LiteralExpression("NOGA")



         AND
        /   \
     (>)     (=)
    /  \    /   \
 age  18 active TRUE


WhereClause
    │
    ▼
BinaryExpression (AND)
│
├── left
│      BinaryExpression (>)
│      │
│      ├── left
│      │      ColumnExpression(age)
│      │
│      ├── operator
│      │      >
│      │
│      └── right
│             LiteralExpression(18)
│
└── right
       BinaryExpression (=)
       │
       ├── left
       │      ColumnExpression(active)
       │
       ├── operator
       │      =
       │
       └── right
              LiteralExpression(TRUE)


La règle que tu viens de découvrir

C'est une des règles les plus importantes de tout l'AST :

Les opérateurs logiques (AND, OR) sont eux-mêmes des BinaryExpression.

Ils ne sont pas des conteneurs spéciaux.

Ils relient deux autres expressions.

C'est ce qui permet de représenter des conditions extrêmement complexes sans inventer de nouveaux types de nœuds.

WHERE (age > 18 AND active = TRUE)
   OR admin = TRUE

        OR
      /    \
    AND     (=)
   /   \
 (>)   (=)



 Moteur SQL
-----------------
 SQL
 │
 ▼
Lexer (Tokenizer)
 │
 ▼
Tokens
 │
 ▼
Parser
 │
 ▼
AST
 │
 ▼
Validator
 │
 ▼
Optimizer
 │
 ▼
Compiler
 │
 ▼
SQL final


Étape 1 : Définir les couches du moteur

                Noga_SE
                   │
    ┌──────────────┼──────────────┐
    │              │              │
 Builder        Parser        Compiler
    │              │              │
    └──────────────┼──────────────┘
                   │
                  AST
                   │
         Validator / Optimizer

         Rytheme

Builder ----> AST

Parser  ----> AST

Compiler <---- AST

Validator <--- AST

Optimizer <--- AST


STRUCTURE DE FICHIERS

AstNode
│
├── Statement
│   ├── SelectStatement
│   ├── InsertStatement
│   ├── UpdateStatement
│   ├── DeleteStatement
│   ├── UnionStatement
│   └── WithStatement
│
├── Clause
│   ├── SelectClause
│   ├── FromClause
│   ├── JoinClause
│   ├── WhereClause
│   ├── GroupByClause
│   ├── HavingClause
│   ├── OrderByClause
│   ├── LimitClause
│   └── OffsetClause
│
├── Expression
│   ├── BinaryExpression
│   ├── UnaryExpression
│   ├── FunctionExpression
│   ├── CaseExpression
│   ├── BetweenExpression
│   ├── InExpression
│   ├── ExistsExpression
│   ├── SubqueryExpression
│   ├── ColumnExpression
│   ├── ParameterExpression
│   └── LiteralExpression
│
├── Literal
│   ├── StringLiteral
│   ├── NumberLiteral
│   ├── BooleanLiteral
│   └── NullLiteral
│
└── Identifier
    ├── TableIdentifier
    ├── ColumnIdentifier
    ├── AliasIdentifier
    └── SchemaIdentifier


la hiérarchie réelle de Noga_SE.

1. AstNode (la racine de tout)

↓

2. Statement

↓

3. Clause

↓

4. Expression

↓

5. Identifier

↓

6. Literal

↓

7. Operator

↓

8. Visitor

↓

9. Traverser

↓

10. Compiler


AstNode

                 AstNode
                    │
     ┌──────────────┼──────────────┐
     │              │              │
 Statement      Expression      Clause
     │              │              │
     │              │              │
Select...      Binary...     Where...
Insert...      Literal...    Join...
Update...      Column...     Order...


Identifier
----------------

ColumnIdentifier
│
├── table
│     │
│     └── TableIdentifier
│           │
│           ├── schema
│           │      │
│           │      └── SchemaIdentifier
│           │
│           └── name
│                  users
│
└── name
       id


SELECT id FROM users;

SelectClause
    |
    └── ColumnExpression
             |
             └── ColumnIdentifier
                    |
                    └── id

AstNode
│
├── Identifier
│      ├── SchemaIdentifier
│      ├── TableIdentifier
│      ├── ColumnIdentifier
│      └── AliasIdentifier
│
└── Expression
       └── ColumnExpression
              |
              └── ColumnIdentifier


AstNode
│
├── Expression
│   │
│   ├── ColumnExpression
│   │
│   ├── BinaryExpression
│   │
│   ├── FunctionExpression
│   │
│   └── AliasedExpression
│          │
│          ├── expression
│          └── alias
│
└── Identifier
    │
    ├── ColumnIdentifier
    ├── TableIdentifier
    └── AliasIdentifier


SelectClause
│
└── AliasedExpression
        │
        ├── BinaryExpression
        │      │
        │      ├── ColumnExpression(age)
        │      ├── Operator(+)
        │      └── LiteralExpression(10)
        │
        └── AliasIdentifier(future_age)



SELECT age + 10 AS future_age

SelectStatement
│
├── SelectClause
│      │
│      └── AliasedExpression
│             │
│             ├── BinaryExpression(+)
│             │      │
│             │      ├── ColumnExpression
│             │      │       │
│             │      │       └── ColumnIdentifier(age)
│             │      │
│             │      └── LiteralExpression(10)
│             │
│             └── AliasIdentifier(future_age)
│
└── FromClause
       │
       └── TableExpression
              │
              └── TableIdentifier(users)


SelectStatement
{
    SelectClause $select;

    FromClause $from;

    ?WhereClause $where;

    ?GroupByClause $group;

    ?HavingClause $having;

    ?OrderByClause $order;

    ?LimitClause $limit;
}


SelectStatement
│
├── select
│
├── from
│
├── where
│
├── groupBy
│
├── having
│
├── orderBy
│
├── limit
│
└── offset


AstNode
│
├── Statement
│     └── SelectStatement
│
├── Clause
│     ├── SelectClause
│     └── FromClause
│
├── Expression
│     ├── ColumnExpression
│     ├── WildcardExpression
│     ├── BinaryExpression
│     ├── FunctionExpression
│     ├── LiteralExpression
│     └── AliasedExpression
│
└── Identifier
      ├── TableIdentifier
      ├── ColumnIdentifier
      └── AliasIdentifier


FromClause
│
└── JoinExpression
       │
       ├── left
       │      TableExpression(users)
       │
       ├── type
       │      INNER
       │
       ├── right
       │      TableExpression(posts)
       │
       └── condition
              BinaryExpression(=)


FromSource
│
├── TableExpression
│
├── JoinExpression
│
└── SubqueryTableExpression

FromClause
│
└── JoinExpression
       │
       ├── left
       │      TableExpression(users)
       │
       ├── type
       │      INNER
       │
       ├── right
       │      TableExpression(posts)
       │
       └── condition
              BinaryExpression(=)


SubqueryTableExpression
│
├── query
│      SelectStatement
│
└── alias
       AliasIdentifier(u)



SELECT *
FROM users
JOIN posts
ON users.id = posts.user_id;



SelectStatement
│
├── SelectClause
│      └── WildcardExpression
│
└── FromClause
       │
       └── JoinExpression
              │
              ├── left
              │     TableExpression(users)
              │
              ├── type
              │     INNER
              │
              ├── right
              │     TableExpression(posts)
              │
              └── condition
                    BinaryExpression(=)




TableReference
│
├── NamedTableReference
│
├── JoinReference
│
├── SubqueryReference
│
└── FunctionTableReference



FromClause
│
└── TableReference
       │
       ├── NamedTableReference
       │       │
       │       ├── TableIdentifier
       │       └── AliasIdentifier?
       │
       ├── JoinReference
       │       │
       │       ├── left
       │       ├── joinType
       │       ├── right
       │       └── condition
       │
       └── SubqueryReference
               │
               ├── SelectStatement
               └── AliasIdentifier



WhereClause
│
└── BinaryExpression(AND)
       │
       ├── BinaryExpression(>)
       │      │
       │      ├── ColumnExpression(age)
       │      └── LiteralExpression(18)
       │
       └── BinaryExpression(=)
              │
              ├── ColumnExpression(active)
              └── LiteralExpression(TRUE)


WHERE (age > 18 OR active = TRUE)
AND deleted = FALSE;

BinaryExpression(AND)
│
├── BinaryExpression(OR)
│      │
│      ├── BinaryExpression(>)
│      │
│      └── BinaryExpression(=)
│
└── BinaryExpression(=)


WHERE id IN (1,2,3)

InExpression
│
├── expression
│      ColumnExpression(id)
│
└── values[]
       │
       ├── LiteralExpression(1)
       ├── LiteralExpression(2)
       └── LiteralExpression(3)


WHERE age BETWEEN 18 AND 30

BetweenExpression
│
├── expression
│      ColumnExpression(age)
│
├── min
│      LiteralExpression(18)
│
└── max
       LiteralExpression(30)


WHERE EXISTS(
    SELECT id FROM users
)

ExistsExpression
│
└── SelectStatement


Expression
│
├── BinaryExpression
│
├── InExpression
│
├── BetweenExpression
│
├── ExistsExpression
│
├── FunctionExpression
│
├── ColumnExpression
│
└── LiteralExpression


Famille 1 : BinaryExpression
--------------------------------
=
<>
<
<=
>
>=
+
-
*
/
AND
OR
LIKE
ILIKE
REGEXP

toujours
-------
left
operator
right


Famille 2 : UnaryExpression
------------------------------

NOT
-
+
IS NULL
IS TRUE

toujours
-------------
UnaryExpression
├── operator
└── operand

Famille 3 : InExpression
---------------------------

InExpression
├── expression
└── values[]


Famille 4 : BetweenExpression
---------------------------------
BetweenExpression
├── expression
├── lower
└── upper

Famille 5 : ExistsExpression
------------------------------
ExistsExpression
└── query

Famille 6 : FunctionExpression
-------------------------------------
FunctionExpression
│        │
│        ├── name : UPPER
│        └── args
│             └── ColumnExpression(name)



CASEEXPRESSION 
--------------------

SELECT
    CASE
        WHEN age < 18 THEN 'Minor'
        WHEN age < 60 THEN 'Adult'
        ELSE 'Senior'
    END AS category
FROM users;


CaseExpression
│
├── branches[]
│      │
│      ├── WhenBranch
│      │      │
│      │      ├── condition
│      │      │      BinaryExpression(<)
│      │      │
│      │      └── result
│      │             LiteralExpression("Minor")
│      │
│      └── WhenBranch
│             │
│             ├── condition
│             └── result
│
└── else
       LiteralExpression("Senior")


WhenBranch
│
├── condition : Expression
└── result : Expression


CaseExpression
│
├── branches : WhenBranch[]
└── else : Expression?


CASE
    WHEN age > 18 THEN UPPER(name)
    ELSE CONCAT(first_name,' ',last_name)
END


CaseExpression
│
├── WhenBranch
│      │
│      ├── condition
│      │      BinaryExpression
│      │
│      └── result
│             FunctionExpression(UPPER)
│
└── else
       FunctionExpression(CONCAT)


Other format
-------------

CASE status
    WHEN 1 THEN 'Pending'
    WHEN 2 THEN 'Paid'
    ELSE 'Unknown'
END

CaseExpression
│
├── operand
│      ColumnExpression(status)
│
├── branches[]
│      │
│      ├── WhenBranch
│      │      │
│      │      ├── match
│      │      │      LiteralExpression(1)
│      │      │
│      │      └── result
│      │             LiteralExpression("Pending")
│      │
│      └── ...
│
└── else


CaseExpression
│
├── operand : Expression?
├── branches : CaseBranch[]
└── else : Expression?


SubqueryExpression
-------------------------

SubqueryTableReference
│
├── query
│      SelectStatement
│
└── alias

AstNode
│
├── Statement
│
├── Clause
│
├── Expression
│     │
│     ├── BinaryExpression
│     ├── FunctionExpression
│     ├── CaseExpression
│     ├── SubqueryExpression
│     └── ...
│
└── TableReference
      │
      ├── NamedTableReference
      ├── JoinExpression
      └── SubqueryTableReference


AstNode
│
├── Statement
│     ├── SelectStatement
│     ├── InsertStatement
│     ├── UpdateStatement
│     └── DeleteStatement
│
├── Clause
│     ├── SelectClause
│     ├── FromClause
│     ├── WhereClause
│     ├── GroupByClause
│     └── ...
│
├── Expression
│     ├── BinaryExpression
│     ├── FunctionExpression
│     ├── LiteralExpression
│     ├── ColumnExpression
│     ├── CaseExpression
│     ├── InExpression
│     └── ...
│
├── Identifier
│     ├── TableIdentifier
│     ├── ColumnIdentifier
│     ├── AliasIdentifier
│     └── SchemaIdentifier
│
└── TableReference
      ├── NamedTableReference
      ├── JoinExpression
      └── SubqueryTableReference


structure folder
----------------------
AST/
│
├── Statement/
│
├── Clause/
│
├── Expression/
│
├── Identifier/
│
├── TableReference/
│
├── Operator/
│
├── Visitor/
│
└── Compiler/




✓ SelectClause
✓ FromClause
✓ WhereClause

➡ GroupByClause
➡ HavingClause
➡ OrderByClause
➡ LimitClause
➡ OffsetClause

Puis :

➡ InsertStatement
➡ UpdateStatement
➡ DeleteStatement

Ensuite :

➡ CTE
➡ UNION
➡ Window
➡ ...

GroupByClause
--------------

GroupByClause
│
└── expressions
      │
      └── FunctionExpression
             │
             ├── name
             └── args


HavingClause
---------------------
HavingClause
│
└── condition


HavingClause
│
└── BinaryExpression(>)
       │
       ├── FunctionExpression(COUNT)
       └── LiteralExpression(10)


OrderByClause
------------------

OrderByClause
│
└── items[]


OrderItem
│
├── expression
└── direction

ORDER BY UPPER(name) DESC

OrderItem
│
├── FunctionExpression(UPPER)
│
└── DESC

OrderItem
├── expression : ColumnExpression(age)
├── direction : ASC
└── nullOrder : DEFAULT


LimitClause
---------------

LimitClause
│
└── value
      LiteralExpression(20)

LimitClause
│
└── Expression

OffsetClause
-------------

OffsetClause
│
└── Expression



SELECT FORM

SelectStatement
│
├── SelectClause
│     └── Expression[]
│
├── FromClause
│     └── TableReference
│
├── WhereClause
│     └── Expression
│
├── GroupByClause
│     └── Expression[]
│
├── HavingClause
│     └── Expression
│
├── OrderByClause
│     └── OrderItem[]
│
├── LimitClause
│     └── Expression
│
└── OffsetClause
      └── Expression



INSERT STATEMENT
-------------------

Statement
│
├── SelectStatement
│
├── InsertStatement
│      │
│      ├── table
│      ├── columns[]
│      └── source
│
└── ...

InsertValuesSource
│
├── mode : InsertValuesMode
└── rows[]


InsertSource
│
├── ValuesSource
│      └── ValuesRow[]
│
└── SelectSource
       └── SelectStatement

InsertStatement
│
├── InsertClause
├── IntoClause
├── ColumnsClause
├── ValuesClause
└── ReturningClause


UPDATE STATEMENT
------------------------

UPDATE users
SET
    name = 'Noga',
    age = age + 1
WHERE id = 10;


UpdateStatement
│
├── table[]
├── assignments[]
└── where

Assignment
│
├── target
│      ColumnIdentifier(name)
│
└── value
       LiteralExpression("Noga")


Assignment
│
├── target
│      ColumnIdentifier(age)
│
└── value
       BinaryExpression(+)


UPDATE users
SET
    age = (
        SELECT MAX(age)
        FROM users
    )

Assignment
│
├── target
│
└── value
       SubqueryExpression


UpdateStatement
│
├── UpdateClause      (ou TargetClause)
│
├── SetClause
│      └── Assignment[]
│
└── WhereClause


UpdateStatement
│
├── UpdateClause
├── SetClause
├── FromClause?
├── WhereClause
└── ReturningClause


DELETE STATEMENT
-------------------------

DELETE FROM users
WHERE id = 10;

DeleteStatement
│
├── DeleteClause
├── FromClause
└── WhereClause

DELETE FROM users
USING posts
WHERE users.id = posts.user_id;

DELETE
FROM
USING
WHERE

DeleteStatement
│
├── DeleteClause
├── FromClause
├── UsingClause?
└── WhereClause?


DELETE FROM users
WHERE id = 10
RETURNING *;



DeleteStatement
│
├── DeleteClause
│
├── FromClause
│      └── TableReference
│
├── UsingClause?
│      └── TableReference[]
│
├── WhereClause?
│      └── Expression
│
└── ReturningClause?
       └── Expression[]


"Chaque clause est indépendante et peut être réutilisée 
par plusieurs Statements, tant que la grammaire SQL l'autorise."


WITH CTE 
--------------

WITH adults AS (
    SELECT *
    FROM users
    WHERE age >= 18
)
SELECT *
FROM adults;

WithStatement
│
├── WithClause
└── Statement


WithClause
│
└── items[]

CommonTableExpression
│
├── name
├── columns?
└── query

WITH adults(id,name) AS (...)

CommonTableExpression
│
├── name
│      Identifier(adults)
│
├── columns
│      ├── id
│      └── name
│
└── query
       SelectStatement


WITH
a AS (...),
b AS (...),
c AS (...)
SELECT ...

WithClause
│
├── CTE(a)
├── CTE(b)
└── CTE(c)

WITH RECURSIVE tree AS (...)

WithMode
│
├── NORMAL
└── RECURSIVE

WithClause
│
├── mode
└── items[]


Statement
│
├── SelectStatement
├── InsertStatement
├── UpdateStatement
├── DeleteStatement
└── WithStatement
       │
       ├── WithClause
       └── Statement

WithStatement
│
├── WithClause
└── Statement

UNION STATEMENT

SELECT ...

UNION

SELECT ...

(
    SELECT ...
    UNION
    SELECT ...
)
UNION
SELECT ...

QueryStatement
│
├── SelectStatement
└── UnionStatement

UnionStatement
│
├── left  : QueryStatement
├── operator : UnionOperator
└── right : QueryStatement

UnionOperator
│
├── UNION
├── UNION_ALL
├── INTERSECT
├── INTERSECT_ALL
├── EXCEPT
└── EXCEPT_ALL

SELECT A

UNION

SELECT B

UNION

SELECT C

UnionStatement
│
├── left
│      UnionStatement
│      │
│      ├── left
│      │      Select(A)
│      │
│      └── right
│             Select(B)
│
└── right
       Select(C)


WITH cte AS (...)
SELECT ...

UNION

SELECT ...


WithStatement
│
├── WithClause
│
└── UnionStatement
       │
       ├── SelectStatement
       └── SelectStatement


Statement
│
├── QueryStatement
│      │
│      ├── SelectStatement
│      └── UnionStatement
│
├── InsertStatement
├── UpdateStatement
└── DeleteStatement


FONCTION AVANCE 
-------------------

CAST EXPRESSION
---------------------

CAST(age, TEXT)

CastExpression
│
├── expression
└── targetType

COALESCE 
----------------
COALESCE(name, username, 'Unknown')

FunctionExpression
│
├── name = COALESCE
└── arguments[]

NULLIF
------------
NULLIF(a,b)

FunctionExpression
│
├── name = NULLIF
└── arguments[]


ROW EXPRESSION
-----------
ROW(id,name,age)

RowExpression
│
└── expressions[]

ARRAY EXPRESSION
---------------

ARRAY[
1,
2,
3
]

ArrayExpression
│
└── expressions[]

ANY EXPRESSION
------------

AnyExpression
│
└── expression

ALL EXPRESSION
---------------
AllExpression
│
└── expressions[]


Window FUNCTION EXPRESSION
----------------------------
WindowFunctionExpression
│
├── function
└── window

WindowDefinition
│
├── partitionBy[]
├── orderBy[]
└── frame


OVER EXPRESSION
---------------------

SUM(price)
OVER(
PARTITION BY country
ORDER BY created_at
)



FILTER EXPRESSION
-----------------------

COUNT(*)
FILTER(
WHERE age>18
)


FilteredExpression
│
├── expression
└── where


Famille 1 EXPRESSION NATIVE

BinaryExpression

FunctionExpression

LiteralExpression

ColumnExpression

CaseExpression


Famille 2

AliasedExpression

FilteredExpression

WindowFunctionExpression


PARAMS EXPRESSION
-----------------------

ParameterExpression
│
├── name
├── type
└── value?


AUDIT 
------------------

✅ Statements
--------------------------
✓ SelectStatement
✓ InsertStatement
✓ UpdateStatement
✓ DeleteStatement
✓ WithStatement
✓ UnionStatement


✅ Clauses
----------------------

✓ SelectClause
✓ FromClause
✓ WhereClause
✓ GroupByClause
✓ HavingClause
✓ OrderByClause
✓ LimitClause
✓ OffsetClause

✓ SetClause
✓ UsingClause
✓ ReturningClause
✓ WithClause


✅ TableReference
--------------------------------

✓ NamedTableReference

✓ JoinExpression

✓ SubqueryTableReference


✅ Expressions
-------------------------------

✓ LiteralExpression

✓ ColumnExpression

✓ BinaryExpression

✓ UnaryExpression

✓ FunctionExpression

✓ AliasedExpression

✓ CastExpression

✓ CaseExpression

✓ InExpression

✓ BetweenExpression

✓ ExistsExpression

✓ SubqueryExpression

✓ ParameterExpression

✓ ArrayExpression

✓ RowExpression

✓ AnyExpression

✓ AllExpression

✓ WindowFunctionExpression

✓ FilteredExpression


✅ Identifiers
---------------------------------------

✓ TableIdentifier

✓ ColumnIdentifier

✓ AliasIdentifier

✓ SchemaIdentifier


✅ Objets auxiliaires
-------------------------------------------

✓ Assignment

✓ ValuesRow

✓ OrderItem

✓ CommonTableExpression


✅ Enums
----------------------------------------------

✓ BinaryOperator

✓ UnaryOperator

✓ JoinType

✓ OrderDirection

✓ NullOrder

✓ UnionOperator

✓ InsertValuesMode

✓ WithMode


1. ON CONFLICT / UPSERT
------------------------------

INSERT ...
ON CONFLICT(id)
DO UPDATE
SET ...

ConflictClause
│
├── target
├── action
└── where?


STRUCTURE GENERAL

AST/
│
├── AstNode.php
│
├── Statement/
│
├── Clause/
│
├── Expression/
│
├── Identifier/
│
├── TableReference/
│
├── Type/
│
├── Enum/
│
├── Visitor/
│
├── Compiler/
│
├── Parser/
│
├── Exception/
│
└── Utils/

STATEMENT
--------------------

Statement/
│
├── Statement.php
│
├── QueryStatement.php
│
│
├── SelectStatement.php
├── InsertStatement.php
├── UpdateStatement.php
├── DeleteStatement.php
│
├── UnionStatement.php
└── WithStatement.php

Clause
------------

Clause/
│
├── Clause.php
│
├── SelectClause.php
├── FromClause.php
├── WhereClause.php
├── GroupByClause.php
├── HavingClause.php
├── OrderByClause.php
├── LimitClause.php
├── OffsetClause.php
│
├── SetClause.php
├── UsingClause.php
├── ReturningClause.php
│
├── WithClause.php
└── ConflictClause.php


Expression
---------------------

Expression/
│
├── Expression.php
│
├── LiteralExpression.php
├── ColumnExpression.php
├── ParameterExpression.php
│
├── BinaryExpression.php
├── UnaryExpression.php
│
├── FunctionExpression.php
├── CastExpression.php
├── CaseExpression.php
│
├── ExistsExpression.php
├── InExpression.php
├── BetweenExpression.php
├── SubqueryExpression.php
│
├── RowExpression.php
├── ArrayExpression.php
│
├── AnyExpression.php
├── AllExpression.php
│
├── WindowFunctionExpression.php
├── FilteredExpression.php
│
└── AliasedExpression.php


Identifier
---------------------

Identifier/
│
├── Identifier.php
│
├── TableIdentifier.php
├── ColumnIdentifier.php
├── AliasIdentifier.php
├── SchemaIdentifier.php
│
└── QualifiedIdentifier.php

TableReference
-------------------

TableReference/
│
├── TableReference.php
│
├── NamedTableReference.php
├── SubqueryTableReference.php
└── JoinExpression.php

Type
--------------

Type/
│
├── SqlType.php
│
├── BuiltinType.php
│
├── NumericType.php
├── CharacterType.php
├── DateTimeType.php
├── JsonType.php
└── ArrayType.php

Enum
-----------

Enum/
│
├── BinaryOperator.php
├── UnaryOperator.php
├── JoinType.php
├── UnionOperator.php
├── OrderDirection.php
├── NullOrder.php
├── WithMode.php
├── InsertValuesMode.php
└── ...

Value Objects
-----------------

Node/
│
├── Assignment.php
├── OrderItem.php
├── ValuesRow.php
├── CommonTableExpression.php
├── WindowDefinition.php
├── FrameDefinition.php

Compiler
--------------

Compiler/
│
├── Compiler.php
│
├── PostgreSQLCompiler.php
├── MySQLCompiler.php
├── SQLiteCompiler.php
└── SqlServerCompiler.php

Visitor
--------------------------

Visitor/
│
├── AstVisitor.php
├── WalkingVisitor.php
├── PrettyPrintVisitor.php
└── ValidationVisitor.php

Parser
--------------------------

Parser/
│
├── Lexer.php
├── Token.php
├── Parser.php
└── ...


Noga_SE/
│
├── src/
│   │
│   └── Noga/
│       │
│       └── SE/
│           │
│           ├── SqlEngine/
│           │   │
│           │   ├── Ast/
│           │   │   │
│           │   │   ├── Node/
│           │   │   ├── Statement/
│           │   │   ├── Expression/
│           │   │   ├── Clause/
│           │   │   ├── Identifier/
│           │   │   ├── TableReference/
│           │   │   └── Type/
│           │   │
│           │   ├── Compiler/
│           │   │
│           │   ├── Parser/
│           │   │
│           │   ├── Visitor/
│           │   │
│           │   └── Exception/
│           │
│           ├── Builder/
│           │
│           ├── Connection/
│           │
│           └── Driver/
│
├── tests/
│
├── composer.json
│
└── README.md

Noga_SE/
│
├── composer.json
├── phpunit.xml
├── phpstan.neon
├── README.md
│
├── src/
│   └── Noga/
│       └── SE/
│           └── SqlEngine/
│
├── tests/
│   └── Units/
│
├── vendor/
│
└── .gitignore



Builder
   |
   | construit
   ↓
AST
   |
   | visite / transforme
   ↓
Compiler
   |
   | génère
   ↓
SQL
   |
   | exécute
   ↓
Driver / Connection