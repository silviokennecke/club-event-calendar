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
* Allow your members to subscribe to only the events they are interested in

## Installation

To install this project, you can simply clone this repository and run the following commands.
This section will be extended, later in this project.

```bash
# update configuration
cp .env .env.local
nano .env.local

# install everything
composer install
bin/console doctrine:database:create
bin/console doctrine:migrations:migrate

# create user
bin/console app:user:create
```

## External services / Fair use policy

This project uses different external APIs and services to provide its full functionality.
You can replace all of them with your own services or disable those features completely.

However, if you use the services provided by this project, you **must** follow their usage policies.

Please note that most of the services are run on donated and limited resources.
Be fair and do not abuse these.
If you do not follow the usage policies, you might get blocked from the services.

### Geocoder

This uses the project uses the [Geocoder PHP Library](https://geocoder-php.org/) to geocode addresses.

By default, this project uses the Nominatim service provided by OpenStreetMap.
Please check their [usage policy](https://operations.osmfoundation.org/policies/nominatim/) before using this service.

For now, we only support Nominatim.
However, we plan to add support for other [services](https://geocoder-php.org/docs/#address) in the future.

If you cannot guarantee to follow the usage policy of Nominatim, you can turn [host your own instance](https://nominatim.org/release-docs/latest/admin/Installation/) of disable geocoding completely.

```dotenv
# disable geocoding
GEOCODER_PROVIDER=null
```

```dotenv
# use a different service (e.g. self-hosted Nominatim)
GEOCODER_PROVIDER=nominatim
GEOCODER_ROOT_URL=https://nominatim.example.com
```

### Maps

For some features, this project displays maps to the user.

By default, this project uses the map tiles provided by OpenStreetMap.
Please check their [usage policy](https://operations.osmfoundation.org/policies/tiles/) before using this service.

If you cannot or do not want to use the map tiles, provided by OpenStreetMaps we recommend to self-host a mirror or use a different tiles provider.

Other map tiles providers are for example:
* [OpenMapTiles](https://openmaptiles.org/) (self-hosted)
* [Mapbox](https://www.mapbox.com/)
* [Here Maps](https://developer.here.com/pricing)

## Privacy / GDPR compliance

This project is designed to be GDPR compliant.

The project itself does not collect any usage data.
The only personal data collected are the users, which are stored in the database.
Please note that your web server might collect usage data where you need to inform your users about.

However, for the full feature set, we need to use external services.
Please check their privacy policies before using them.
You can find more information about the external services in the [External services](#external-services--fair-use-policy) section.

## Contribution

Contribution is always welcome.
Before we are able to merge your contribution, you need to sign the Contributor License Aggreement ([CLA.md](CLA.md)).
By doing so, you basically confirm that you are owner of the code.
Also, you are granting us permission to use your code as described in the CLA.

## License

This project is licensed under GPL 3.0.
You can find more information about the licensing in [LICENSE.md](LICENSE.md).
