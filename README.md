# VRPilot
![](https://img.shields.io/github/package-json/v/oliverbooth/vr-pilot.svg)
![](https://img.shields.io/github/license/oliverbooth/vr-pilot.svg)
![](https://img.shields.io/github/issues/oliverbooth/vr-pilot.svg)
![](https://img.shields.io/david/dev/oliverbooth/vr-pilot.svg)

PHP TV station control panel.

## About
VRPilot is a sophisticated web tool based on [AWDigie](oliverbooth/awdigie) originally written by Pineriver*, providing users of [Active Worlds](https://activeworlds.com/), [Virtual Paradise](https://virtualparadise.org/), and similar platforms, the ability to control and monitor TV stations created from automated PHP image rotation. The platform supports live broadcasting, predefined programming, watermarking, among other features.

*\* Real name withheld*

## Download
Grab the [latest release](oliverbooth/vr-pilot/releases), or you can build from source using the instructions below.

## Runtime Prerequisites
The server host must be running PHP v7.x or above, and have the [`libGD`](https://www.php.net/manual/en/book.image.php) module installed and enabled.

Usage of the control panel requires a JavaScript enabled browser.

## Dependencies
* [node](https://nodejs.org/) / npm
* PHP v7.x in `PATH`

## Building
```bash
$ npm install
$ gulp clean
$ gulp
```

Output files will appear in the `dist` directory.

# Usage
To use this in [Active Worlds](https://activeworlds.com/) or [Virtual Paradise](https://virtualparadise.org/), apply this action to an object that supports images:

```
create picture <url>/tv.php update=<n>
```

where \<url\> is the path to your webserver, and \<n\> is recommended to be 5.
