# Release Process

The package is distributed via packagist.

TODO: Ensure versioning to packagist distribution.

```bash
$ ./avro-to-php app:build avro-to-php    # Specify a version and build.
$ git commit -m '<release message>'
$ git tag <version>                      # Tag with version. 
$ git push && git push --tags
```