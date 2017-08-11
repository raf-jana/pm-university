<?php

if (!function_exists('class_active_post')) {
    /**
     * @param $key
     * @return string
     */
    function class_active_post($key): string
    {
        return $key === 0 ? 'active ' : '';
    }
}

if (!function_exists('random_pic')) {
    /**
     * @param string $dir
     * @return string
     */
    function random_pic($dir = 'uploads')
    {
        if ($files = glob($dir . '/*.*')) {
            $file = array_rand($files);
            return $files[$file];
        }
        return null;
    }
}

if (!function_exists('fullTitle')) {
    /**
     * @param string $pageTitle
     * @return string
     */
    function fullTitle($pageTitle = ''): string
    {
        if (!$pageTitle) {
            return config('app.name');
        }
        return config('app.name') . ' | ' . $pageTitle;
    }
}

if (!function_exists('now')) {
    function now()
    {
        return \Carbon\Carbon::now();
    }
}

if (!function_exists('get_youtube_video_id')) {
    /**
     * Parse Youtube video and get the video id
     */
    function get_youtube_video_id($link): string
    {
        $regexstr = '~
		# Match Youtube link and embed code
		(?:                             # Group to match embed codes
		    (?:<iframe [^>]*src=")?       # If iframe match up to first quote of src
		    |(?:                        # Group to match if older embed
			(?:<object .*>)?      # Match opening Object tag
			(?:<param .*</param>)*  # Match all param tags
			(?:<embed [^>]*src=")?  # Match embed tag to the first quote of src
		    )?                          # End older embed code group
		)?                              # End embed code groups
		(?:                             # Group youtube url
		    https?:\/\/                 # Either http or https
		    (?:[\w]+\.)*                # Optional subdomains
		    (?:                         # Group host alternatives.
		    youtu\.be/                  # Either youtu.be,
		    | youtube\.com              # or youtube.com
		    | youtube-nocookie\.com     # or youtube-nocookie.com
		    )                           # End Host Group
		    (?:\S*[^\w\-\s])?           # Extra stuff up to VIDEO_ID
		    ([\w\-]{11})                # $1: VIDEO_ID is numeric
		    [^\s]*                      # Not a space
		)                               # End group
		"?                              # Match end quote if part of src
		(?:[^>]*>)?                       # Match any extra stuff up to close brace
		(?:                             # Group to match last embed code
		    </iframe>                 # Match the end of the iframe
		    |</embed></object>          # or Match the end of the older embed
		)?                              # End Group of last bit of embed code
		~ix';
        preg_match($regexstr, $link, $matches);
        return $matches [1];
    }
}

if (!function_exists('make_youtube_url')) {
    /**
     * @param $link
     * @return string
     */
    function make_youtube_url($link): string
    {
        return 'https://www.youtube.com/embed/'
        . get_youtube_video_id($link)
        . '?rel=0&amp;controls=0&amp;showinfo=0';
    }
}

