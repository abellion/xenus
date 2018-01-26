# 0.10

- The `Xenus\Document::embed()` method has been removed. Use the `Xenus\Support\Embed` utility instead.
- The `Xenus\Support\Embed` utility has been added.
- The `Xenus\Support\Transform` utility has been added.

# 0.9

- The `Xenus\Collection` class now ineriths from the `MongoDB\Collection` class.
- The `Xenus\Collection\CRUDMethods` has been removed and its methods have moved into the `Xenus\Collection` class.
- The `Xenus\Collection::findOne()`, `Xenus\Collection::updateOne()`, `Xenus\Collection::deleteOne()` and `Xenus\Collection::replaceOne()` methods can take a `MongoDB\BSON\ObjectID` as a filter argument.
- The `Xenus\Document` type hint has been removed from the  `Xenus\Collection::insert()`, `Xenus\Collection::update()` and `Xenus\Collection::delete()` methods.

# 0.8

- The `Xenus\Document::get()` method can take as a second argument the default value to give in case the given key doesn't exist within the document.
