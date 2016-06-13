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
		
		global $csNamespaces;
		global $csClasses;
		
		//is the current namespace in the enabled list?
		if (empty($csNamespaces) || in_array($parser->getTitle()->getNamespace(),$csNamespaces)) {
			// store any namespaced elements so we can re-add them later 
			// adapted from http://stackoverflow.com/questions/10985443/php-domdocument-namespaces
			$text = preg_replace('/<(\w+):(\w+)/', '<\2 namespace="\1"' , $text); 
			$text = preg_replace('/<\/\w+:(\w+)>/', '</\1>' , $text); 
			
			$doc = new DOMDocument();
			
			//unicode fix
			//adapted from http://stackoverflow.com/questions/15704144/php-domdocument-is-not-rendering-unicode-characters-properly
			$doc->loadHTML(mb_convert_encoding($text , 'HTML-ENTITIES', 'UTF-8'));
			
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
					$div1->setAttribute("class", "mw-collapsible ".$csClasses);
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

			
			
			//do some cleanup to get back to just the tags from the text
			// adapted from http://php.net/manual/en/domdocument.savehtml.php
			$text = preg_replace('/^<!DOCTYPE.+?>/', '', str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $doc->saveHTML()));
			
			// re-construct any namespaced tags 
			// adapted from http://stackoverflow.com/questions/10985443/php-domdocument-namespaces
			$text = preg_replace('/<(\w+)([^>]*) namespace="(\w+)"([^>]*)>(.*?)<\/\1>/s', '<\3:\1\2\4>\5</\3:\1>', $text);
		}
		
		return true;

	} // function onParserAfterTidy


} // class CollapsibleSections


// end of file //
