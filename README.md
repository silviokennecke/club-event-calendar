# Club Event Calendar

[![Symfony](https://github.com/silviokennecke/club-event-calendar/actions/workflows/symfony.yml/badge.svg)](https://github.com/silviokennecke/club-event-calendar/actions/workflows/symfony.yml)

This project provides a web application helping clubs to plan events and distribute them to their members.

## Features

* Manage events
* Create events based on templates
* Draft events before publishing
* Add properties and target groups to events
* Export the events into a ICS file
* Export the events into a PDF file
* Allow you r members to subscribe to only the events they are interested in

## Installation

To install this project, you can simply clone this repository and run the following commands.
This section will be extended, later in this project.

```bash
# update configuration
cp .env.dist .env.local
nano .env

# install everything
composer install
bin/console doctrine:database:create
bin/console doctrine:migrations:migrate

# create user
bin/console app:user:create
```

## Contribution

Contribution is always welcome.
Before we are able to merge your contribution, you need to sign the Contributor License Aggreement ([CLA.md](CLA.md)).
By doing so, you basically confirm that you are owner of the code.
Also, you are granting us permission to use your code as described in the CLA.

## License

This project is licensed under GPL 3.0.
You can find more information about the licensing in [LICENSE.md](LICENSE.md).
