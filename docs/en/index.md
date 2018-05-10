# CORS proxy

## How to use

The CORS proxy service expects you provide the URL of 3rd party service/page in `url` HTTP GET parameter by default. HTTP method used when accessing this endpoint is used in subsequent HTTP request.

A final cross-domain request URL via the CORS proxy service can be handled, looks something like this:

```
https://cors-proxy.htmldriven.com.localhost/?url=https://www.htmldriven.com/sample.json
````

## Setup

Read the following section if you want to run the CORS proxy on your own webserver.

### Requirements

Please, check the [composer.json](../../composer.json) file or [packagist.org](https://packagist.org/packages/htmldriven/cors-proxy) to see the current list of requirements in terms of packages which are required by [composer](https://getcomposer.org/).
Except for PHP version >=5.6 with CURL extension being installed, there are no more odd requirements

### Installation

The best way to install the CORS proxy is using the composer. You can do that using the following command:

```sh
$ composer create-project htmldriven/cors-proxy my-cors-proxy
```

*Note that my-cors-proxy in the command above is the name of target directory for newly created CORS proxy project, so this name is totally up to you.*

Then, create a destination database using the [cors-proxy.sql](../../app/database/cors-proxy.sql) initialization script.

### Configuration

If you need, you can customize the CORS proxy by creating custom `config.ini` file. This file must be located at [app/config](../../app/config) directory.
There's already [config.sample.ini](../../app/config/config.sample.ini) file, which you can just copy and edit some parts of it to match your needs.

There are several config items which you can change. The following list shows all supported options:

- `urlParameterName = url` - name of URL HTTP GET parameter name
- `userAgent = htmldriven/cors-proxy 1.0` - HTTP User-Agent string which is used during cross-domain requests
- `templateFile = app/templates/default/frontend.phtml` - path to main front-end page template file
- `sitemapPath = /sitemap.xml` - URL path to sitemap file
- `sitemapTemplateFile = app/templates/default/sitemap.pxml` - path to sitemap XML template file
- `errorTemplateFile = app/templates/default/error.phtml` - path to error template file
- `timezone = UTC` - default PHP timezone settings used for DateTime instances
- `database = ...` - database connection settings

## License

CORS proxy is totally free as it's available and being distributed under [The MIT License](../../LICENSE).
