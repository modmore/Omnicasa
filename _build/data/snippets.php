<?php

return [
    'omnicasa.list' => [
        'description' => 'Lists all properties available in Omnicasa.',
        'file' =>  'list.snippet.php',
    ],
    'omnicasa.single' => [
        'description' => 'Renders a single property detail page. Route requests to a template resource with a server-level rewrite, and use this snippet uncached.',
        'file' =>  'single.snippet.php',
    ],
    'omnicasa.propertyTypes' => [
        'description' => 'Renders a list of property types based on available properties. The selected ID should be submitted as WebID to filter the list snippet.',
        'file' =>  'propertyTypes.snippet.php',
    ],
    'omnicasa.cities' => [
        'description' => 'Renders a list of cities based on available properties. Provide as City to filter in omnicasa.list.',
        'file' =>  'cities.snippet.php',
    ],
    'omnicasa.propertyRedirect' => [
        'description' => 'Redirect a request to either the error page or the friendly alias for a property. Expects a "property" URL parameter.',
        'file' =>  'propertyRedirect.snippet.php',
    ],
];
