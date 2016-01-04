# CQS Framework +

## Build
* Clone this repo locally
* `composer install`
* `npm install` (make sure your npm is up to date `npm install -g npm`)
* Copy `extras/.env.sample` to `.env` and fill in appropriately
* `php artisan migrate --seed`
* If you are using a webserver which assumes `public_html` you'll need to create a symlink to the `public` folder `ln -s public public_html`
* `gulp` or `gulp watch` or `gulp --production`
* Done

## Test
### Running Tests
Testing can be executed locally as well as within the CI chain. 
In order to run tests locally a script is provided to make it easy: `./runlocaltests.sh` (You may need to `chmod -x ./runlocaltests.sh` first). Have a look inside that file to see what it does.

Acceptance tests will attempt to connect to a url defined in `tests\acceptance.suite.yml` to perform real in-browser testing. As this domain doesn't map to anything useful when working locally it needs to be proxied. This can be achieved using a BrowserStack binary from [here](https://www.browserstack.com/local-testing#command-line).

### Writing Tests
Tests should be written for all new commands and queries added to the project. Tests live in the `tests` folder in the project root. Tests are split into:
* Unit
* Functional
* API
* Acceptance

See examples in those folders for formats and available functionality.

The testing framework is CodeCeption and therefore functionality described on their website is available. It is also possible to copy PHPUnit extension code from the Laravel testing framework. A superclass exists which can hold extra functionality for all tests: `tests/unit/ExtendedTest.php`.

## Artisan Commands
Several artisan commands exist for frequent in-framework jobs:
* Create a new command: `jobs:makeCommand {name} {--prop= } {--async} {--authoriser} {--validator}`
* Create a new query: `jobs:makeQuery {name} {--prop= } {--authoriser} {--validator}`
* Download and update the Maxmind GeoIP database: `updateGeoDB`

## Contribute (for work)
All contributions must be made on branches off the latest commit on `master`, or, if the contribution relies on an existing branch which has not yet been merged, it can be branched from the latest commit on the required branch. 

All branches should be based on an issue in the project issue tracker. The format of branch names should follow: `issue/#issue-short-description`. For example `issue/8-create-readme`. If a feature, issue or bug is identified that does not have an associated issue in the issue tracker, one should be created that the new branch can reference.

A merge request back into the `master` branch can be made at any time in order to request feedback on branch progress. Any merge requests made from branches that are not considered complete should have a title prepended with `[WIP]` which will prevent GitLab allowing the merge to proceed.

Once a branch is ready to be merged `[WIP]` should be removed and the merge requestor should notify relevant developers to perform a code review. **Any developer is free to review and comment on any merge request and leave a +1 or -1.** After one or more reviews from other developers, and if the CI tests are passing, a developer should express their intention to perform the merge request, and then do so if there are no objections.

If a branch is ready to be merged, but `master` has diverged from the branch, the branch author is responsible for pulling the updated `master`, merging into their branch and fixing any conflicts, before the merge request is accepted.

## Deploy (for work)
Once a merge request into `master` has been accepted the CI server will automatically build the resulting master commit. If all tests pass (they should always pass as this commit should be identical to the HEAD of the branch) the build will automatically be deployed to staging.

Once a build is available on staging it should be auto acceptance tested and manually checked as appropriate.

_The following is subject to change based on hosting_

If everything has gone well up until this point the code is ready to be released to production! The commit to be released should be tagged with an appropriate version number and then merged into the `production` branch. This will, once again, perform a CI build which, if successful, will deploy the code to production (yet to be implemented).

:tada::rocket: