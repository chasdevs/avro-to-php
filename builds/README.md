# Release Process

The package is distributed via packagist.

TODO: Ensure versioning to packagist distribution.

```bash
$ ./avro-to-php app:build avro-to-php    # Specify a version and build.
$ git commit -am '<release message>'
$ git tag <version>                      # Tag with version. 
$ git push && git push --tags
```

### Local Development

First, symlink the development version of the app to builds/avro-to-php (so it will be added to the _vendor/bin_ folder in the client)*[]: 
Then, add this directory as a repository in the client's composer.json, then require with "@dev":

```bash
$ cd builds; rm -f avro-to-php; ln -s ../avro-to-php ./avro-to-php    # Symlink to development version.
$ cd <other project>; composer require chasdevs/avro-to-php:@dev      # Ensure that the symlinked directory is now in the vendor folder.
```