<?php // CollapsibleSections.php //

/*
	------------------------------------------------------------------------------------------------
	CollapsibleSections, a MediaWiki extension to put sections in a page into mw-collapsible divs.

	This program is free software: you can redistribute it and/or modify it under the terms
	of the GNU Affero General Public License as published by the Free Software Foundation,
	either version 3 of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
	without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
	See the GNU Affero General Public License for more details.

	You should have received a copy of the GNU Affero General Public License along with this
	program.  If not, see <https://www.gnu.org/licenses/>.
	------------------------------------------------------------------------------------------------
*/

if ( ! defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}; // if

$extCollapsibleSectionsDir = defined( __DIR__ ) ? __DIR__ : dirname( __FILE__ ) ;

global $wgAutoloadClasses;
$wgAutoloadClasses[ 'CollapsibleSections' ] = $extCollapsibleSectionsDir . '/CollapsibleSections.class.php';

global $wgHooks;
$wgHooks[ 'ParserAfterTidy' ][] = 'CollapsibleSections::onParserAfterTidy';

global $wgExtensionCredits;
$wgExtensionCredits[ 'other' ][] = array(
	'path'    => __FILE__,
	'name'    => 'CollapsibleSections',
	'license' => 'AGPLv3',
	'version' => '0.1',
	'author'  => 'Randy Eckman',
	'url'     => 'https://github.com/emanspeaks/CollapsibleSections',
	'descriptionmsg'  => 'Puts sections in a page into mw-collapsible divs.',
);

global $csNamespaces;
$csNamespaces = [];

unset( $extCollapsibleSectionsDir );

// end of file //
