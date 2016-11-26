# PDOConnection

Useful library for connect of easy way apps
with any DB supported by PDO 

## What can you do with this library?

You can connect to any DB supported by PDO(Mysql and Postgresql for the moment)
and make CRUD or call to functions and stored procedures

## DBMS supported?

This library was tested with:

-   Mysql
--   result: all operations were successful.
-   Postgresql
--   result: all operations were successful.
-   Microsoft sql:
--   result: it is waiting.

look at the following tests to learn to use the library 

-   [Mysql tests](https://github.com/carlosprogrammer/PDOConnection/tree/master/test/MySqlTest)
-   [Postgresql test](https://github.com/carlosprogrammer/PDOConnection/tree/master/test/PgSqlTest)

### About other DBMS supported by PDO

It is possible that in the moment of connect your app
with some DBMS that was not tested, the connection can
fail.

you can solve that problem changing the following code line to
the dbms dns

```PHP
//Example with firebird

//Change this line
$uriConnection = "".$this->dbms.":host=".$this->host.";dbname=".$this->database."";//Old line
//To this line -Here the dns of dbms-
$uriConnection = "firebird:dbname=hostname/port:/path/to/DATABASE.FDB";//New line
```

### Connection parameters

You must indicate where is the file `connectionparameters.json`
and the file must be configured, on the contrary, the connection will not run.

File setup:
```json
{
    "dbms": "your_dbms",
    "host": "your_dbms_host",
    "database": "your_database",
    "username": "your_username",
    "password": "your_username_password"
}
```

--------------

Developed by: [Carlos Mario](https://twitter.com/carlos_mario__)

--------------
