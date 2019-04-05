# Force Download plugin for Craft CMS 3.x

![Screenshot](resources/img/plugin-logo.png)

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require theskyfloor/force-download

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Force Download.

## Force Download Overview

Simple action to force downloading of an asset by ID without any user/permissions checks.

## Using Force Download

    {{craft.forceDownload.downloadUrl(assetId)}}

    <a href="{{craft.forceDownload.download(assetId)}}">Download</a>

## Force Download Roadmap

Log downloads

* Release it

Brought to you by [Alan Miller](http://www.theskyfloor.com)
