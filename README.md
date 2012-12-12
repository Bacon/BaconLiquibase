Liquibase aggregator module for ZF2
===================================

Introduction
------------
BaconLiquibase is an aggregator for Liquibase change sets. It will collect
change sets from all your modules which supply them and create a master XML
file, which you can then run through Liquibase as usual.

Usage
-----
To use the module, add it to your application config. After that you must add
a method called "getLiquibasePath()" in the "Module.php" of every module
which supplies Liquibase updates. A simple example follows:

    namespace AwesomeModule;

    class Module
    {
        public function getLiquibasePath()
        {
            return __DIR__ '/db/master.xml';
        }
    }

As we are working with absolute paths here and Liquibase uses the full path
to identify each change set, you have to tell it a logical file path within all
of your change set files:

    <databaseChangeLog
        …
        logicalFilePath="awesome-module/master.xml"
    >
    </databaseChangeLog>

In this case, we are making a filename up from the module name and the actual
filename.

Aggregating all change sets
---------------------------
Before running Liquibase, you now have to create the aggregated file. To do
this, simply make the following call:

    php public/index.php bacon liquibase aggregate /path/to/output.xml
