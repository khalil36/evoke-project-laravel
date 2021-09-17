<?php

if ( ! class_exists( 'CD_SVG_Icons' ) ) {
	/**
	 * SVG ICONS CLASS
	 * Retrieve the SVG code for the specified icon. Based on a solution in Twenty Nineteen.
	 */
	class CD_SVG_Icons {
		
		public static function get_svg( $icon, $size = false ) {
			
			$arr = self::$icons;
			if(!$size){
				preg_match('/viewBox="([^"]+)"/', $arr[ $icon ], $match);
				if(isset($match[1]))
					list($a, $b, $size[0], $size[1]) = explode(' ', $match[1]);
			}
			if ( array_key_exists( $icon, $arr ) ) {
				$repl = sprintf('<svg class="svg-icon" width="%s" height="%s" aria-hidden="true" role="img" focusable="false" ', $size[0]?$size[0]:'20px',$size[1]?$size[1]:'20px');
				$svg  = preg_replace( '/^<svg /', $repl, trim( $arr[ $icon ] ) ); // Add extra attributes to SVG code.
				// $svg  = str_replace( '#', '%23', $svg );          // Urlencode hashes.
				$svg  = preg_replace( "/([\n\t]+)/", ' ', $svg ); // Remove newlines & tabs.
				$svg  = preg_replace( '/>\s*</', '><', $svg );    // Remove whitespace between SVG tags.
				return $svg;
			}
			return null;
		}


		public static $icons = [
			'phone' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 19.37 19.37"><defs><style>.cls-1{fill:#363636;}</style></defs><title>icon-phone</title><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><path class="cls-1" d="M19,15.4,16.84,14,14.93,12.7a.83.83,0,0,0-1.13.18L12.62,14.4a.85.85,0,0,1-1.08.22,13.65,13.65,0,0,1-3.84-3A13.6,13.6,0,0,1,4.75,7.82.83.83,0,0,1,5,6.75L6.49,5.57a.84.84,0,0,0,.18-1.14L5.44,2.58,4,.38A.85.85,0,0,0,2.83.12l-1.7,1A2.06,2.06,0,0,0,.19,2.36C-.27,4.05-.37,7.78,5.61,13.75s9.71,5.89,11.4,5.42a2.05,2.05,0,0,0,1.22-.94l1-1.69A.85.85,0,0,0,19,15.4Z"/></g></g></svg>',
			'pin' => '<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 11.67 15.17"><title>pin</title><path d="M5.83,0A5.83,5.83,0,0,0,0,5.83c0,3.22,5.83,9.34,5.83,9.34s5.84-6.12,5.84-9.34A5.84,5.84,0,0,0,5.83,0Zm0,7.58A2.08,2.08,0,1,1,7.92,5.5,2.08,2.08,0,0,1,5.83,7.58Z" style="fill:#f18700"/></svg>',
			'mail' => '<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18.43 12.1"><title>Artboard 1</title><rect x="1.14" y="1.32" width="15.68" height="10.78" style="fill:#fff"/><polyline points="0.37 0.85 8.98 7.49 18.06 0.48" style="fill:none;stroke:#004363;stroke-miterlimit:10;stroke-width:1.2198300000000002px"/></svg>',
			'facebook' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.37 20.74"><defs><style>.cls-2{fill:#fff;}</style></defs><title>icon-fb</title><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><g class="cls-1"><path class="cls-2" d="M6.48,7.13V4.54a1.3,1.3,0,0,1,1.3-1.3H9.07V0H6.48A3.89,3.89,0,0,0,2.59,3.89V7.13H0v3.24H2.59V20.74H6.48V10.37H9.07l1.3-3.24Z"/></g></g></g></svg>',
			'twitter' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18.49 15.02"><defs><style>.cls-2{fill:#fff;}</style></defs><title>icon-tw</title><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><g class="cls-1"><path class="cls-2" d="M18.49,1.78a8.07,8.07,0,0,1-2.19.6A3.76,3.76,0,0,0,18,.28a7.43,7.43,0,0,1-2.4.92A3.79,3.79,0,0,0,9,3.79a4.14,4.14,0,0,0,.09.87,10.75,10.75,0,0,1-7.81-4A3.8,3.8,0,0,0,2.45,5.76,3.83,3.83,0,0,1,.74,5.29v0a3.8,3.8,0,0,0,3,3.72,3.61,3.61,0,0,1-1,.13,3.44,3.44,0,0,1-.72-.06,3.85,3.85,0,0,0,3.55,2.64,7.67,7.67,0,0,1-4.7,1.61,6.85,6.85,0,0,1-.91,0A10.69,10.69,0,0,0,5.81,15,10.71,10.71,0,0,0,16.6,4.24c0-.17,0-.33,0-.49A7.74,7.74,0,0,0,18.49,1.78Z"/></g></g></g></svg>',
			'linkedin'=>'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16.17 16.17"><defs><style>.cls-2{fill:#fff;}</style></defs><title>icon-ln</title><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><g class="cls-1"><path class="cls-2" d="M16.16,16.17h0V10.24c0-2.9-.63-5.14-4-5.14A3.52,3.52,0,0,0,9,6.85H8.93V5.37H5.72v10.8H9.07V10.82c0-1.4.26-2.77,2-2.77s1.74,1.61,1.74,2.86v5.26Z"/><path class="cls-2" d="M.27,5.37H3.62v10.8H.27Z"/><path class="cls-2" d="M1.94,0a2,2,0,0,0,0,3.9,2,2,0,0,0,0-3.9Z"/></g></g></g></svg>',
			'instagram'=>'<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15.91 15.91"><defs><style>.cls-1{fill:#fff;}</style></defs><title>instagram</title><path class="cls-1" d="M11.32,0H4.59A4.6,4.6,0,0,0,0,4.59v6.73a4.6,4.6,0,0,0,4.59,4.59h6.73a4.6,4.6,0,0,0,4.59-4.59V4.59A4.6,4.6,0,0,0,11.32,0Zm3.12,11.43a3,3,0,0,1-3,3.05H4.51a3,3,0,0,1-3-3.05V4.55a3.06,3.06,0,0,1,3.05-3h6.88a3,3,0,0,1,3,3.05Z"/><path class="cls-1" d="M8,3.87A4.13,4.13,0,1,0,12.08,8,4.11,4.11,0,0,0,8,3.87Zm0,6.8A2.68,2.68,0,1,1,10.63,8,2.68,2.68,0,0,1,8,10.67Z"/><path class="cls-1" d="M12.22,2.75a1,1,0,1,0,1,1,1,1,0,0,0-1-1Z"/></svg>',
			'search' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17"><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><path d="M16.81,15.87l-4.15-4.15a7.16,7.16,0,1,0-.94.94l4.15,4.15a.68.68,0,0,0,.94,0A.68.68,0,0,0,16.81,15.87ZM1.32,7.16A5.84,5.84,0,1,1,7.16,13,5.85,5.85,0,0,1,1.32,7.16Z" style="fill:#363636"/></g></g></svg>',
			'filter' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15.67 15.17"><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><line x1="2.26" y1="13.03" x2="2.26" y2="15.17" style="fill:none;stroke:#666;stroke-miterlimit:10;stroke-width:0.666240025172049px"/><line x1="2.26" x2="2.26" y2="9.19" style="fill:none;stroke:#666;stroke-miterlimit:10;stroke-width:0.666240025172049px"/><circle cx="2.26" cy="11.11" r="1.92" style="fill:none;stroke:#666;stroke-miterlimit:10;stroke-width:0.666240025172049px"/><line x1="7.83" y1="6.55" x2="7.83" y2="15.17" style="fill:none;stroke:#666;stroke-miterlimit:10;stroke-width:0.666240025172049px"/><line x1="7.83" x2="7.83" y2="2.7" style="fill:none;stroke:#666;stroke-miterlimit:10;stroke-width:0.666240025172049px"/><circle cx="7.83" cy="4.62" r="1.92" style="fill:none;stroke:#666;stroke-miterlimit:10;stroke-width:0.666240025172049px"/><line x1="13.41" y1="13.03" x2="13.41" y2="15.17" style="fill:none;stroke:#666;stroke-miterlimit:10;stroke-width:0.666240025172049px"/><line x1="13.41" x2="13.41" y2="9.19" style="fill:none;stroke:#666;stroke-miterlimit:10;stroke-width:0.666240025172049px"/><circle cx="13.41" cy="11.11" r="1.92" style="fill:none;stroke:#666;stroke-miterlimit:10;stroke-width:0.666240025172049px"/></g></g></svg>',
			'arrow-down' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.33 5.66"><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><polyline points="9.83 0.5 5.17 5.17 0.5 0.5" style="fill:none;stroke:#ff8000;stroke-linecap:round;stroke-linejoin:round"/></g></g></svg>',
		];
	}
}
