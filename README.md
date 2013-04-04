# pauladamdavis.com

Note: This is generally hacked together over a long time with no specific goals.<br>The code is messy. My client work is much cleaner, rest assured.

# Todo

* Implament category & date archives and search results the same way the main blog listing/archive is done
* Change text from `px` to `rem` and `px` fallback
* Kill any errors that PHP throws up
* Add RSS feed widget for public GitHub commits with links
* Maybe add counter showing total number Git commits i've made, public & private?

# Changelog

### V1 - 2-4-2013

* Added `link` and `aside` post formats.
* Cleaned CSS and other bits of code.

---

Bits of code I may need

    $year = $wp_query->query_vars['year'];
    $month = $wp_query->query_vars['monthnum'];
