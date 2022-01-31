# Contributing

When contributing to this repository, please first discuss the change you wish to make via issue,
email, or any other method with the owners of this repository before making a change. 

## Pull Request Process

1. Protect your changes with a new or modified unit test.
1. Ensure tests pass locally when running `make test`.
1. Update the README.md with details of changes to the interface.
1. The PR will be merged by one of the repository collaborators.

## Release Process

1. A collaborator will update the version number in Makefile and then run `make release`, which will add a new commit and tag to github/packagist, and then build/publish a new image to Dockerhub.