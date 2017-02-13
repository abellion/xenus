*Documentation is in WIP.*

# Xenus : An elegant Mongodb mapper for PHP 7

Simple Object Document Mapper for the new mongodb driver. It's based on :
- https://github.com/mongodb/mongo-php-driver The new mongodb driver.
- https://github.com/mongodb/mongo-php-library The new mongodb library.

**It's a WIP project. Somme great features will come for 1.0 but the MVP works well.**

## Features

- Basic mapping between database and *Document* class
- Configurables Getters and Setters (CamelCase by default)
- *Document* serialization as Json or Http (you can add your owns)
- *Collection* class whith a simple API to set the collection name

## Roadmap

- Test the code
- Comment the code
- Add more mutators (currently only CamelCase is supproted for getters / setters names)
- Declare collection indexes in the *Collection* class and trigger them through a binary
- Make a binary that auto-clean the database based on the documents schema
- Add default fields "created_ad" and "updated_at" to the *Document* class
- Find a fluent way to assign a default value to *Document* attributes
- Provide some default methods to the *Collection* class (as ```get()```, ```add()```, ...)
