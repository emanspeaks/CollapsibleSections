<?php // CollapsibleSections.class.php //

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

class CollapsibleSections {

	// put sections in a page into mw-collapsible divs
	static function onParserAfterTidy( &$parser, &$text ) {

		for ($i = 1; $i < 7; $i++) {
			$x = 0;
			$n = stripos($text, "<h$i");
			while ($n !== false) {
				$text = substr($text,0,$n) . ($x>0)? '</div>' : '' . '<div class="mw-collapsible">' . substr($text,$n);
				$n = stripos($text, "<h$i", $n+31+$x);
				$x = 6;
			}
			if ($x>0) $text .= '</div>';
		}

		return true;

	} // function onParserAfterTidy


} // class CollapsibleSections

// end of file //
