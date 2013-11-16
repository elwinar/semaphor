# semaphor

A PHP CLI tool to get eve central data

## Setup

First, retrieve the packages needed by the tool.

`composer install`

Then, grab the latest EVE Online database (Odyssey at the moment of writing) and put in a database. Then, edit the `app\App.php`, and set the connection of the `Capsule`  manager. See [here](https://github.com/illuminate/database) to get more detailled doc about database configuration.

## Usage

Semaphor is a simple CLI tool, so there isn't that many options (only the most useful ones) :

- `--systems, -s` lets you indicate the system where you want your data from. You can give multiple systems, there will all be fetched,
- `--items, -i` lets you indicate which items you want to retrieve price from. As for systems, multplie value authorized. See below for the items expressions syntax,
- `--percentile, -p` enables you to retrieve the percentile prices instead of the min-max ones, to eliminate extremes;

## Item expressions

An item expression lets you select multiple market types at once by describing a path into the market group hierarchy. There is 4 tokens that you can use :

- `group name` lets you filter by market group name (`%` can be used as wildcard)
- `/` lets you go down one step in the hierarchy
- `*` select all children of the current selection
- `**` select all descendants of the current selection

If the expression begins with a `/`, the search will begin from the root of the hierarchy. Else, it will start from all groups that match the given name. The selected market types will be all types belonging to the selected market groups.

In addition, you can filter type names by adding `>type name` (with the same wildcard as for groups).

Examples :

- `/Ships/**/Amarr` will search all Amarr ships, but will exclude blueprints,
- `/Ship Modules>%II` will get all T2 modules;
