## What?

The CollapsibleSections extension puts all sections in a page into mw-collapsible divs.

## Why?

We wanted them for TOPO Wiki instead of manually creating them in the wikitext or using templates.  Uses the ParserAfterTidy hook to look for <h*> tags and create divs to surround them and their content, lasting until the next heading of the same level.

## Download

Clone from GitHub at https://github.com/emanspeaks/CollapsibleSections

## Installation

To install this extension, add the following to LocalSettings.php:

```
require_once "$IP/extensions/CollapsibleSections/CollapsibleSections.php";
```
 
## Configuration

###Namespaces
By default, the extension will work in all namespaces.  If however, you wish to only enable for specific namespaces, add a line to your LocalSettings.php similar to the following:

```
$csNamespaces[] = NS_PROJECT;
```
###Custom class strings
A custom string can be appended to the class string applied to the outer div.  This is so that other style in addition to the mw-collapsible may be added to the wrapper tags.  The class string is specified by adding a line to your LocalSettings.php similar to the following:

```
$csClasses = "tchb-box";
```

## License

GNU Affero General Public License, version 3 or any later version. See AGPL-3.0.txt file for the
full license text.

## Links

* License page:   https://www.gnu.org/licenses/agpl.html
