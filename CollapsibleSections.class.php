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

		//file_put_contents("/opt/meza/htdocs/wikis/topo/images/pretext.txt",$text,FILE_APPEND);

		for ($i = 1; $i < 7; $i++) {
			$last = 0;
			$open = stripos($text, "<h$i");
			while ($open !== false) {
				//$pretext = $text;
				$close = stripos($text, "</h$i>", $open);
				$text = substr($text,0,$open) . (($last>0)? '</div></div>' : '') . '<div class="mw-collapsible">' . substr($text,$open,$close-$open+5) . 
					'<div class="mw-collapsible-content">' . substr($text,$close+5);
				$last = $close+5;
				$open = stripos($text, "<h$i", $last);
			}
			if ($last>0) $text .= '</div></div>';
		}

		//file_put_contents("/opt/meza/htdocs/wikis/topo/images/text.txt",$text,FILE_APPEND);
		return true;

	} // function onParserAfterTidy


} // class CollapsibleSections


// end of file //
