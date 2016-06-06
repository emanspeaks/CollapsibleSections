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

		$doc = new DOMDocument();
		$doc->loadHTML($text);
		
		//do some cleanup to get back to just the tags from the text
		//adapted from http://stackoverflow.com/questions/10416704/remove-parent-element-keep-all-inner-children-in-domdocument-with-savehtml
		
		// Remove doctype node
		$doc->doctype->parentNode->removeChild($doc->doctype);
		// Remove html element, preserving child nodes
		$html = $doc->getElementsByTagName("html")->item(0);
		/*
		$fragment = $doc->createDocumentFragment();
		while ($html->childNodes->length > 0) $fragment->appendChild($html->childNodes->item(0));
		$html->parentNode->replaceChild($fragment, $html);
		*/
		// Remove body element, preserving child nodes
		$body = $doc->getElementsByTagName("body")->item(0);
		$fragment = $doc->createDocumentFragment();
		while ($body->childNodes->length > 0) $fragment->appendChild($body->childNodes->item(0));
		//$body->parentNode->replaceChild($fragment, $body);
		$html->parentNode->replaceChild($fragment, $html);

		//wrapping solution
		//adapted from http://stackoverflow.com/questions/10703057/wrap-all-html-tags-between-h3-tag-sets-with-domdocument-in-php
		
		for ($i = 1; $i < 7; $i++){
			// Grab a nodelist of all h tags
			$nodes = $doc->getElementsByTagName("h$i");

			// Iterate over each of these h nodes
			foreach ($nodes as $index => $h) {
				//first check if it's in an mw:toc...if so, skip it
				$x = $h;
				while ($x = $x->parentNode) if ($x->localName === "toc") continue 2;
				
				// Create an outer div node that we'll use as our wrapper
				$div1 = $doc->createElement("div");
				$div1->setAttribute("class", "mw-collapsible");
				// Create the inner div node used for the content
				$div2 = $doc->createElement("div");
				$div2->setAttribute("class", "mw-collapsible-content");
				
				// Move next siblings of h until we hit another h
				while ($h->nextSibling && $h->nextSibling->localName !== "h$i") $div2->appendChild($h->nextSibling);
				
				//find next h node and parent
				$next = $h->nextSibling;
				$parent = $h->parentNode;
				
				// Add h node and inner to the outer div
				$div1->appendChild($h);
				$div1->appendChild($div2);
				
				// Add the outer div node right before next h, if it exists
				if ($next) $parent->insertBefore($div1,$next); else $parent->appendChild($div1);
			}
		}

		$text = $doc->saveHTML();
		file_put_contents("/opt/meza/htdocs/wikis/topo/images/text.txt",$text,FILE_APPEND);
		return true;

	} // function onParserAfterTidy


} // class CollapsibleSections


// end of file //
