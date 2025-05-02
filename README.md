<p align="center">
    <h1 align="center">Symfony Weather Example</h1>
    <br>
</p>

DIRECTORY STRUCTURE
-------------------

      .docker/            contains docker configuration files
      assets/             contains js and css files
      config/             contains application configurations
      public/             contains the entry script and Web resources
      src/                contains source of application
        Application/      contains application context files
        Shared/           contains shared context files
        Weather/          contains weather context files
      templates/          contains templates and view files
      tests/              contains various tests

REQUIREMENTS
------------

Docker version 28.0.4, build b8034c0

Docker Compose version v2.34.0

INSTALLATION
------------

### Install via GIT

<h5>1. Clone project repository</h5>

```
git clone git@github.com:Vitaly-B/weather.git example-weather
```

<h5>2. Build docker containers</h5>

```
cd  example-weather
```

```
docker-compose up -d --build
```

### Usage
<h5>UI entry point</h5>

[http://localhost](http://localhost)

<h5>API GET /api/weather/current</h5>

curl --location 'http://localhost/api/weather/current?city=Kyiv' \
--header 'Cookie: XDEBUG_SESSION=XDEBUG_ECLIPSE'

### API Documentation

[src/Weather/Ports/Http/Api/docs/openapi.yaml](src/Weather/Ports/Http/Api/docs/openapi.yaml)

TESTING
-------

<h5>Run PHPUnit tests</h5>

```
make test
```
